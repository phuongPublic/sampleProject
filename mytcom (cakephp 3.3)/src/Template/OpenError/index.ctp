<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/open/HtmlHeaderOpen'); ?>
        <script type="text/javascript"> 
            $(document).ready(function(){
                $(function(){
                    $('input.btnstd').click(function(){});
                    $('input.btnstd').hover(function() {
                        $(this).addClass('btnstdOn');
                    },
                    function() {
                        $(this).removeClass('btnstdOn');
                    });
                });
            });
        </script>
    </head>
    <body>
    <?php echo $this->element($this->Common->getIsp() . '/open/header_' . $this->Common->getAspSetting() . '_open'); ?>
    <div id="OpneContents">
        <div class="container">
            <h1 class="pagettl">ログインエラー</h1>
            <div class="padArea" style="margin-top:50px;">
                <h2 class="txtRed txtCneter">
                    <?php if ($code == 1) : ?>
                        ログインページに戻って正しいメールアドレスを入力してください。<br />
                        又は、公開のご案内の送信者にお問い合わせください。
                    <?php endif; ?>
                    <?php if ($code == 2) : ?>
                        公開期間は終了しました。
                    <?php endif; ?>
                </h2>
            </div>
            <div id="OpenLoginBox" class="txtCenter">
                <div id="OpenLoginForm">
                    <form name="error" action="/open/login.html?<?= $cashe ?>" method="GET">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="submit" name="login_again" class="btnovr" value="戻る" id="login_id" />
                    </form>
                </div>
            </div>
            <!--広告管理タグ-->
            <div class="adContents1">
                <?php $this->Advertising->AdPublish(1,2);?>
            </div>
            <!--広告管理タグ-->
        </div>
    </div>
    <?php echo $this->element($this->Common->getIsp() . '/open/footer_' . $this->Common->getAspSetting() . '_open'); ?>
    </body>
</html>


