<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Class SettingService
 * @package App\Services
 */
class SettingService
{
    /**
     * @param string $key
     * @return string|null
     */
    public function get($key)
    {
        $model = $this->fetchByKey($key);
        return Cache::rememberForever($key, function () use ($model) {
            return $model === null ? null : $model->value;
        });
    }

    /**
     * @param string $key
     * @param string $value
     * @param string $title
     * @param int $active
     * @param int $group
     * @param int $type
     * @return string
     */
    public function set($key, $value, $title, $active = 1, $group = 1, $type = 1)
    {
        $model = Setting::updateOrCreate(
            [
                'key' => $key,
            ],
            [
                'value' => $value,
                'title' => $title,
                'groups' => $group,
                'type' => $type,
                'active' => $active,
            ]
        );

        Cache::forever($key, $model->value);

        return $model->value;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        if (Cache::has($key)) {
            return true;
        }

        if ($this->fetchByKey($key) !== null) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     */
    public function forget($key)
    {
        if ($this->has($key)) {
            Cache::forget($key);
            $this->fetchByKey($key)->delete();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Setting::all();
    }

    /**
     * @param string $key
     * @return Setting|null
     */
    private function fetchByKey($key)
    {
        return Setting::where('key', $key)->first();
    }
}
