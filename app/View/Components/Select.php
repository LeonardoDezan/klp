<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $name;
    public $model;
    public $options;

    public function __construct($label = null, $name, $model, $options = [])
    {
        $this->label = $label;
        $this->name = $name;
        $this->model = $model;
        $this->options = $options;
    }

    public function render()
    {
        return view('components.select');
    }
}
