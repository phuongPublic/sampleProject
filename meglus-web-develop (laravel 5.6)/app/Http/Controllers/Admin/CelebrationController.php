<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CelebrationMoneyExport1;
use App\Exports\CelebrationMoneyExport2;
use App\Exports\CelebrationMoneyExport3;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\CelebrationMoney;
use App\Http\Controllers\Controller;

class CelebrationController extends Controller
{
    public function index(Request $request, $type = null) {
        $monthFilter = $request->get('month_filter', date('Y/m'));
        $monthFilter = $monthFilter.'/01 00:00:00';
        $month                  = Carbon::createFromTimeString($monthFilter);
        $startTime              = $month->startOfMonth()->format('Y/m/d');
        $endTime                = $month->endOfMonth()->format('Y/m/d');

        //Check type
        if ($type == 'no-adoption')
            $celebrationMoney = CelebrationMoney::getList(0, 1, 0, $startTime, $endTime);
        elseif ($type == 'other')
            $celebrationMoney = CelebrationMoney::getList(0, 0, 0, $startTime, $endTime);
        else
            $celebrationMoney = CelebrationMoney::getList(1, 1, 0, $startTime, $endTime);

        return view('admin.celebration.index', compact('celebrationMoney', 'monthFilter'));
    }

    public function export1()
    {
        return Excel::download(new CelebrationMoneyExport1, 'celebration_money.csv');
    }

    public function export2()
    {
        return Excel::download(new CelebrationMoneyExport2, 'celebration_money2.csv');
    }

    public function export3()
    {
        return Excel::download(new CelebrationMoneyExport3, 'celebration_money3.csv');
    }

}
