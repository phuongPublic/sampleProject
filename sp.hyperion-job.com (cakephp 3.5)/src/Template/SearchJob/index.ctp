<link rel="stylesheet" href="css/screen/forsearch.css"/>
<link rel="stylesheet" href="css/common/bootstrap-select.css">
<div class="container" style="margin-top: 70px">
    <div class="row">
        <form class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 job-form" 　name="form1" id='form1'
              method="post" 　>
            <h3><?= $searchjob['title_search'] ?></h3>

            <input type="text" class="form-control white" placeholder="<?= $searchjob['key_word'] ?>" id="searchKeyword"
                   value="<?= isset($searchKeyword)? $searchKeyword : '' ?>">

            <?=
            $this->Form->select(
            'searchJobType',
            [1=>$searchjob['official_staff'], 2=>$searchjob['part_time'], 3=>$searchjob['dispatch']],
            [
            'class' => 'selectpicker',
            'title' => $searchjob['choose_job']
            ]
            )
            ?>

            <?=
            $this->Form->select(
            'searchJobCart',
            $jobCartArray,
            [
            'class' => 'selectpicker',
            'title' => $searchjob['cart_job'],
            'data-size' => 10,
            ]
            )
            ?>

            <?=
            $this->Form->select(
            'searchRegion',
            $RegionArray,
            [
            'class' => 'selectpicker',
            'title' => $searchjob['place_job'],
            'data-size' => 10,
            ]
            )
            ?>

            <!--hidden affer seminar-->
            <div class="dis-none">
                <?=
                $this->Form->select(
                'searchFrom',
                [1=>$searchjob['search_from_vn'], 2=>$searchjob['search_from_jp']],
                [
                'class' => 'selectpicker',
                'title' => $searchjob['search_from_job'],
                ]
                )
                ?>
            </div>


            <div style="text-align: center;margin-top: -20px">
                <input type="button" onclick="SubmitSearch();" class="btn dark-red btn-search btn-fix" title="Tìm kiếm"
                       value="<?= $searchjob['search_btn_job'] ?>"
                       name="search"/>
            </div>
        </form>
    </div>

    <?php if(!isset($search)) : ?>
    <!-- job list -->
    <!-- viec lam hap dan -->

    <div class="row">
        <p class="font-design-lg title-jobtype">
            <b><?= $searchjob['attractive_job'] ?></b>
        </p>
        <img class="img-responsive" src="img/screen_img/icon/dotted-line-white-med.png" alt=""/>
    </div>

    <?php foreach ($jobAbs as $item): ?>
    <div class="row rank-job-list">
        <!-- logo -->
        <div class="col-xs-3 job-unit-height">
            <div class="logo-box">
                <a href="/jobDetail?job_id=<?= $item['product_id'] ?>" target="_self">
                    <img class="img-responsive job-logo" src="<?= $item['base64Img'] ?>" alt="Facebook"/>
                </a>
            </div>
        </div>
        <div class="col-xs-9 ">
            <a href="/jobDetail?job_id=<?= $item['product_id'] ?>" target="_self"
               title="<?= $item['main_list_comment_vn'] ?>">
                <p class="font-design-lg job-title-text">
                    <b><?= $item['name'.$textLang] ?></b>
                </p>
            </a>
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

    <!-- viec lam tuyen gap -->
    <div class="row">
        <p class="font-design-lg title-jobtype ">
            <b><?= $searchjob['hiring_job'] ?></b>
        </p>
        <img class="img-responsive" src="img/screen_img/icon/dotted-line-white-med.png" alt=""/>
    </div>

    <?php foreach ($jobFast as $item): ?>
    <div class="row rank-job-list">
        <!-- logo -->
        <div class="col-xs-3 job-unit-height">
            <div class="logo-box">
                <a href="/jobDetail?job_id=<?= $item['product_id'] ?>" target="_self">
                    <img class="img-responsive job-logo" src="<?= $item['base64Img'] ?>" alt="Facebook"/>
                </a>
            </div>
        </div>
        <div class="col-xs-9 ">
            <a href="/jobDetail?job_id=<?= $item['product_id'] ?>" target="_self"
               title="<?= $item['main_list_comment_vn'] ?>">
                <p class="font-design-lg job-title-text">
                    <b><?= $item['name'.$textLang] ?></b>
                </p>
            </a>
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
    <div class="row">
        <p class="font-design-lg title-jobtype ">
            <b><?= $searchjob['search_result'] ?></b>
        </p>
        <div class="text-center">
            <ul class="pagination">
                <li class="prev"><a href="<?= $pageData['queryStr'] ?>page=<?= $pageData['back'] ?>">«</a></li>
                <?php foreach ($pageData['link_num'] as $pageItem): ?>
                <li <?= ($pageItem == $pageData['page']) ? 'class="active"' : '' ?> ><a href="<?= $pageData['queryStr'] ?>page=<?= $pageItem ?>" ><?= $pageItem ?></a></li>
                <?php endforeach; ?>
                <li class="next"><a href="<?= $pageData['queryStr'] ?>page=<?= $pageData['next'] ?>">»</a></li>
            </ul>
        </div>
        <img class="" src="img/screen_img/icon/dotted-line-white-med.png" alt=""/>
    </div>
    <?php foreach ($jobSearchResult as $item): ?>
    <div class="row rank-job-list">
        <!-- logo -->
        <div class="col-xs-3 job-unit-height">
            <div class="logo-box">
                <a href="/jobDetail?job_id=<?= $item['product_id'] ?>" target="_self">
                    <img class="img-responsive job-logo" src="<?= $item['base64Img'] ?>" alt="Facebook"/>
                </a>
            </div>
        </div>
        <div class="col-xs-9 ">
            <a href="/jobDetail?job_id=<?= $item['product_id'] ?>" target="_self"
               title="<?= $item['main_list_comment_vn'] ?>">
                <p class="font-design-lg job-title-text">
                    <b><?= $item['name'.$textLang] ?></b>
                </p>
            </a>
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
    <div class="text-center">
        <ul class="pagination">
            <li class="prev"><a href="<?= $pageData['queryStr'] ?>page=<?= $pageData['back'] ?>">«</a></li>
            <?php foreach ($pageData['link_num'] as $pageItem): ?>
            <li <?= ($pageItem == $pageData['page']) ? 'class="active"' : '' ?> ><a href="<?= $pageData['queryStr'] ?>page=<?= $pageItem ?>" ><?= $pageItem ?></a></li>
            <?php endforeach; ?>
            <li class="next"><a href="<?= $pageData['queryStr'] ?>page=<?= $pageData['next'] ?>">»</a></li>
        </ul>
    </div>
    <!--search result = 0-->
        <?php if(count($jobSearchResult) == 0): ?>
            <p class="no-result">
                <?= $searchjob['search_no_result'] ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="js/common/bootstrap-select.js"></script>
<script>
    function SubmitSearch() {
        var searchKeyword = $('#searchKeyword').val();
        var searchJobType = $('select[name=searchJobType]').val();
        var searchJobCart = $('select[name=searchJobCart]').val();
        var searchRegion = $('select[name=searchRegion]').val();
        var searchFrom = $('select[name=searchFrom]').val();

        var url_action = '/SearchJob?search=1&' +
            'searchKeyword=' + searchKeyword + "&" +
            'searchJobType=' + searchJobType + "&" +
            'searchJobCart=' + searchJobCart + "&" +
            'searchRegion=' + searchRegion + "&" +
            'searchFrom=' + searchFrom;
        $('#form1').attr('action', url_action);
        $('#form1').submit();
    }
</script>



