<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>무료 온라인 견적서 작성 – PDF로 바로 출력 | EstimateKorea</title>
        <meta name="description" content="간단한 입력만으로 전문 견적서를 무료로 만들고 PDF로 다운로드하세요. 프리랜서, 소상공인 누구나 쉽게 사용 가능한 온라인 견적서 서비스.">
        <meta name="keywords" content="무료 견적서, 온라인 견적서, 견적서 작성, 견적서 PDF, 프리랜서 견적서, 소상공인 견적서">

        <!-- Open Graph -->
        <meta property="og:type" content="website">
        <meta property="og:title" content="무료 온라인 견적서 작성 – PDF로 바로 출력">
        <meta property="og:description" content="간단한 입력만으로 전문 견적서를 무료로 만들고 PDF로 다운로드하세요. 프리랜서, 소상공인 누구나 쉽게 사용 가능합니다.">
        <meta property="og:url" content="https://www.estimatekorea.com/">
        <meta property="og:image" content="{{asset('images/og-image.png')}}">
        <meta property="og:site_name" content="EstimateKorea">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="무료 온라인 견적서 작성 – PDF로 바로 출력">
        <meta name="twitter:description" content="간단한 입력만으로 전문 견적서를 무료로 만들고 PDF로 다운로드하세요. 프리랜서, 소상공인 누구나 쉽게 사용 가능합니다.">
        <meta name="twitter:image" content="{{asset('images/og-image.png')}}">
        <meta name="twitter:site" content="@EstimateKorea">

        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="canonical" href="https://www.estimatekorea.com/">
        <meta name="robots" content="index, follow">
        <link rel="alternate" href="https://www.estimatekorea.com/" hreflang="ko">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <!-- Naver Site Verification -->
        <meta name="naver-site-verification" content="9c7d5b76e1b0dd9a00e92f0f16b47961b77efca6" />
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Google addsense -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9415580505244330" crossorigin="anonymous"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <header class="w-full max-w-[335px] lg:max-w-4xl mx-auto flex items-center justify-between py-4 px-4 md:px-6 bg-white shadow-sm rounded-md">
            <!-- 로고 -->
            <x-application-logo class="h-10 w-auto" />

            <!-- 메뉴 -->
            @if (Route::has('login'))
                <nav class="flex items-center gap-3 md:gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition">
                        Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-gray-100 text-gray-800 rounded-md text-sm font-medium hover:bg-gray-200 transition">
                        Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition">
                            Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        
        <section class="text-center py-16 px-6 md:py-24 bg-gray-100 no-print">
            <h2 class="text-3xl md:text-5xl font-extrabold mb-4 leading-tight">
            무료로 견적서를 만들어보세요.
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">디자인 고민 없이, 누구나 바로 사용할 수 있는 심플하고 깔끔한 견적서 템플릿.</p>
        </section>
        <!-- Sample -->
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-estimate />
        </section>
        <!-- Features -->
        <section class="py-16 bg-white no-print">
            <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-3xl font-bold text-center mb-12">왜 EstimateKorea인가?</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-sm">
                <img src="https://images.unsplash.com/photo-1554224154-22dec7ec8818?auto=format&fit=crop&w=800&q=80"
                    class="w-20 h-20 mx-auto rounded-full mb-4 object-cover">
                <h4 class="text-lg font-semibold mb-2">무료 사용</h4>
                <p class="text-gray-600 text-sm">회원가입 없이 바로 무료로 견적서를 만들 수 있습니다.</p>
                </div>

                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-sm">
                <img src="https://images.unsplash.com/photo-1554224154-22dec7ec8818?auto=format&fit=crop&w=800&q=80"
                    class="w-20 h-20 mx-auto rounded-full mb-4 object-cover">
                <h4 class="text-lg font-semibold mb-2">간단한 인터페이스</h4>
                <p class="text-gray-600 text-sm">엑셀/워드 없이, 클릭만으로 자동 계산 및 항목 정리.</p>
                </div>

                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-sm">
                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=800&q=80"
                    class="w-20 h-20 mx-auto rounded-full mb-4 object-cover">
                <h4 class="text-lg font-semibold mb-2">PDF 저장 or Print</h4>
                <p class="text-gray-600 text-sm">작업한 견적서를 바로 인쇄.</p>
                </div>
            </div>
            </div>
        </section>
        <section class="text-center py-16 px-6 md:py-24 no-print">
            <h2 class="text-3xl md:text-5xl font-extrabold mb-4 leading-tight">
                자주 이용할 수록 회원가입은 필수!
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">
                회원가입을 통해 반복적인 회사정보를 저장하고 더 빠르게 견적서를 작성하세요!
            </p>

            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{route('dashboard')}}" class="px-6 py-3 bg-blue-600 text-white rounded-lg text-lg hover:bg-blue-700 transition">
                    지금 시작하기
                </a>
            </div>
        </section>
        @stack('modals')

        @livewireScripts
    </body>
    <footer class="text-center text-sm text-gray-500 py-10">
        ⓒ 2025 EstimateKorea. All rights reserved.
        <x-today-count />
    </footer>
</html>