<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/open/HtmlHeaderOpen'); ?>
    </head>
    <body>
    <?php echo $this->element($this->Common->getIsp() . '/open/header_' . $this->Common->getAspSetting() . '_open'); ?>
    <div id="OpneContents">
      <div class="container">
        <h1 class="pagettl">公開ページへログイン</h1>
        <div class="txtCenter" style="padding-top:20px;">
          <p>メールアドレスを入力してログインボタンをクリックしてください。</p>
          <p>※「公開のご案内」のメールを受信したメールアドレスを入力してください。</p>
        </div>
        <div id="OpenLoginBox" class="txtCenter">
          <div id="OpenLoginForm">
            <form name="login_form" action="/open/login.html?id=<?= $openid ?>" method="POST">
              <p>
                <label>メールアドレス</label>
                <input name="mail" class="login_input"/>
              </p>
              <br />
              <p>
                <input type="hidden" name="open_id" value="<?= $openid ?>">
                <input type="submit" name="login" class="btnovr" value="ログイン" id="login_id" />
              </p>
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


