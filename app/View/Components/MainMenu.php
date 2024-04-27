<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainMenu extends Component
{
    public array $items;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->items = app()->make('main-menu');
        $this->prepare();
    }

    private function prepare()
    {
        foreach ($this->items as $index => $item) {
            if (isset($item['sub_items']) && is_array($item['sub_items'])) {
                if (!auth()->user()->hasPermissions($item['permissions']))
                    unset($this->items[$index]);

                foreach ($item['sub_items'] as $i => $sub_item) {
                    if (!auth()->user()->hasPermissions([$sub_item['permission']])) {
                        unset($this->items[$index]['sub_items'][$i]);
                    }
                }
            } else {
                if (!auth()->user()->hasPermissions([$item['permission']]))
                    unset($this->items[$index]);
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.layouts.main-menu');
    }
}
