<main>

<a class="page-header d-block text-decoration-none p-3 fs-4 d-flex justify-content-between align-items-center mb-3" href="javascript:void(0);">
    <!--<i class="bx bx-arrow-back"></i>-->
    <span class="mx-auto"><?=$secTitle;?></span>
</a>
        
<!-- Languages -->
<ul class="nav justify-content-end position-absolute top-0 end-0 pt-2 pe-3">
    <li class="nav-item dropdown rounded dropdown-lang">
        <a class="nav-link dropdown-toggle text-light" href="#" id="dropdownMenuLang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="<?=$_SESSION['lang'];?>"></i>
            <?php
            if( $_SESSION['lang']=='zh' ): echo 'CN';
            else: echo 'EN'; endif;
            ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark rounded-3 shadow-lg menuLang" aria-labelledby="dropdownMenuLang">
            <li><a class="dropdown-item en" href="javascript:void(0)" onclick="translation('en')">English</a></li>
            <li><a class="dropdown-item zh" href="javascript:void(0)" onclick="translation('zh')">繁体中文</a></li>
            <li><a class="dropdown-item cn" href="javascript:void(0)" onclick="translation('cn')">简体中文</a></li>
            <li><a class="dropdown-item th" href="javascript:void(0)" onclick="translation('th')">ภาษาไทย</a></li>
        </ul>
    </li>
</ul>
<!-- End Languages -->


<div class="container-fluid">

<?=form_open('',['class'=>'form-validation smsRegisForm','novalidate'=>'novalidate'], ['affiliate'=>$affiliate]);?>
<div class="input-group mb-3">
    <span class="input-group-text rounded-0"><i class="bx bx-user"></i></span>
    <input type="text" class="form-control form-control-lg rounded-0" pattern="^[a-zA-Z0-9]{6,12}$" name="username" id="username" placeholder="<?=lang('Input.username');?>" required>
    <small class="invalid-feedback"><?=lang('Validation.username');?></small>
</div>
<div class="input-group mb-3">
    <span class="input-group-text rounded-0"><i class="bx bxs-lock"></i></span>
    <input type="password" class="form-control form-control-lg rounded-0" pattern="^[a-zA-Z0-9]{6,}$" name="password" id="password" placeholder="<?=lang('Input.password');?>" required>
    <small class="invalid-feedback"><?=lang('Validation.password');?></small>
</div>
<div class="input-group mb-3">
    <span class="input-group-text rounded-0"><i class="bx bx-mobile"></i></span>
    <input type="text" class="form-control form-control-lg rounded-0" pattern="^[0-9]{8,9}$" name="mobile" placeholder="<?=lang('Input.mobileno');?> .eg.81009545" required>
    <small class="invalid-feedback"><?=lang('Validation.mobile',[8,9]);?></small>
</div>
<div class="input-group mb-3">
    <span class="input-group-text rounded-0"><i class="bx bxs-user-rectangle"></i></span>
    <input type="text" class="form-control form-control-lg rounded-0" pattern="^{3,}$" name="fname" placeholder="<?=lang('Input.fullname');?>" required>
    <small class="invalid-feedback"><?=lang('Validation.fullname');?></small>
</div>
<button type="submit" class="btn-login text-uppercase"><?=lang('Nav.createacc');?></button>

<article class="mt-4">
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