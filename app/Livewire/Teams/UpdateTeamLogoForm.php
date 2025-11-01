<?php

namespace App\Livewire\Teams;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UpdateTeamLogoForm extends Component
{
    use WithFileUploads;

    public $team;
    public $logo;
    
    public function save()
    {
        $validated = $this->validate([ 
            'logo' => 'required|image|max:2048',
        ]);
        if ($this->team->logo_path) {
            $this->delete($this->team->logo_path);
        }
        $path = $this->logo->storePublicly('logos', 'public');
        $this->team->update(['logo_path' => $path]);
        $this->dispatch('saved');
    }
    public function deleteLogo()
    {
        if ($this->team->logo_path) {
            $this->delete($this->team->logo_path);
        }
        $this->team->update(['logo_path' => null]);
    }
    public function delete($path)
    {
        Storage::disk('public')->delete($path);
    }
    public function mount($team)
    {
        $this->team = $team;
    }
    public function render()
    {
        return view('livewire.teams.update-team-logo-form');
    }
}
