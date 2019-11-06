<?php

namespace App\Widgets;

/**
 * Interface WidgetInterface
 * @package App\Widgets
 */
interface WidgetInterface
{
    /**
     * Example:
     *  return view('Widgets::nameWidget', [
     *  'data' => $data
     *  ]);
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function execute();
}
