<link rel="stylesheet" href="css/screen/forsearch.css"/>
<link rel="stylesheet" href="css/common/bootstrap-select.css">
<div class="container" style="margin-top: 70px">

    <div class="row">
       <div class="col-xs-6" style="text-align: center;"><a href="/MyJob?savedJob=1" class="btn btn-success" style="width: 100%;text-decoration: none;"><?= $myjob['btn_saved_job'] ?></a></div>
       <div class="col-xs-6" style="text-align: center"><a href="/MyJob?appliedJob=1" class="btn btn-info" style="width: 100%"><?= $myjob['btn_applied_job'] ?></a></div>
    </div>

    <!-- viec lam da luu -->
    <?php if(isset($savedJob)) : ?>
    <div class="row rank-job-title m-t-20 bg-hp-job">
        <p class="font-design-lg title-myjob">
            <b><?= $myjob['label_saved_job'] ?></b>
        </p>
    </div>
    <div class="row">
        <img class="img-responsive" src="img/screen_img/icon/dotted-line-white-med.png" alt=""/>
    </div>
    <!-- no result for view-->
    <?php if(count($savedJob) == 0): ?>
    <p class="no-result">
        <?= $myjob['no_job_saved'] ?>
    </p>
    <?php endif; ?>

    <?php foreach ($savedJob as $item): ?>
    <div class="row rank-job-list">
        <div class="col-xs-10">
            <a href="/jobDetail?job_id=<?= $item['product_id'] ?>" target="_self"
               title="<?= $item['main_list_comment_vn'] ?>">
                <p class="font-design-lg job-title-text">
                    <b><?= $item['name'.$textLangCommon] ?></b>
                </p>
            </a>
        </div>
        <div class="col-xs-2 m-t-5">
            <a href="/MyJob?job_id=<?= $item['product_id'] ?>&delete=1" target="_self">
                <img src="img/screen_img/icon/delete_icon.png" class="img-responsive" style="float: right;max-height: 12px"/>
            </a>
        </div>
        <!-- logo -->
        <div class="col-xs-3 job-unit-myjob-height">
            <div class="logo-box">
                <img class="img-responsive job-logo" src="<?= $item['base64Img'] ?>" alt="Facebook"/>
            </div>
        </div>
        <div class="col-xs-9">
            <p class="job-salary-text">
                <img src="img/screen_img/icon/salary_icon.png" alt=""/>
                <b><?= $item['salary_min'] ?><?= $item['currency']==1 ? 'JPY' : 'USD'?>〜<?= $item['salary_max'] ?><?= $item['currency']==1 ? 'JPY' : 'USD'?></b>
            </p>
            <p class="job-place-text">
                <img src="img/screen_img/icon/job_place.png" alt=""/>
                <b><?= $item['region']['name'.$textLangCommon] ?></b>
            </p>
        </div>
    </div>
    <?php endforeach; ?>

    <?php else : ?>
    <!-- viec lam da ung tuyen -->
    <div class="row rank-job-title m-t-20 bg-hp-job">
        <p class="font-design-lg title-myjob">
            <b><?= $myjob['label_applied_job'] ?></b>
        </p>
    </div>

    <div class="row">
        <img class="img-responsive" src="img/screen_img/icon/dotted-line-white-med.png" alt=""/>
    </div>

    <!-- no result for view-->
    <?php if(count($appliesJob) == 0): ?>
    <p class="no-result">
        <?= $myjob['no_job_applied'] ?>
    </p>
    <?php endif; ?>

    <?php foreach ($appliesJob as $item): ?>
    <div class="row rank-job-list">

        <div class="col-xs-12">
            <a href="/jobDetail?job_id=<?= $item['product_id'] ?>" target="_self"
               title="<?= $item['main_list_comment_vn'] ?>">
                <p class="font-design-lg job-title-text">
                    <b><?= $item['name'.$textLangCommon] ?></b>
                </p>
            </a>
        </div>

        <!-- logo -->
        <div class="col-xs-3 job-unit-myjob-height">
            <div class="logo-box">
                <a href="/jobDetail?job_id=<?= $item['product_id'] ?>" target="_self">
                    <img class="img-responsive job-logo" src="<?= $item['base64Img'] ?>" alt="Facebook"/>
                </a>
            </div>
        </div>
        <div class="col-xs-9 ">
            <p class="job-salary-text">
                <img src="img/screen_img/icon/salary_icon.png" alt=""/>
                <b><?= $item['salary_min'] ?><?= $item['currency']==1 ? 'JPY' : 'USD'?>〜<?= $item['salary_max'] ?><?= $item['currency']==1 ? 'JPY' : 'USD'?></b>
            </p>
            <p class="job-place-text">
                <img src="img/screen_img/icon/job_place.png" alt=""/>
                <b><?= $item['region']['name'.$textLangCommon] ?></b>
            </p>
        </div>
    </div>
    <?php endforeach; ?>

    <?php endif; ?>
</div>
<script src="js/common/bootstrap-select.js"></script>
