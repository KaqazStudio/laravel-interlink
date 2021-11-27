<?php

namespace KaqazStudio\LaravelInterlink\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelInterlinkFacade
 * @package KaqazStudio\LaravelInterlink\Facade
 * @see \KaqazStudio\LaravelInterlink\LaravelInterlink
 */
class LaravelInterlinkFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel_interlink';
    }
}
