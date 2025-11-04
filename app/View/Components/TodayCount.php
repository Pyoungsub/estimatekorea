<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Redis;
class TodayCount extends Component
{
    public $today_visit;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->today_visit = $this->getTodayCount();
        //
        /**
         * 작업	Redis 명령
         * 방문자 추가	PFADD key value
         * 방문자 수 조회	PFCOUNT key
         * 여러 기간 합산	PFMERGE newKey key1 key2 key3 ...
         * 보관기한 설정	EXPIRE key seconds
         */
    }
    function getTodayCount() {
        $today = now()->format('Y-m-d');
        return Redis::pfcount("visits:daily:{$today}");
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.today-count');
    }
}
