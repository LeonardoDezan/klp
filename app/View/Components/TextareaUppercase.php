<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextareaUppercase extends Component
{
    public $label;
    public $name;
    public $model;
    public $rows;

    public function __construct($label = null, $name, $model, $rows = 4)
    {
        $this->label = $label;
        $this->name = $name;
        $this->model = $model;
        $this->rows = $rows;
    }

    public function render()
    {
        return view('components.textarea-uppercase');
    }
}
