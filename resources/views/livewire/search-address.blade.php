<div class=""
    x-data="{
        submitting:false,
        apiKey:@entangle('apiKey'),
        countPerPage:10,
        currentPage:1,
        visiblePages:5,
        totalPages:0,
        pagination:[],
        keyword:'',
        errDesc:'',
        postcode:'',
        state:'',
        city:'',
        road:'',
        extra_address:'',
        addresses:$wire.entangle('addresses'),
        searchAddress(currentPage)
        {
            this.submitting = true;
            setTimeout(() => { this.submitting = false; }, 1000);
            var data = {
                currentPage: currentPage,
                countPerPage: this.countPerPage,
                resultType:'json',
                confmKey:this.apiKey,
                keyword:this.keyword,
            };
            fetch('https://business.juso.go.kr/addrlink/addrLinkApiJsonp.do', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(data).toString(),
            })
            .then(response => response.text())
            .then(text => {
                // Trim the padding function call and parse the remaining JSON
                const jsonStr = JSON.parse(text.slice(text.indexOf('(') + 1, text.lastIndexOf(')')));
                var errCode = jsonStr.results.common.errorCode;
                if(errCode != '0')
                {
                    this.errDesc = jsonStr.results.common.errorMessage;
                }
                else
                {
                    this.pagination = [];
                    let startPage, endPage;
                    this.addresses = jsonStr.results.juso;
                    this.currentPage = Number(jsonStr.results.common.currentPage);
                    this.totalPages = Math.ceil(jsonStr.results.common.totalCount / 10);
                    if(this.totalPages > 900)
                    {
                        this.totalPages = 900;
                    }
                    if(this.totalPages <= this.visiblePages)
                    {
                        startPage = 1;
                        endPage = this.totalPages;
                    }
                    else
                    {
                        const halfVisible = Math.floor(this.visiblePages / 2);
                        if(this.currentPage <= halfVisible)
                        {
                            startPage = 1;
                            endPage = this.visiblePages
                        }
                        else if(this.currentPage + halfVisible >= this.totalPages)
                        {
                            startPage = this.totalPages - this.visiblePages + 1;
                            endPage = this.totalPages;
                        }
                        else
                        {
                            startPage = this.currentPage - halfVisible;
                            endPage = this.currentPage + halfVisible;
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        this.pagination.push(i);
                    }
                }
            })
            .catch(error => {
                console.error('에러발생:', error);
                alert('에러발생');
            });
        },
        setAddress(index)
        {
            var selected_address = this.addresses[index];
            this.postcode = selected_address.zipNo;
            this.state = selected_address.siNm;
            this.city = selected_address.sggNm;
            this.road = selected_address.rn;
            this.extra_address = selected_address.buldMnnm;
            if(selected_address.buldSlno != '0')
            {
                this.extra_address += '-' + selected_address.buldSlno;
            }
            this.addresses = [];
            this.totalPages = '';
            this.currentPage = '';
        }
    }"
    x-init="
        $watch('keyword', value => {
            errDesc = '';
            resetInfo();
        });
        function resetInfo()
        {
            addresses = [];
            currentPage = '';
            totalPages = '';
            postcode = '';
            state = '';
            city = '';
            road = '';
            extra_address = '';
        };
    "
>
    <x-dialog-modal wire:model="addressModal" maxWidth="sm">
        <x-slot name="title">
            <div class="flex items-center justify-between">
                <h2>주소검색</h2>
                <button x-cloak @click="$wire.addressModal = false;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="space-y-3">
                <div class="flex gap-2">
                    <input type="text"
                        x-model="keyword"
                        :disabled="submitting"
                        @keyup.enter.prevent="searchAddress(1)"
                        placeholder="도로명 입력"
                        class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100">
                    <button type="button"
                            @click="searchAddress(1)"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                        우편번호 찾기
                    </button>
                </div>

                <p x-show="errDesc" x-text="errDesc" class="text-red-600 text-sm"></p>

                <div x-show="addresses.length > 0" class="border rounded divide-y bg-white shadow-sm">
                    <template x-for="(address, index) in addresses" :key="index">
                        <button @click="$dispatch('set-address', {address: address}); $wire.addressModal = false;"
                                class="block w-full text-left px-3 py-2 hover:bg-blue-50 disabled:bg-gray-100 disabled:line-through disabled:text-gray-400">
                            <span x-text="address.roadAddr"></span>
                        </button>
                    </template>
                </div>
                <div class="flex items-center justify-center gap-1 text-sm mt-2" x-show="totalPages > 1">
                    <button x-show="currentPage != 1 && totalPages > 5"
                            @click="searchAddress(1)"
                            class="px-2 py-1 hover:text-blue-600">처음</button>

                    <button x-show="currentPage > 5 && totalPages > 5"
                            @click="searchAddress(currentPage-5)"
                            class="px-2 py-1 hover:text-blue-600">이전</button>

                    <template x-for="page in pagination">
                        <button @click="searchAddress(page)"
                                :disabled="page == currentPage"
                                x-text="page"
                                class="px-2 py-1 rounded transition"
                                :class="page == currentPage ? 'bg-blue-600 text-white font-bold cursor-default' : 'hover:bg-blue-50'">
                        </button>
                    </template>
                    <button x-show="currentPage + 5 <= totalPages"
                            @click="searchAddress(currentPage+5)"
                            class="px-2 py-1 hover:text-blue-600">다음</button>

                    <button x-show="currentPage != totalPages && totalPages > 5"
                            @click="searchAddress(totalPages)"
                            class="px-2 py-1 hover:text-blue-600">끝</button>
                </div>
            </div>            
        </x-slot>
        <x-slot name="footer">
        </x-slot>
    </x-dialog-modal>
</div>