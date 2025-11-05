<?php

namespace App\Livewire\Teams;

use Livewire\Component;

class UpdateTeamBrnForm extends Component
{
    public $team;
    public $brn;
    public function save()
    {
        $this->validate([
            'brn' => 'nullable|string|max:20|unique:teams,brn,' . $this->team->id,
        ]);
        $this->team->update([
            'brn' => $this->brn,
        ]);
        $this->dispatch('saved');
    }
    public function mount($team)
    {
        $this->team = $team;
        $this->brn = $team->brn;
    }
    public function render()
    {
        return view('livewire.teams.update-team-brn-form');
    }
}
