<?php

namespace App\Livewire\Teams;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\State;
use App\Models\City;
use App\Models\Road;
use App\Models\ExtraAddress;
use App\Models\AddressDetail;

class UpdateTeamAddressForm extends Component
{
    public $team;
    public $address;
    public $postcode;
    public $state;
    public $city;
    public $road;
    public $extra_address;
    public $details;

    #[On('set-address')]
    public function setAddress($address)
    {
        $this->address = $address['roadAddr'];
        $this->postcode = $address['zipNo'];
        $this->state = $address['siNm'];
        $this->city = $address['sggNm'];
        $this->road = $address['rn'];
        $this->extra_address = $address['buldMnnm'] . ($address['buldSlno'] ? '-' . $address['buldSlno'] : '');
    }
    public function save()
    {
        $this->validate([
            'postcode' => 'required|string|max:20',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'road' => 'required|string|max:255',
            'details' => 'required|string|max:255',
        ]);
        $state = State::firstOrCreate(['name' => $this->state]);
        $city = City::firstOrCreate(['name' => $this->city, 'state_id' => $state->id]);
        $road = Road::firstOrCreate(['name' => $this->road, 'city_id' => $city->id]);
        $extraAddress = ExtraAddress::firstOrCreate([
            'road_id' => $road->id,
            'postcode' => $this->postcode,
            'extra_address' => $this->extra_address,
        ]);
        AddressDetail::updateOrCreate(
            ['team_id' => $this->team->id],
            [
                'extra_address_id' => $extraAddress->id,
                'details' => $this->details,
            ]
        );
        $this->dispatch('saved');
    }
    public function mount($team)
    {
        $this->team = $team->load([
            'address_detail.extra_address.road.city.state'
        ]);
    }
    public function render()
    {
        return view('livewire.teams.update-team-address-form');
    }
}
