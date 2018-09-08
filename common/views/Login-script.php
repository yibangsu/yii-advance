<?php
use common\assets\CryptoAsset;

CryptoAsset::register($this);
?>


<?php
$js = <<<JS
    $('#login-form').on('beforeSubmit', function(e) {
        
        var \$form = $(this);
        var \$str = \$.trim(document.getElementById("loginform-password").value);
        var \$random = \$.trim('$model->random');

        \$str = \$.trim(CryptoJS.MD5(\$str));
        \$str = CryptoJS.HmacSHA256(\$str, \$random);
        
        document.getElementById("loginform-password").value = \$str;
    });
JS;
    $this->registerJs($js);
?>
