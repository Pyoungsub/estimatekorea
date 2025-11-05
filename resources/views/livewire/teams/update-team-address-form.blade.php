<x-form-section submit="save">
    <x-slot name="title">
        {{ __('Team Address') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The team\'s address.') }}
    </x-slot>
    <x-slot name="form">
        <div 
            class="col-span-6 sm:col-span-4"
            x-data="{
                postcode: $wire.entangle('postcode'), 
            }" 
        >
            <x-label for="address" value="Team Address" />
            @if(Gate::check('update', $team))
                <button type="button" id="address" class="mt-2 text-xs border px-4 py-2 rounded-lg" wire:click="$dispatch('add-address')">{{__('Search Address')}}</button>
            @endif
            <div class="mt-2" x-show="postcode">
                <p class="text-sm mb-1">우편번호: <span x-text="postcode"></span></p>
                <x-input type="text" id="address" class="mt-2 block w-full" wire:model="address" readonly />
                <x-input type="text" id="details" class="mt-2 block w-full" wire:model="details" placeholder="상세주소를 입력해주세요." />
            </div>
            <div class="mt-2" x-show="!postcode">
                @if($team->address_detail)
                    <p class="text-sm mb-1">우편번호: {{ $team->address_detail->extra_address->postcode }}</p>
                    <x-input type="text" id="address" class="mt-2 block w-full" value="{{ $team->address_detail->extra_address->road->city->state->name }} {{ $team->address_detail->extra_address->road->city->name }} {{ $team->address_detail->extra_address->road->name }} {{ $team->address_detail->extra_address->extra_address }}" readonly />
                    <x-input type="text" id="details" class="mt-2 block w-full" value="{{ $team->address_detail->details }}" readonly />
                @else
                    <p class="text-sm text-gray-600">{{ __('No address selected.') }}</p>
                @endif
            </div>
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    @endif
    
</x-form-section>
