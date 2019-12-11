<?php
use Cake\Core\Configure;
?>
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="Description" content="" />
<meta name="Keywords" content="" />
<title>管理画面｜<?php echo Configure::read('IspTitle');?></title>
<link rel="stylesheet" type="text/css" href="/contents/admin/css/common.css" media="screen,print" />
<script type="text/javascript" src="/contents/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/contents/admin/js/public_html.js"></script>
<script type="text/javascript" src="/contents/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    // prevent double click
    $("#toggleSubmit").on("click", function(e) {
        $("#toggleSubmit").prop('disabled', true);
        var isValid = $('form').valid();
        if(!isValid) {
            e.preventDefault();
            $("#toggleSubmit").prop('disabled', false);
        }
        if (isValid) {
            $('form').submit();
        }
    });
    
    $(document).ready(function () {
                $('form').keypress(function(e){
                    if (e.which == 13) {
                        e.preventDefault();
                        return false;
                    }
                });
            });
});
</script>