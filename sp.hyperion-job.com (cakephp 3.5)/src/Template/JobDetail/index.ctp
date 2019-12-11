<link rel="stylesheet"  href="css/screen/for-job-details.css" />

<div class="container">
    <div class="row detail-job-form">
        <div class="col-xs-12 detail-company pading-0 mgtop100 border-fix p-b-15">
            <div class="col-xs-12 pading-0 bg-color-title detail-min-height">
                <div class="col-xs-10 " >
                    <p class="padding-title-intro">
                        <?= $JobInfo['name'.$textLangCommon] ?>
                    </p>
                </div>
                <div class="col-xs-1 active-icon" onclick="<?= (!$jobSaved) ? 'saveJob();' : ''?>" >
                    <i class="fa fa-heart" <?= ($jobSaved) ? 'style="color: rgba(255, 66, 66, .85);"' : ''?>></i>
                </div>
            </div>

            <p class="deadline"><?= $jobdetail['label_end_date'] ?> <?= !empty($JobInfo['end_date']) ? $JobInfo['end_date']->i18nFormat('YYYY/MM/dd') : ''?></p>
            <div class="col-xs-6 text-align-right">
                <?php if(isset($JobInfo['product_status_id'][0])) : ?>
                    <i class="fa fa-star-o job-status abs-box"><span>&#32;<?= $jobdetail['label_popularity'] ?></span></i>
                <?php endif; ?>
            </div>
            <div class="col-xs-6 text-align-left">
                <?php if(isset($JobInfo['product_status_id'][1])) : ?>
                    <i class="fa fa-rocket job-status rec-fast-box"><span>&#32;<?= $jobdetail['label_dispatch'] ?></span></i>
                <?php endif; ?>
            </div>

            <div class="col-xs-10 col-xs-offset-1 text-align-center apply-button" >
                <?php if(!$JobApplied) : ?>
                <a href="/jobDetail?job_id=<?= h($JobInfo['product_id']) ?>&apply=1"><span><?= $jobdetail['label_apply'] ?></span></a>
                <?php else : ?>
                <span style="color: white;"><?= $jobdetail['label_applied'] ?></span>
                <?php endif; ?>
            </div>
        </div>
        <!-- thông tin tuyển dụng -->
        <div class="col-xs-12 detail-company pading-0 mgtop10">
            <div class="col-xs-12 pading-0 bg-color-title detail-min-height detail-title">
                <div class="col-xs-1 detail-title-icon">
                    <i class="fa fa-info-circle"></i>
                </div>
                <div class="col-xs-9 pading-0">

                    <p class="padding-title-detail">
                        <span><?= $jobdetail['label_rec_info'] ?></span>
                    </p>
                </div>
                <div class="col-xs-1 active-icon">
                    <i class="fa fa-plus-square"></i>
                </div>
            </div>
            <table class="table table-bordered detail-info hiden-detail">
                <tbody>
                <tr >
                    <td class="label-fix"><?= $jobdetail['label_employment_status'] ?></td>
                    <td><?= h($JobInfo['employment_status']) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_position'] ?></td>
                    <td><?= h($JobInfo['position']) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_salary_rank'] ?></td>
                    <td><?= h($JobInfo['salary_rank']) ?><br><?= nl2br(h($JobInfo['salary'.$textLangCommon])) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_place'] ?></td>
                    <td><?= nl2br($JobInfo['place']) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_traffic_access'] ?></td>
                    <td><?= nl2br(h($JobInfo['traffic_access'.$textLangCommon])) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_work_time'] ?></td>
                    <td><?= nl2br($JobInfo['work_time']) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_working_day'] ?></td>
                    <td><?= nl2br(h($JobInfo['working_day'.$textLangCommon])) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_trial_period'] ?></td>
                    <td><?= nl2br(h($JobInfo['trial_period'.$textLangCommon])) ?></td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Yêu cầu công việc -->
        <div class="col-xs-12 detail-company pading-0 mgtop10">
            <div class="col-xs-12 pading-0 bg-color-title detail-min-height detail-title">
                <div class="col-xs-1 detail-title-icon">
                    <i class="fa fa fa-file-text"></i>
                </div>
                <div class="col-xs-9 pading-0">

                    <p class="padding-title-detail">
                        <?= $jobdetail['label_work_conditions'] ?>
                    </p>
                </div>
                <div class="col-xs-1 active-icon ">
                    <i class="fa fa-plus-square"></i>
                </div>
            </div>
            <table class="table table-bordered detail-info hiden-detail">
                <tbody>
                <tr >
                    <td class="label-fix"><?= $jobdetail['label_offer_number'] ?></td>
                    <td><?= h($JobInfo['offer_number']) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_sex'] ?></td>
                    <td><?= h($JobInfo['sex']) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_qualification'] ?></td>
                    <td><?= nl2br(h($JobInfo['qualification'.$textLangCommon])) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_personality'] ?></td>
                    <td><?= nl2br(h($JobInfo['personality'.$textLangCommon])) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_skill'] ?></td>
                    <td><?= nl2br(h($JobInfo['skill'.$textLangCommon])) ?></td>
                </tr>
                </tbody>
            </table>
        </div>

        <!--CHẾ ĐỘ PHÚC LỢI -->
        <div class="col-xs-12 detail-company pading-0 mgtop10">
            <div class="col-xs-12 pading-0 bg-color-title detail-min-height detail-title">
                <div class="col-xs-1 detail-title-icon">
                    <i class="fa fa fa-coffee"></i>
                </div>
                <div class="col-xs-9 pading-0">

                    <p class="padding-title-detail">
                        <?= $jobdetail['label_welfare'] ?>
                    </p>
                </div>
                <div class="col-xs-1 active-icon ">
                    <i class="fa fa-plus-square"></i>
                </div>
            </div>
            <table class="table table-bordered detail-info hiden-detail">
                <tbody>
                <tr >
                    <td class="label-fix"><?= $jobdetail['label_payrise'] ?></td>
                    <td><?= nl2br(h($JobInfo['payrise'.$textLangCommon])) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_bonus'] ?></td>
                    <td><?= nl2br(h($JobInfo['bonus'.$textLangCommon])) ?></td>
                </tr>
                <tr >
                    <td class="label-fix"><?= $jobdetail['label_insurance'] ?></td>
                    <td><?= nl2br(h($JobInfo['insurance'.$textLangCommon])) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_welfare_content'] ?></td>
                    <td><?= nl2br($JobInfo['welfare']) ?></td>
                </tr>
                <tr >
                    <td class="label-fix"><?= $jobdetail['label_other_welfare'] ?></td>
                    <td><?= nl2br(h($JobInfo['other_welfare'.$textLangCommon])) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_medical_checkup'] ?></td>
                    <td><?= nl2br(h($JobInfo['medical_checkup'.$textLangCommon])) ?></td>
                </tr>
                </tbody>
            </table>
        </div>

        <!--mô tả công việc -->
        <div class="col-xs-12 detail-company pading-0 mgtop10 border-fix">
            <div class="col-xs-12 pading-0 bg-color-title detail-min-height detail-title">
                <div class="col-xs-1 detail-title-icon">
                    <i class="fa fa fa-tasks"></i>
                </div>
                <div class="col-xs-9 pading-0">

                    <p class="padding-title-detail">
                        <?= $jobdetail['label_job_description'] ?>
                    </p>
                </div>
                <div class="col-xs-1 active-icon ">
                    <i class="fa fa-plus-square"></i>
                </div>
            </div>
            <div class="col-xs-12 p-t-10 detail-info hiden-detail" >
                    <p class="job-description">
                        <?= nl2br(h($JobInfo['main_comment'.$textLangCommon])) ?>
                    </p>
            </div>
        </div>

        <?php if(!empty($JobInfo['client_introduction'])) : ?>
        <!--Thông tin nhà tuyển dụng -->
        <div class="col-xs-12 detail-company pading-0 mgtop10 border-fix">
            <div class="col-xs-12 pading-0 bg-color-title detail-min-height detail-title">
                <div class="col-xs-1 detail-title-icon">
                    <i class="fa fa fa-group"></i>
                </div>
                <div class="col-xs-9 pading-0">

                    <p class="padding-title-detail">
                        <?= $jobdetail['label_employer_info'] ?>
                    </p>
                </div>
                <div class="col-xs-1 active-icon ">
                    <i class="fa fa-plus-square"></i>
                </div>
            </div>
            <div class="col-xs-12 p-t-10 detail-info hiden-detail" >
                <p class="job-description">
                    <?= nl2br(h($JobInfo['client_introduction'])) ?>
                </p>
            </div>
        </div>
        <?php endif; ?>

        <!--Phương pháp ứng tuyển -->
        <div class="col-xs-12 detail-company pading-0 mgtop10">
            <div class="col-xs-12 pading-0 bg-color-title detail-min-height detail-title">
                <div class="col-xs-1 detail-title-icon">
                    <i class="fa fa fa-id-card"></i>
                </div>
                <div class="col-xs-9 pading-0">

                    <p class="padding-title-detail">
                        <?= $jobdetail['label_application_method'] ?>
                    </p>
                </div>
                <div class="col-xs-1 active-icon ">
                    <i class="fa fa-plus-square"></i>
                </div>
            </div>
            <table class="table table-bordered detail-info hiden-detail">
                <tbody>
                <tr >
                    <td class="label-fix"><?= $jobdetail['label_application_conntent'] ?></td>
                    <td><?= nl2br(h($JobInfo['applicate_method'.$textLangCommon])) ?></td>
                </tr>
                <tr>
                    <td class="label-fix"><?= $jobdetail['label_selection_process'] ?></td>
                    <td><?= nl2br($JobInfo['selection_process']) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="js/screen/for-detail.js"></script>
<script>
    function saveJob() {
        window.location.assign("/jobDetail?job_id=<?= h($JobInfo['product_id']) ?>&save_job=1");
    }
</script>
