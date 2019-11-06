<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Setting
 * @package App\Facades
 */
class Setting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'setting';
    }
}
