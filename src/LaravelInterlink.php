<?php
namespace KaqazStudio\LaravelInterlink;

use KaqazStudio\LaravelInterlink\Core\SingleInterlink;

class LaravelInterlink
{
    /**
     * Initialize Laravel Interlink core [NO-FACADE].
     * @return SingleInterlink
     */
    public static function access(): SingleInterlink
    {
        return new SingleInterlink();
    }


    /**
     * Initialize Single Interlink core [FACADE].
     * @return SingleInterlink
     */
    public function single(): SingleInterlink
    {
        return new SingleInterlink();
    }
}
