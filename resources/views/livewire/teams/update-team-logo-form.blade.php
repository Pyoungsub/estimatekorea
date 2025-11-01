<x-form-section submit="save">
    <x-slot name="title">
        {{ __('Team Logo') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The team\'s name and owner information.') }}
    </x-slot>
    <x-slot name="form">
        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
            <x-label for="logo" value="Team Logo" />
            <!-- Current Logo -->
            <div x-show="!photoPreview" class="mt-2">
                <img src="{{ $team->logo_url }}"
                    alt="{{ $team->name }}"
                    class="h-20 w-20 rounded-full object-cover border border-gray-300 shadow-sm">
            </div>

            <!-- New Preview -->
            <div class="mt-2" x-show="photoPreview" style="display: none;">
                <span class="block h-20 w-20 rounded-full bg-cover bg-center border border-gray-300 shadow-sm"
                    x-bind:style="'background-image: url(\'' + photoPreview + '\')'">
                </span>
            </div>
            @if(Gate::check('update', $team))
                <input type="file" id="logo" class="hidden"
                    accept="image/*"
                    wire:model.live="logo"
                    x-ref="logo"
                    x-on:change="
                        photoName = $refs.logo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => { photoPreview = e.target.result; };
                        reader.readAsDataURL($refs.logo.files[0]);
                    "
                />

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.logo.click()">
                    {{ __('Select New Logo') }}
                </x-secondary-button>

                @if ($team->logo_path)
                    <x-secondary-button class="mt-2" type="button" wire:click="deleteLogo">
                        {{ __('Remove Logo') }}
                    </x-secondary-button>
                @endif
                <x-input-error for="logo" />
            @endif
            
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