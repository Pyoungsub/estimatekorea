<div class=""
    x-data="{
        items: [
            { name: '', spec: '', qty: 1, price: 0 },
        ],
        vatRate: 10,
        addItem() {
            this.items.push({ name: '', spec: '', qty: 1, price: 0 });
        },
        removeItem(index) {
            this.items.splice(index, 1);
        },
        supplyPrice() { // 공급가액
            return this.items.reduce((sum, item) => sum + (item.qty * item.price), 0);
        },
        vat() { // 부가세
            return Math.floor(this.supplyPrice() * (this.vatRate / 100));
        },
        total() { // 합계
            return this.supplyPrice() + this.vat();
        },
        brn: '',
        mobile: '',
        company_mobile: '',
        fax: '',
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
        },
        formatKoreanBRN(value) {
            value = value.replace(/[^0-9]/g, '');
            if (value.length > 5) {
                value = value.slice(0, 3) + '-' + value.slice(3, 5) + '-' + value.slice(5, 10);
            } else if (value.length > 3) {
                value = value.slice(0, 3) + '-' + value.slice(3, 5);
            }
            return value.replace(/(\d{3})(\d{2})(\d{5})/, '$1-$2-$3');
        }
    }"
    x-init="
        $watch('brn', value => brn = formatKoreanBRN(value));
        $watch('mobile', value => mobile = formatKoreanPhone(value));
        $watch('company_mobile', value => company_mobile = formatKoreanPhone(value));
        $watch('fax', value => fax = formatKoreanPhone(value));
    "
>
    <div id="print-area" class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl p-4 sm:p-10 relative overflow-x-auto">
        <div class="text-center mb-10">
            <h1 class="text-6xl font-extrabold tracking-wide leading-tight">견&nbsp;적&nbsp;서</h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
            <!-- 고객 정보 -->
            <div class="">
                <h2 class="font-semibold text-lg mb-3">고객 정보</h2>
                <div class="space-y-2 text-sm leading-5 text-gray-700">
                    <div class="flex items-center gap-2">
                        <span class="font-medium w-28">고객명:</span>
                        <input class="flex-1 border-b px-1 py-0.5" placeholder="홍길동컴퍼니">
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="font-medium w-28">담당자:</span>
                        <input class="flex-1 border-b px-1 py-0.5" placeholder="홍길동">
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="font-medium w-28">연락처:</span>
                        <input class="flex-1 border-b px-1 py-0.5" maxlength="13" x-model="mobile" placeholder="010-1234-5678">
                    </div>

                </div>
            </div>

            <!-- 내 회사 정보 -->
            <div class="md:col-span-2">
                <h2 class="font-semibold text-lg mb-3">공급자 정보</h2>
                <div class="space-y-2 text-sm leading-5 text-gray-700">
                    <div class="flex items-center gap-2">
                        <span class="font-medium w-28">회사명:</span>
                        <input class="flex-1 border-b px-1 py-0.5" placeholder="예: 유한회사 데이드림">
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium w-28">주소:</span>
                        <input class="flex-1 border-b px-1 py-0.5" placeholder="예: 서울 강남구 논현로151길 41 (신사동) 3020호">
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium w-28">대표:</span>
                        <input class="flex-1 border-b px-1 py-0.5" placeholder="예: 심평섭">
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="font-medium w-28">사업자등록번호:</span>
                        <input class="flex-1 border-b px-1 py-0.5" placeholder="669-87-00246" x-model="brn" maxlength="12">
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium w-28">대표전화:</span>
                        <input class="flex-1 border-b px-1 py-0.5" placeholder="02-1234-5678" x-model="company_mobile" maxlength="13">
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium w-28">FAX:</span>
                        <input class="flex-1 border-b px-1 py-0.5" placeholder="02-1234-5678" x-model="fax" maxlength="13">
                    </div>
                    

                </div>
            </div>

        </div>

        <!-- 내역 -->
        <div class="min-h-96 mb-8">
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
                                <td class="p-2"><input class="w-full flex-1 border-b px-1 py-0.5" x-model="item.name"></td>
                                <td class="p-2"><input class="w-full flex-1 border-b px-1 py-0.5" x-model="item.spec"></td>
                                <td class="p-2 text-center">
                                    <input type="number" min="0.1" step="0.1" class="w-16 flex-1 border-b px-1 py-0.5 text-center" x-model.number="item.qty">
                                </td>
                                <td class="p-2 text-right">
                                    <input 
                                        class="w-24 flex-1 border-b px-1 py-0.5 text-right"
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
        </div>

        <!-- 합계 -->
        <div class="flex justify-between mb-12">
            <div class="mb-10 space-y-1 text-sm">
                <div class="hidden">
                    <p>• 납품/개발 기간: 협의</p>
                    <p>• 지불 조건: 착수금 30% / 중도 40% / 납품 30%</p>
                    <p>• 유지보수: 납품 후 1개월 무상 유지보수</p>
                    <p>• 본 견적은 {{ now()->addDays(14)->format('Y-m-d') }} 까지 유효합니다.</p>
                </div>
                
            </div>
            <div class="w-64 text-sm">
                <div class="flex justify-between py-1">
                    <span>공급가액</span>
                    <p><span x-text="supplyPrice().toLocaleString()"></span>원</p>
                </div>

                <div class="flex justify-between py-1 items-center">
                    <span>부가세 (<input type="text" x-model.number="vatRate" class="w-12 border-b text-right" min="0">%)</span>
                    <span x-text="vat().toLocaleString() + '원'"></span>
                </div>

                <div class="flex justify-between py-2 border-t mt-2 font-semibold text-lg">
                    <span>합계</span>
                    <span x-text="total().toLocaleString() + '원'"></span>
                </div>
            </div>
        </div>

        
        <button 
            onclick="window.print()" 
            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 no-print mt-6 sm:absolute sm:bottom-6 sm:right-6"
        >PDF 다운로드 / 인쇄</button>
    </div>
</div>