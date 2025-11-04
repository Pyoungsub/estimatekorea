<?php

namespace App\Livewire\Teams;

use Livewire\Component;
class UpdateTeamInfoForm extends Component
{
    public $team;
    public $phone;
    public $fax;
    public function save()
    {
        $this->validate([
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
        ]);
        $this->team->update([
            'phone' => $this->phone,
            'fax' => $this->fax,
        ]);
        $this->dispatch('saved');
    }
    public function mount($team)
    {
        $this->team = $team;
        $this->phone = $team->phone;
        $this->fax = $team->fax;
    }
    public function render()
    {
        return view('livewire.teams.update-team-info-form');
    }
}
