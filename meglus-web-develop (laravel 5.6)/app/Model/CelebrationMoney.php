<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CelebrationMoney extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'celebration_money';

    public function applicant()
    {
        return $this->belongsTo('App\Model\Applicant');
    }

    public static function getList($setEmploymentDt = null, $status = null, $isExport = null, $start = null, $end = null)
    {
        $model = CelebrationMoney::select('celebration_money.*', 'applicant.*', 'jobs.workplace_name', 'jobs.job_id',
            'demand_user_info.name',
            'celebration_money.status AS celebration_money_status',
            'celebration_money.created_at AS celebration_money_created_at')

            ->join('applicant', 'celebration_money.applicant_id', 'applicant.id')
            ->join('jobs', 'applicant.job_id', 'jobs.job_id')
            ->join('demand_user_info', 'applicant.demand_user_id', 'demand_user_info.id');

        if (!empty($start) && !empty($end))
                $model->whereBetween('celebration_money.created_at', [$start, $end]);

        if (!empty($setEmploymentDt)) {

            $model->whereNotNull('set_employment_dt');

        } elseif (($status == 1) && empty($setEmploymentDt)) {

            $model->where('celebration_money.status', 1)
                  ->whereNull('set_employment_dt');

        } elseif (($status != 1) && empty($setEmploymentDt)) {

            $model->where('celebration_money.status', '!=', 1)
                  ->whereNull('set_employment_dt');

        }

        if ($isExport)
            return $model->get();
        else
            return $model->paginate(30);
    }
}
