<?php

namespace bits\DI;

abstract class ServiceProvider
{
    protected $di;

    abstract public static function name(): string;
    public static function alias(): array
    {
        return [];
    }

    public function boot()
    {}

    /**
     * @param mixed $di
     */
    public function setDi($di): void
    {
        $this->di = $di;
    }
}