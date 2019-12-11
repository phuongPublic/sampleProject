<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class JobCategoryMst extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_category_mst';

    private $errors;

    private $rules = array(
        'login_id' => 'required|max:255',
        'login_id_confirm' => 'same:login_id',
        'password'  => 'required|max:255',
        'password_confirm'  => 'same:password',
        'last_name'  => 'required|max:255',
        'first_name'  => 'required|max:255',
    );

    public function validate($data)
    {
        // make a new validator object
        $v = Validator::make($data, $this->rules);
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors();
            return false;
        }
        // validation pass
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

    public static function get_parent_category()
    {
        return JobCategoryMst::whereNull('category_cd')->orderBy('display_order', 'asc')->get();
    }

    public static function get_child_category()
    {
        return JobCategoryMst::whereNotNull('category_cd')->orderBy('category_cd', 'asc')->orderBy('display_order', 'asc')->get();
    }

    public static function get_parent_category_multi_lang($lang)
    {
        return JobCategoryMst::join('code_mst', 'job_category_mst.id', '=', 'code_mst.value')
                ->where('group', '=', 'job_category_cd_' . $lang)
                ->whereNull('category_cd')
                ->orderBy('code_mst.seq', 'asc')
                ->get();
    }

    public static function get_child_category_multi_lang($lang)
    {
        return JobCategoryMst::join('code_mst', 'job_category_mst.id', '=', 'code_mst.value')
                ->where('group', '=', 'job_category_cd_' . $lang)
                ->whereNotNull('category_cd')
                ->orderBy('category_cd', 'asc')
                ->orderBy('code_mst.seq', 'asc')
                ->get()->toArray();
    }

}
