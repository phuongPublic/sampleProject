<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Start: For admin
Route::namespace('Admin')->prefix('admin')->middleware(['is.admin'])->group(function () {

    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::prefix('job')->group(function () {
        Route::get('category', 'JobCategoryController@index')->name('admin.job.category');
        Route::post('category/change-icon', 'JobCategoryController@changeIcon')->name('admin.job.category.changeIcon');
        Route::post('category/change-position', 'JobCategoryController@changePosition')->name('admin.job.category.changePosition');
        Route::post('category/create', 'JobCategoryController@create')->name('admin.job.category.create');
        Route::post('category/update', 'JobCategoryController@update')->name('admin.job.category.update');
        Route::post('category/delete', 'JobCategoryController@delete')->name('admin.job.category.delete');

        // Admin job
        Route::get('/{cid?}', 'JobController@index')->name('admin.job.index')->where('cid', '[0-9]+');
        Route::get('/history/{id}', 'JobController@history')->name('admin.job.history')->where('id', '[0-9]+');
        Route::get('/detail-history/{id}', 'JobController@detailHistory')->name('admin.job.detailHistory')->where('id', '[0-9]+');
        Route::get('/block/{id}', 'JobController@block')->name('admin.job.block')->where('id', '[0-9]+');
        Route::get('/stop-all/{companyId}', 'JobController@stopAll')->name('admin.job.stopAll')->where('companyId', '[0-9]+');
        Route::get('/reopen-all/{companyId}', 'JobController@reOpenAll')->name('admin.job.reOpenAll')->where('companyId', '[0-9]+');
        Route::get('/apply/{id}', 'JobController@apply')->name('admin.job.apply')->where('id', '[0-9]+');
    });

    Route::prefix('setting')->group(function () {
        Route::get('group/{group}', 'SettingGroupController@detail')->name('admin.setting.group');
        Route::post('group/change-img', 'SettingGroupController@changeImg')->name('admin.setting.changeImg');
        Route::post('group/change-position', 'SettingGroupController@changePosition')->name('admin.setting.changePosition');
        Route::post('group/create', 'SettingGroupController@create')->name('admin.setting.create');
        Route::post('group/update', 'SettingGroupController@update')->name('admin.setting.update');
        Route::post('group/delete', 'SettingGroupController@delete')->name('admin.setting.delete');
    });

    // Otp
    Route::prefix('otp')->group(function () {
        Route::get('/', 'OtpCodesController@index')->name('admin.otp.index');
        Route::get('/reset/{id}', 'OtpCodesController@reset')->name('admin.otp.reset')->where('id', '[0-9]+');
        Route::get('/set-owner/{id}', 'OtpCodesController@setOwner')->name('admin.otp.setOwner')->where('id', '[0-9]+');
    });

    // Users
    Route::prefix('user')->group(function () {
        Route::get('/', 'UserController@index')->name('admin.user.index');
        Route::match(['get', 'post'],'/password/{id}', 'UserController@password')->name('admin.user.password');
        Route::match(['get', 'post'],'/edit/{id}', 'UserController@edit')->name('admin.user.edit');
        Route::get('/block/{id}', 'UserController@block')->name('admin.user.block');
        Route::get('/unblock/{id}', 'UserController@unblock')->name('admin.user.unblock');
    });

    // Demand
    Route::prefix('demand')->group(function () {
        Route::get('/', 'DemandController@index')->name('admin.demand.index');
        Route::get('/view/{id}', 'DemandController@view')->name('admin.demand.view');
        Route::get('/block/{id}', 'DemandController@block')->name('admin.demand.block');
        Route::get('/unblock/{id}', 'DemandController@unblock')->name('admin.demand.unblock');
        Route::get('/block-apply/{id}', 'DemandController@blockApply')->name('admin.demand.blockApply');
        Route::get('/unblock-apply/{id}', 'DemandController@unblockApply')->name('admin.demand.unblockApply');
        Route::match(['get', 'post'],'/update/{id}', 'DemandController@update')->name('admin.demand.update');
        Route::match(['get', 'post'],'/password/{id}', 'DemandController@password')->name('admin.demand.password');
        Route::get('/remove-img/{id}', 'DemandController@removeImg')->name('admin.demand.remove-img');
        Route::get('/history/{id}', 'ApplicantController@history')->name('admin.demand.history');
    });

	// Applicant
    Route::prefix('applicant')->group(function () {
        Route::get('/', 'ApplicantController@index')->name('admin.applicant.index');
        Route::get('/get-sequence-history/{content_id}', 'ApplicantController@getSequenceHistory')->name('admin.applicant.getSequenceHistory');
    });

    // Company
    Route::prefix('company')->group(function () {
        Route::get('/', 'CompanyController@index')->name('admin.company.index');
        Route::post('/change-max-job-num', 'CompanyController@changeMaxJobNum')->name('admin.company.changeMaxJobNum');
        Route::match(['get', 'post'],'/edit/{companyId}', 'CompanyController@company')->name('admin.company.edit');
    });

    // Admin KPI
    Route::prefix('kpi')->group(function () {
        // Supply KPI
        Route::get('/', 'KpiController@index')->name('admin.kpi.index');
        Route::get('/sequence', 'KpiController@sequence')->name('admin.kpi.sequence');
        Route::get('/cumulative-sequence', 'KpiController@cumulativeSequence')->name('admin.kpi.cumulative-sequence');
        Route::get('/rate', 'KpiController@Rate')->name('admin.kpi.rate');
        Route::get('/job-type', 'KpiController@JobType')->name('admin.kpi.job_type');
        Route::get('/jlpt', 'KpiController@Jlpt')->name('admin.kpi.jlpt');
        Route::get('/important', 'KpiController@Important')->name('admin.kpi.important');
        Route::get('/station', 'KpiController@Station')->name('admin.kpi.station');

        // Demand KPI
        Route::prefix('demand')->group(function () {
            Route::get('/', 'KpiDemandController@index')->name('admin.kpi.demand.index');
            Route::get('/rate', 'KpiDemandController@Rate')->name('admin.kpi.demand.rate');
            Route::get('/job-type', 'KpiDemandController@JobType')->name('admin.kpi.demand.job_type');
            Route::get('/jlpt', 'KpiDemandController@Jlpt')->name('admin.kpi.demand.jlpt');
            Route::get('/important', 'KpiDemandController@Important')->name('admin.kpi.demand.important');
            Route::get('/station', 'KpiDemandController@Station')->name('admin.kpi.demand.station');
        });

    });

    // Celebration
    Route::prefix('celebration')->group(function () {
        Route::get('/{type?}', 'CelebrationController@index')->name('admin.celebration.index');
        Route::get('/adoption/export1', 'CelebrationController@export1')->name('admin.celebration.export1');
        Route::get('/no-adoption/export2', 'CelebrationController@export2')->name('admin.celebration.export2');
        Route::get('/other/export3', 'CelebrationController@export3')->name('admin.celebration.export3');
    });

    //Setting max job, max salary
    Route::match(['get', 'post'],'/setting-job', 'JobController@setting')->name('admin.job.setting');


});

// End: For admin
