<x-form-section submit="save">
    <x-slot name="title">
        {{ __('Team Info') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The team\'s address and contact information.') }}
    </x-slot>
    <x-slot name="form">
        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
            <x-label for="logo" value="Team Address" />
            @if(Gate::check('update', $team))
                <button class="text-xs border px-4 py-2 rounded-lg" wire:click="$dispatch('add-address')">{{__('Search Address')}}</button>
            @endif
            <livewire:search-address @saved="$refresh">
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
