<div class="error-mesages-right text-left" id="errorArea" style="display: none;">
    <?php
        if(!empty(session('Error'))){
            echo '<p>' . session('Error') . '</p>';
        }

        if(!empty($errors)){
            $errors = is_array($errors) ? $errors : $errors->all();
            foreach($errors as $error){
                echo '<p>' . $error . '</p>';
            }
        }
    ?>
</div>

<div class="error-mesages-right bg-success text-left" id="successArea" style="display: none;">
    <?php
        if(!empty(session('Success'))){
            echo '<p>' . session('Success') . '</p>';
        }
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // show errorArea when have content
        if($('#errorArea').children().length > 0){
            $('#errorArea').show('slow');
        }

        // show successArea when have content
        if($('#successArea').children().length > 0){
            $('#successArea').show('slow');
        }
    })
</script>
