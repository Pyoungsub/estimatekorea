<?php

namespace App\Livewire;

use Livewire\Component;

class Estimate extends Component
{
    public $team;
    public function mount()
    {
        $this->team = auth()->user()->currentTeam->load([
            'address_detail.extra_address.road.city.state'
        ]);
    }
    public function render()
    {
        return view('livewire.estimate');
    }
}
