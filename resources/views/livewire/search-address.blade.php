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
        nonDeliveryZone:['사랑면', '산양읍', '육지면', '용남면', '한산면'],
        postcode:'',
        state:'',
        city:'',
        road:'',
        extra_address:'',
        detail_address:'',
        receiver:'',
        receiver_mobile:'',
        name:'{{auth()->user()->name}}',
        mobile:'{{auth()->user()->mobile}}',
        addresses:[],
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
        checkAddress(address)
        {
            var available = false;
            if(
                address.siNm != '제주특별자치도' 
                && !(address.sggNm == '서산시' && address.rn == '지곡면') 
                && !(address.siNm == '전라남도' && address.sggNm == '신안군')
                && !(address.siNm == '경상남도' && address.sggNm == '통영시' && this.nonDeliveryZone.find((element) => element == address.emdNm))
            )
            {
                available = true;
            }
            return available;
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
            <div class="">
                <input type="text" x-model="keyword" :disabled="submitting" @keyup.enter.prevent="searchAddress(1)">
                <button type="button" @click="searchAddress(1)">우편번호 찾기</button>
                <p x-show="errDesc" x-text="errDesc"></p>
                <div class="" x-show="postcode">
                    <p x-text="postcode"></p>
                    <p x-text="state"></p>
                    <p x-text="city"></p>
                    <p x-text="road"></p>
                    <p x-text="extra_address"></p>
                    <x-input x-model="detail_address" type="text" placeholder="{{__('나머지 주소')}}" />
                    <button x-show="!receiver" @click="receiver = name, receiver_mobile = mobile" x-text="'{{__('내 정보 사용')}}'"></button>
                    <x-input x-model="receiver" type="text" placeholder="{{__('받으시는 분')}}" />
                    <x-input x-mask="999-9999-9999" x-model="receiver_mobile" type="tel" placeholder="{{__('010-XXXX-XXXX')}}" />
                </div>
                <div x-show="addresses.length > 0" class="w-full border">
                    <template x-for="(address, index) in addresses">
                        <button class="p-2 disabled:line-through disabled:cursor-not-allowed" :disabled="checkAddress(address) !== true" x-text="address.roadAddr" @click="setAddress(index)"></button>
                    </template>
                </div>
                <div class="flex items-center justify-center gap-2" x-show="totalPages > 1">
                    <button x-show="currentPage != 1 && totalPages > 5" @click="searchAddress(1)">처음</button>
                    <button x-show="currentPage > 5 && totalPages > 5" @click="searchAddress(currentPage-5)">이전</button>
                    <template x-for="page in pagination">
                        <button @click="searchAddress(page)" x-text="page" :class="page == currentPage ? 'text-blue-700 font-bold' : ''" :disabled="page == currentPage"></button>
                    </template>
                    <button x-show="currentPage + 5 <= totalPages" @click="searchAddress(currentPage+5)">다음</button>
                    <button x-show="currentPage != totalPages && totalPages > 5" @click="searchAddress(totalPages)">끝</button>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button x-show="postcode" class="disabled:bg-gray-100" :disabled="!(postcode && detail_address && receiver && receiver_mobile)" @click="$wire.addAddress(postcode, state, city, road, extra_address, detail_address, receiver, receiver_mobile)">{{__('사용하기')}}</button>            
        </x-slot>
    </x-dialog-modal>
</div>