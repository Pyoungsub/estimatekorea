<?php

namespace App\Livewire\Teams;

use Livewire\Component;

class UpdateTeamInfoForm extends Component
{
    public $team;
    public function save()
    {
        
    }
    public function mount($team)
    {
        $this->team = $team;
    }
    public function render()
    {
        return view('livewire.teams.update-team-info-form');
    }
}
