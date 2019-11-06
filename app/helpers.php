<?php

if (!function_exists('setting')) {
    /**
     * Returns a setting by key
     *
     * @param string $key
     * @return string
     */
    function setting($key)
    {
        return app('setting')->get($key);
    }
}
