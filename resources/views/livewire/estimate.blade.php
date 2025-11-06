<div class=""
    x-data="{
        items: [
            { name: '', spec: '', qty: 1, price: 0 },
        ],
        addItem() {
            this.items.push({ name: '', spec: '', qty: 1, price: 0 });
        },
        removeItem(index) {
            this.items.splice(index, 1);
        },
        total() {
            return this.items.reduce((sum, item) => sum + (item.qty * item.price), 0);
        }
    }"
>
    <div id="print-area" class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl p-4 sm:p-10 relative overflow-x-auto">
        
        <!-- 헤더 -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <div class="flex items-center gap-4">
                    @if(!empty($team->logo_path))
                        <img src="{{ $team->logo_url }}" alt="{{ $team->name }}" class="h-14 w-auto object-contain opacity-95" />
                    @endif
                    
                    <h1 class="text-3xl font-bold tracking-tight">{{ $team->name }}</h1>
                </div>

                <div class="mt-3 text-sm leading-5 text-gray-600">
                    <p class="font-medium">대표: {{ $team->owner->name ?? '' }}</p>
                    <p class="font-medium">사업자등록번호: {{ $team->brn ?? '' }}</p>
                    <p class="text-gray-500">{{ $team->getFullAddressAttribute() ?? '' }}</p>
                    <p class="text-gray-500">대표전화: {{ $team->phone ?? '' }}</p>
                    <p class="text-gray-500">FAX: {{ $team->fax ?? '' }}</p>
                    <p class="text-gray-500">담당자: {{ auth()->user()->name }}</p>
                    @if(!empty(auth()->user()->mobile))
                        <p class="text-gray-500">담당자 연락처: {{ auth()->user()->mobile }}</p>
                    @endif
                </div>
            </div>

            <div class="text-center w-full sm:w-auto">
                <span class="text-6xl font-extrabold tracking-wide block text-center leading-tight">견&nbsp;적&nbsp;서</span>
            </div>
        </div>

        <!-- 고객 정보 -->
        <div class="mb-8">
            <h2 class="font-semibold text-lg mb-3">고객 정보</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm bg-gray-100 p-4 border-2 rounded-xl">
                <p class="flex items-center gap-2"><span class="font-medium flex-none">고객명/상호:</span><input class="w-full border-b px-1"></p>
                <p class="flex items-center gap-2"><span class="font-medium flex-none">담당자:</span><input class="w-full border-b px-1"></p>
                <p class="flex items-center gap-2"
                    x-data="{
                        mobile: '',
                        formatKoreanPhone(value) {
                            value = value.replace(/[^0-9]/g, '');
                            if (value.startsWith('02')) {
                                if (value.length <= 2) return value;
                                if (value.length <= 5) return value.replace(/(02)(\d{1,3})/, '$1\)$2');
                                if (value.length <= 9) return value.replace(/(02)(\d{3,4})(\d{1,4})/, '$1\)$2-$3');
                                return value.replace(/(02)(\d{4})(\d{4})/, '$1\)$2-$3');
                            }
                            if (/^01[016789]/.test(value)) {
                                if (value.length <= 3) return value;
                                if (value.length <= 7) return value.replace(/(01\d)(\d{1,3})/, '$1-$2');
                                if (value.length <= 11) return value.replace(/(01\d)(\d{3,4})(\d{1,4})/, '$1-$2-$3');
                            }
                            if (/^0\d{2}/.test(value)) {
                                if (value.length <= 3) return value;
                                if (value.length <= 6) return value.replace(/(0\d{2})(\d{1,3})/, '$1\)$2');
                                return value.replace(/(0\d{2})(\d{3,4})(\d{1,4})/, '$1\)$2-$3');
                            }
                            return value;
                        }
                    }"
                    x-init="$watch('mobile', value => mobile = formatKoreanPhone(value));"
                ><span class="font-medium flex-none">연락처:</span><input class="w-full border-b px-1" maxlength="13" x-model="mobile"></p>
            </div>
        </div>

        <!-- 내역 -->
        <div class="mb-8">
            <h2 class="font-semibold text-lg mb-3">내역</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border-t border-b border-gray-300 min-w-[700px]">
                    <thead class="bg-gray-100">
                        <tr class="text-left">
                            <th class="p-2 w-2/6">품명</th>
                            <th class="p-2 w-1/6">규격</th>
                            <th class="p-2 w-1/12 text-center">수량</th>
                            <th class="p-2 w-1/6 text-right">단가</th>
                            <th class="p-2 w-1/6 text-right">금액</th>
                            <th class="p-2 w-8 text-center no-print"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td class="p-2"><input class="w-full border-b px-1" x-model="item.name"></td>
                                <td class="p-2"><input class="w-full border-b px-1" x-model="item.spec"></td>
                                <td class="p-2 text-center">
                                    <input type="number" min="0.1" step="0.1" class="w-16 border-b px-1 text-center" x-model.number="item.qty">
                                </td>
                                <td class="p-2 text-right">
                                    <input 
                                        class="w-24 border-b px-1 text-right"
                                        x-data="{ priceInput: '' }"
                                        x-init="priceInput = item.price.toLocaleString()"
                                        @input="
                                            const raw = $event.target.value.replace(/[^0-9]/g, '');
                                            item.price = Number(raw);
                                            priceInput = raw ? Number(raw).toLocaleString() : '';
                                        "
                                        x-model="priceInput"
                                    >
                                </td>
                                <td class="p-2 text-right font-semibold">
                                    <span x-text="(item.qty * item.price).toLocaleString()"></span>
                                </td>
                                <td class="p-2 text-center no-print">
                                    <button @click="removeItem(index)" class="text-red-500 text-xs">삭제</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <button @click="addItem()" class="mt-3 px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm no-print">+ 품목 추가</button>

            <div class="flex justify-end mt-8 text-lg font-bold">
                총 합계: <span class="ml-2" x-text="total().toLocaleString()"></span> 원
            </div>
        </div>

        <!-- 합계 -->
        <div class="flex justify-end mb-12">
            <div class="w-64 text-sm">
                <div class="flex justify-between py-1"><span>공급가액</span><p><span x-text="total().toLocaleString()"></span>원</p></div>
                <div class="flex justify-between py-1"><span>부가세 (10%)</span><span>{{ number_format(10000) }}원</span></div>
                <div class="flex justify-between py-2 border-t mt-2 font-semibold text-lg"><span>합계</span><span>{{ number_format(110000) }}원</span></div>
            </div>
        </div>

        <div class="mb-10 space-y-1 text-sm">
            <p>• 납품/개발 기간: 협의</p>
            <p>• 지불 조건: 착수금 30% / 중도 40% / 납품 30%</p>
            <p>• 유지보수: 납품 후 1개월 무상 유지보수</p>
            <p>• 본 견적은 {{ now()->addDays(14)->format('Y-m-d') }} 까지 유효합니다.</p>
        </div>

        <div class="print-footer">
            <div class="pt-6 border-t text-center text-gray-400 text-xs tracking-wide mb-1">
                © {{ date('Y') }} {{ $team->name ?? '' }}. All rights reserved.
            </div>
        </div>

        <button 
            onclick="window.print()" 
            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 no-print mt-6 sm:absolute sm:bottom-6 sm:right-6"
        >PDF 다운로드 / 인쇄</button>
    </div>
</div>
