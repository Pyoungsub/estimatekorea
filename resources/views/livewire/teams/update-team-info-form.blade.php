<x-form-section submit="save">
    <x-slot name="title">
        {{ __('Team Info') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The team\'s address and contact information.') }}
    </x-slot>
    <x-slot name="form">
        <div 
            class="col-span-6 sm:col-span-4"
            x-data="{
                postcode: $wire.entangle('postcode'), 
                phone: $wire.entangle('phone'),
                fax: $wire.entangle('fax'),
                formatKoreanPhone(value) {
                    value = value.replace(/[^0-9]/g, '');
                    if (value.startsWith('02')) {
                        if (value.length <= 2) return value;
                        if (value.length <= 5) return value.replace(/(02)(\d{1,3})/, '$1\)$2');
                        if (value.length <= 9) return value.replace(/(02)(\d{3,4})(\d{1,4})/, '$1\)$2-$3');
                        return value.replace(/(02)(\d{4})(\d{4})/, '$1\)$2-$3');
                    }

                    // 휴대폰 010/011/016/017/018/019
                    if (/^01[016789]/.test(value)) {
                        if (value.length <= 3) return value;
                        if (value.length <= 7) return value.replace(/(01\d)(\d{1,3})/, '$1-$2');
                        if (value.length <= 11) return value.replace(/(01\d)(\d{3,4})(\d{1,4})/, '$1-$2-$3');
                    }

                    // 기타 지역번호
                    if (/^0\d{2}/.test(value)) {
                        if (value.length <= 3) return value;
                        if (value.length <= 6) return value.replace(/(0\d{2})(\d{1,3})/, '$1\)$2');
                        return value.replace(/(0\d{2})(\d{3,4})(\d{1,4})/, '$1\)$2-$3');
                    }
                    return value;
                }
            }" 
            x-init="
                $watch('phone', value => phone = formatKoreanPhone(value));
                $watch('fax', value => fax = formatKoreanPhone(value));
            "
        >
            <x-label for="address" value="Team Address" />
            @if(Gate::check('update', $team))
                <button type="button" id="address" class="mt-2 text-xs border px-4 py-2 rounded-lg" wire:click="$dispatch('add-address')">{{__('Search Address')}}</button>
            @endif
            <div class="mt-2" x-show="postcode">
                <p class="text-sm mb-1">우편번호: <span x-text="postcode"></span></p>
                <x-input type="text" id="address" class="mt-2 block w-full" wire:model="address" readonly />
                <x-input type="text" id="details" class="mt-2 block w-full" wire:model="details" placeholder="상세주소를 입력해주세요." />
                <x-input type="text" id="phone" class="mt-2 block w-full" x-model="phone" maxlength="13" placeholder="전화번호를 입력해주세요." />
                <x-input type="text" id="fax" class="mt-2 block w-full" x-model="fax" maxlength="13" placeholder="팩스번호를 입력해주세요." />
            </div>
            <div class="mt-2" x-show="!postcode">
                @if($team->address_detail)
                    <p class="text-sm mb-1">우편번호: {{ $team->address_detail->extra_address->postcode }}</p>
                    <x-input type="text" id="address" class="mt-2 block w-full" value="{{ $team->address_detail->extra_address->extra_address }}" readonly />
                    <x-input type="text" id="details" class="mt-2 block w-full" value="{{ $team->address_detail->details }}" readonly />
                    <x-input type="text" id="phone" class="mt-2 block w-full" value="{{ $team->address_detail->phone }}" readonly />
                    <x-input type="text" id="fax" class="mt-2 block w-full" value="{{ $team->address_detail->fax }}" readonly />
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
