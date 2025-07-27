<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputMask extends Component
{

    public function __construct(
        public ?string $label = null,
        public ?string $name = null,
        public ?string $model = null,
        public ?string $mask = ''
    ) {}

    public function render()
    {
        return view('components.input-mask');
    }
}
