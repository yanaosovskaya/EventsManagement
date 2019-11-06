<?php

namespace App\Widgets;

/**
 * Class Widget
 * @package App\Widgets
 */
class Widget
{
    /**
     * @var array
     */
    protected $widgets; //array widgets config/widgets.php

    /**
     * Widget constructor.
     */
    public function __construct()
    {
        $this->widgets = config('widgets');
    }

    /**
     * @param string $name
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $name, array $data = [])
    {
        if (isset($this->widgets[$name])) {
            $instance = new $this->widgets[$name]($data);
            return $instance->execute();
        }
    }
}
