<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class SearchAddress extends Component
{
    public $apiKey;
    public $search;
    public $addresses = [];
    public $postcode='';
    public $state;
    public $city;
    public $road;
    public $extra_address;
    public $detail_address;
    public $receiver;
    public $receiver_mobile;
    public $use_mine;
    public $addressModal;
    #[On('add-address')]
    public function updatePostList()
    {
        $this->reset(['addresses', 'search', 'postcode', 'state', 'extra_address', 'detail_address']);
        $this->addressModal = true;
    }
    public function mount()
    {
        $this->apiKey = env('JUSO_API_KEY');
    }
    public function render()
    {
        return view('livewire.search-address');
    }
}
