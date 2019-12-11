<?php

namespace App\Exports;

use App\Model\CelebrationMoney;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CelebrationMoneyExport2 implements FromView, ShouldAutoSize
{
    /**
     * @return View
     */
    public function view(): View
    {
        $url = url()->previous();
        $parts = parse_url($url);
        $pr = isset($parts['query']) ? $parts['query'] : '';

        if (!empty($pr)) {
            parse_str($parts['query'], $query);
            $monthFilter = isset($query['month_filter']) ? $query['month_filter'] : Carbon::now()->year. '/' . Carbon::now()->month;
            $monthFilter = $monthFilter . '/01 00:00:00';
            $month = Carbon::createFromTimeString($monthFilter);
            $startTime = $month->startOfMonth()->format('Y/m/d');
            $endTime = $month->endOfMonth()->format('Y/m/d');
            $celebrationMoney = CelebrationMoney::getList(0, 1, 1, $startTime, $endTime);
        } else {
            $celebrationMoney = CelebrationMoney::getList(0, 1, 1);
        }

        return view('admin.celebration.export', ['celebrationMoney' => $celebrationMoney]);
    }
}
