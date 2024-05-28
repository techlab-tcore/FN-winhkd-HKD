<main>

<!--
<a class="page-header d-block text-decoration-none p-3 fs-4 d-flex justify-content-between align-items-center mb-3" href="javascript:void(0);">
    <i class="bx bx-arrow-back"></i>
    <span class="mx-auto"><?//=$secTitle;?>@</span>
</a>
-->

<nav class="page-header d-block text-decoration-none p-3 fs-5 d-flex justify-content-between align-items-center mb-3">
    <!-- <a class="d-inline-block text-decoration-none" href="javascript:history.go(-1)"><i class="bx bx-arrow-back"></i></a> -->
    <label class="mx-auto"><?=$secTitle;?></label>
    <!-- <button type="button" class="btn text-light"><?//=lang('Nav.on9support');?></button> -->
    <a target="_blank" class="btn btn-sm text-light whatsapp btn-secondary"><i class="bx bx-support me-1"></i><?=lang('Nav.on9support');?></a>
</nav>

<!-- Languages -->
<ul class="nav justify-content-end position-absolute top-0 start-0 pt-2 pe-3">
    <li class="nav-item dropdown rounded dropdown-lang">
        <a class="nav-link dropdown-toggle text-light" href="#" id="dropdownMenuLang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="<?=$_SESSION['lang'];?>"></i>
            <?php
            if( $_SESSION['lang']=='zh' ):
                echo 'ZH';
            elseif( $_SESSION['lang']=='cn' ):
                echo 'CN';
            elseif( $_SESSION['lang']=='en' ):
                echo 'EN';
            else:
                echo 'MY';
            endif;
            ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end btn-outline-secondary rounded-3 shadow-lg menuLang" aria-labelledby="dropdownMenuLang">
            <li><a class="dropdown-item en" href="javascript:void(0)" onclick="translation('en')">English</a></li>
            <li><a class="dropdown-item zh" href="javascript:void(0)" onclick="translation('zh')">繁体中文</a></li>
            <li><a class="dropdown-item cn" href="javascript:void(0)" onclick="translation('cn')">简体中文</a></li>
            <li><a class="dropdown-item my" href="javascript:void(0)" onclick="translation('my')">Bahasa</a></li>
        </ul>
    </li>
</ul>
<!-- End Languages -->

<div class="container-fluid">

<?=form_open('',['class'=>'form-validation smsRegisForm','novalidate'=>'novalidate']);?>
<div class="input-group mb-3">
    <span class="input-group-text"><i class="bx bx-user"></i></span>
    <input type="text" class="form-control form-control-lg" pattern="^[a-zA-Z0-9]{6,12}$" name="username" id="username" placeholder="<?=lang('Input.username');?>" required>
    <small class="invalid-feedback"><?=lang('Validation.username');?></small>
</div>
<div class="input-group mb-3">
    <span class="input-group-text"><i class="bx bxs-lock"></i></span>
    <input type="password" class="form-control form-control-lg" pattern="^[a-zA-Z0-9]{6,}$" name="password" id="password" placeholder="<?=lang('Input.password');?>" required>
    <small class="invalid-feedback"><?=lang('Validation.password');?></small>
</div>
<div class="input-group mb-3">
    <span class="input-group-text"><i class='bx bxs-flag-alt'></i></span>
    <select class="form-control form-control-lg form-select" name="regionCode" required>
        <option value="MYR" selected><?=lang('Label.malaysia');?></option>
        <!--<option value="HKD"><?//=lang('Label.hongkong');?></option>-->
        <!--<option value="THB"><?//=lang('Label.thailand');?></option>-->
    </select>
</div>
<div class="input-group mb-3">
    <span class="input-group-text"><i class="bx bx-mobile"></i></span>
    <input type="text" class="form-control form-control-lg" pattern="^[0-9]{8,12}$" name="mobile" placeholder="<?=lang('Input.mobileno');?> .eg.0123456789" required>
    <small class="invalid-feedback"><?=lang('Validation.mobile',[8,12]);?></small>
</div>
<div class="input-group mb-3">
    <span class="input-group-text"><i class="bx bxs-user-rectangle"></i></span>
    <input type="text" class="form-control form-control-lg" pattern="^{3,}$" name="fname" placeholder="<?=lang('Input.fullname');?>" required>
    <small class="invalid-feedback"><?=lang('Validation.fullname');?></small>
</div>
<div class="input-group mb-3">
    <span class="input-group-text"><i class="bx bxs-mobile-vibration"></i></span>
    <input type="text" class="form-control form-control-lg" name="veritac" placeholder="<?=lang('Validation.whatsapptac');?>" required>
    <button type="button" class="btn btn-tac" id="timer" onclick="requestSmsTac('smsRegisForm');"><?=lang('Nav.gettac');?></button>
</div>
<button type="submit" class="btn btn-login text-uppercase"><?=lang('Nav.createacc');?></button>
<a class="btn btn-outline-light w-100 mt-2" href="<?=base_url();?>"><?=lang('Nav.back');?></a>

<article class="mt-4">
<p><?=lang('Validation.regis3');?></p>
<p><?=lang('Validation.regis1');?></p>
<p><?=lang('Validation.regis2');?></p>
</article>
<?=form_close();?>

</div>

<!-- Widgets -->
<nav class="wrap-float-widget guideline" id="guideline">
    <a href="<?=base_url('instruction');?>" class="btn-float-content"><img class="w-100" src="<?=base_url('../assets/img/tutorial/tutorial_btn_'.$_SESSION['lang'].'.png');?>"></a>
</nav>
<!-- End Widgets -->

</main>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.smsRegisForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.smsRegisForm [type=submit]').prop('disabled', true);

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });

            $.post('/user/registration', {
                params
            }, function(data, status) {
                $('.smsRegisForm [type=submit]').prop('disabled', false);
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    swal.fire("Success!", obj.message, "success").then(()=>{
                        window.location.replace("<?=base_url();?>");
                    });
                } else {
                    swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                        $('.smsRegisForm [type=submit]').prop('disabled', false);
                    });
                }
            })
            .done(function() {
                $('.smsRegisForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
                    $('.smsRegisForm [type=submit]').prop('disabled', false);
                });
            });
        }
    });
});
</script>