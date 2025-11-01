<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
class Logo extends Component
{
    use WithFileUploads;

    public $logo;
    public function save()
    {
        $validated = $this->validate([ 
            'logo' => 'required|image|max:2048',
        ]);
        $team = auth()->user()->currentTeam;
        if ($team->logo_path) {
            $this->delete($team->logo_path);
        }
        $path = $this->logo->storePublicly('logos', 'public');
        $team->update(['logo_path' => $path]);
        $this->dispatch('saved');
    }
    public function deleteLogo()
    {
        $team = auth()->user()->currentTeam;
        if ($team->logo_path) {
            $this->delete($team->logo_path);
        }
        $team->update(['logo_path' => null]);
    }
    public function delete($path)
    {
        Storage::disk('public')->delete($path);
    }
    public function render()
    {
        return view('livewire.logo');
    }
}
