<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TestComponent extends Component
{
    public $clicked = false;
    public $message = 'Not clicked yet';

    public function testAction()
    {
        $this->clicked = true;
        $this->message = 'Livewire is working!';
    }

    public function render()
    {
        return view('livewire.test-component');
    }
}