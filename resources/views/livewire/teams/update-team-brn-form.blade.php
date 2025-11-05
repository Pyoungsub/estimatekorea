<x-form-section submit="save">
    <x-slot name="title">
        {{ __('Team BRN') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The team\'s BRN.') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4"
            x-data="{
                brn: $wire.entangle('brn'),
                formatBRN(value) {
                    value = value.replace(/[^0-9]/g, '');
                    if (value.length > 5) {
                        value = value.slice(0, 3) + '-' + value.slice(3, 5) + '-' + value.slice(5, 10);
                    } else if (value.length > 3) {
                        value = value.slice(0, 3) + '-' + value.slice(3, 5);
                    }
                    return value;
                }
            }" 
            x-init="
                $watch('brn', value => brn = formatBRN(value));
            "
        >
            <x-label for="address" value="Team Address" />
            <div class="mt-2">
                <x-input type="text" id="brn" class="mt-2 block w-full" x-model="brn" maxlength="13" placeholder="사업자 등록번호를 입력해주세요." :disabled="! Gate::check('update', $team)" />
                <x-input-error for="brn" class="mt-2" />
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