<?php

namespace App\Livewire;

use App\Events\RoomCreated;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ReverbTest extends Component
{
    use LivewireAlert;

    public $name;

    public function submitForm()
    {
        event(new RoomCreated($this->name));
        // $this->name = '';

    }

    #[On('echo:my-channel,RoomCreated')]
    public function realTimeMessage($name)
    {
        dump($name);
        $this->alert('success','Event Message Received');
    }

    public function render()
    {
        return view('livewire.reverb-test');
    }
}
