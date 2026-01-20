<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputUppercase extends Component
{
    public ?string $label = null;
    public $name;
    public $model;
    public $type;

    public function __construct($label = null, $name, $model, $type = 'text')
    {
        $this->label = $label;
        $this->name = $name;
        $this->model = $model;
        $this->type = $type;
    }

    public function render()
    {
        return view('components.input-uppercase');
    }
}
