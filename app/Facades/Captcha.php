<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Captcha
 * @package App\Facades
 */
class Captcha extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'captcha';
    }
}
