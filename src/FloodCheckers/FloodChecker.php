<?php

namespace GooberBlox\FloodCheckers;

use Cache;
use Carbon\CarbonImmutable;
use RateLimiter;

class FloodChecker
{
    private const DEFAULT_LIMIT = 10;
    private const DEFAULT_EXPIRY_SECONDS = 3600;

    protected readonly string $cacheKey;
    protected readonly int $limit;
    protected readonly int $expirySeconds;
    protected readonly bool $enabled;
    protected readonly ?string $category;

    public function __construct(string $category ,string $keyName, ?int $limit = null, ?int $expiry = null, ?bool $enabled = null) {
        $this->category = $category;
        $this->cacheKey = $keyName;
        $this->limit = $limit ?? self::DEFAULT_LIMIT;
        $this->expirySeconds = $expiry ?? self::DEFAULT_EXPIRY_SECONDS;
        $this->enabled = $enabled ?? true;
    }

    public function getCount() : int
    {
        if(!$this->enabled)
            return 0;

        return max(0, $this->rawAttempts());
    }

    public function getCountOverLimit() : int
    {
        if(!$this->enabled)
            return 0;

        return max(0, $this->getCount() - $this->limit);
    }

    public function check() : FloodCheckerStatus
    {
        $isFlooded = false;
        $count = 0;
        if($this->enabled)
        {
            $count = $this->getCount();
            $isFlooded = $count >= $this->limit;
        }

        return new FloodCheckerStatus($isFlooded, $this->limit, $count, $this->category ?? $this->cacheKey);
    }

    public function isFlooded() : bool
    {
        return $this->check()->isFlooded;
    }

    public function updateCount() : void
    {
        if(!$this->enabled)
            return;

        $this->primeTimer();
        RateLimiter::increment($this->cacheKey);
    }

    public function reset() : void
    {
        RateLimiter::clear($this->cacheKey);
        Cache::forget($this->timerKey());
    }

    protected function retryAfterInternal() : ?int
    {
        if(!$this->enabled)
            return null;

        if(!$this->isFlooded())
            return 0;

        return RateLimiter::availableIn($this->cacheKey);
    }

    protected function getNextAvailableTime() : ?CarbonImmutable
    {
        $retryAfter = $this->retryAfterInternal();

        if($retryAfter === null)
            return null;

        return CarbonImmutable::now()->addSeconds($retryAfter);
    }

    protected function primeTimer() : void
    {
        $timerKey = $this->timerKey();
        
        if(Cache::has($timerKey))
            return;

        Cache::put($timerKey, now()->addSeconds($this->expirySeconds)->getTimestamp(), $this->expirySeconds);
    }

    protected function timerKey() : string
    {
        return $this->cacheKey.':timer';
    }

    protected function rawAttempts() : int
    {
        return RateLimiter::attempts($this->cacheKey);
    }
}