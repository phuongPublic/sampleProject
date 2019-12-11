<link rel="stylesheet" href="css/screen/for-login.css"/>

<div class="limiter">
    <div class="container-login100 m-t-50">
        <div class="wrap-login100">
            <form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="post">
                    <span class="login100-form-title">
                        <?= $regist['label_sign_up'] ?>
                    </span>

                <?php if(isset($error)): ?>
                <div class="input-error m-b-16">
                    <label class="m-b-0">
                        <?= $error ?>
                    </label>
                </div>
                <?php endif; ?>

                <div class="wrap-input100 validate-input m-b-16" data-validate="<?= $regist['validate_name02_empty'] ?>">
                    <input class="input100 place" type="text" name="name02" id="name02" value="<?= (isset($data['name02']))? $data['name02'] : ''; ?>" placeholder="<?= $regist['placeholder_name02'] ?>(*)">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate="<?= $regist['validate_name01_empty'] ?>">
                    <input class="input100 place" type="text" name="name01" id="name01"
                           value="<?= (isset($data['name01']))? $data['name01'] : ''; ?>" placeholder="<?= $regist['placeholder_name01'] ?>(*)">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 m-b-16" data-validate="<?= $regist['validate_name02_empty'] ?>">
                    <input class="input100" type="number" name="phone"  onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength = "12" min = "1" max = "999999999999" value="<?= (isset($data['phone']))? $data['phone'] : ''; ?>" placeholder="<?= $regist['placeholder_phone'] ?>">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate="">
                    <input class="input100 place" type="text" name="email" id="email" placeholder="<?= $regist['placeholder_email'] ?>(*)">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate="<?= $regist['validate_password_empty'] ?>">
                    <input class="input100 place" type="password" id="pass" name="password" placeholder="<?= $regist['placeholder_password'] ?>(*)">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate="">
                    <input class="input100 place" type="password" id="pass_confirm" name="pass_confirm"
                           placeholder="<?= $regist['placeholder_password_confirm'] ?>(*)">
                    <span class="focus-input100"></span>
                </div>

                <div class="container-login100-form-btn m-t-60">
                    <button class="login100-form-btn">
                        <?= $regist['label_sign_up_text'] ?>
                    </button>
                </div>

                <div class="flex-col-c p-t-30 p-b-20">
                    <span class="txt4 p-b-9">
                        <?= $regist['label_have_acc'] ?>
                    </span>
                    <span class="txt3">
                        <a href="/login" class="login-btn">
                            <?= $regist['label_login'] ?>
                        </a>
                     </span>
                </div>
            </form>
            <input hidden id="validate_email_empty" value="<?= $regist['validate_email_empty'] ?>">
            <input hidden id="validate_password_confirm_empty" value="<?= $regist['validate_password_confirm_empty'] ?>">
            <input hidden id="validate_email_wrong" value="<?= $regist['validate_email_wrong'] ?>">
            <input hidden id="validate_password_wrong_compare" value="<?= $regist['validate_password_wrong_compare'] ?>">
        </div>
    </div>
</div>

<script>
    function maxLengthCheck(object) {
        if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
    }

    function isNumeric (evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode (key);
        var regex = /[0-9]|\./;
        if ( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>

<script src="js/screen/for-regist.js"></script>
