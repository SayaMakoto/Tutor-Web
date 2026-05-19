<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ApplicationCard extends Component
{
    public $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function render()
    {
        return view('components.partials.application-card');
    }
}