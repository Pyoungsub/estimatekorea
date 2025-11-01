<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class SearchAddress extends Component
{
    public $apiKey;
    public $search;
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
        $this->reset(['search', 'postcode', 'state', 'extra_address', 'detail_address']);
        $this->addressModal = true;
    }
    public function addAddress($postcode, $state, $city, $road, $extra_address, $detail_address, $receiver, $receiver_mobile)
    {
        $this->postcode = $postcode;
        $this->state = $state;
        $this->city = $city;
        $this->road = $road;
        $this->extra_address = $extra_address;
        $this->detail_address = $detail_address;
        $this->receiver = $receiver;
        $this->receiver_mobile = $receiver_mobile;
        $validated = $this->validate([ 
            'postcode' => 'required|min:3',
            'state' => 'required|min:3',
            'city' => 'required|min:3',
            'road' => 'required|min:3',
            'extra_address' => 'nullable|min:3',
            'detail_address' => 'required|min:3',
            'receiver' => 'required|min:3',
            'receiver_mobile' => 'required|min:13',
        ]);
        if(auth()->user()->addresses()->count() < 3)
        {
            $store_address = auth()->user()->addresses()->firstOrCreate([
                'postcode' => $this->postcode, 
                'state' => $this->state,
                'city' => $this->city,
                'road' => $this->road,
                'extra_address' => $this->extra_address,
                'detail_address' => $this->detail_address,
                'receiver' => $this->receiver,
                'receiver_mobile' => $this->receiver_mobile,
            ]);
            if($store_address)
            {
                $this->dispatch('address-created');
                $this->reset(['postcode', 'state', 'city', 'road', 'extra_address', 'detail_address', 'receiver', 'receiver_mobile', 'addressModal']);
            }
        }
        
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
