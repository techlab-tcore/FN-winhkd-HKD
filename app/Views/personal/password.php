<div class="user-container container">
    <!-- Sidebar -->
    <?=view('sidebar');?>
    <!-- End Sidebar -->
    <div class="user-content">
        <!-- User Account -->
        <?=view('useraccount');?>
        <!-- End User Account -->`
        <div class="tab-nav tabNav">
            <div class="cur" target="#loginPassword"><?=lang('Nav.loginpass');?></div>
            <div target="#secondaryPassword"><?=lang('Nav.secondpass');?></div>
        </div>
        <div class="tabContent" id="loginPassword">
            <?=form_open('',['class'=>'form-validation chgPassForm user-form','novalidate'=>'novalidate']);?>
                <div class="form-flex">
                    <label class="form-label"><?=lang('Input.currentpass');?><i>*</i></label>
                    <div class="input-wrap">
                        <input type="password" class="form-control" pattern=".{6,}" name="currentpass" required>
                        <p class="input-desc"><?=lang('Validation.password',[6]);?></p>
                    </div>
                </div>
                <div class="form-flex">
                    <label class="form-label"><?=lang('Input.newpass');?><i>*</i></label>
                    <div class="input-wrap">
                        <input type="password" class="form-control" pattern=".{6,}" name="newpass" id="newpass" required>
                        <p class="input-desc"><?=lang('Validation.newpass',[6]);?></p>
                    </div>
                </div>
                <div class="form-flex">
                    <label class="form-label"><?=lang('Input.confirmpass');?><i>*</i></label>
                    <div class="input-wrap">
                        <input type="password" class="form-control" pattern=".{6,}" name="cnewpass" id="cnewpass" required>
                        <p class="input-desc"><?=lang('Validation.matchpass');?></p>
                    </div>
                </div>
                <div class="form-flex">
                    <label class="form-label"></label>
                    <input type="submit" class="btn" value="<?=lang('Nav.submit');?>">
                </div>
            <?=form_close();?>
        </div>
        <div class="tabContent" id="secondaryPassword" style="display:none">
            <?=form_open('',['class'=>'form-validation chg2ndPassForm user-form','novalidate'=>'novalidate']);?>
                <div class="form-flex">
                    <label class="form-label"><?=lang('Input.current2ndpass');?><i>*</i></label>
                    <div class="input-wrap">
                        <input type="password" class="form-control" pattern=".{6,}" name="current2ndpass" required>
                        <p class="input-desc"><?=lang('Validation.password',[6]);?></p>
                    </div>
                </div>
                <div class="form-flex">
                    <label class="form-label"><?=lang('Input.new2ndpass');?><i>*</i></label>
                    <div class="input-wrap">
                        <input type="password" class="form-control" pattern=".{6,}" name="new2ndpass" id="new2ndpass" required>
                        <p class="input-desc"><?=lang('Validation.newpass',[6]);?></p>
                    </div>
                </div>
                <div class="form-flex">
                    <label class="form-label"><?=lang('Input.confirm2ndpass');?><i>*</i></label>
                    <div class="input-wrap">
                        <input type="password" class="form-control" pattern=".{6,}" name="cnew2ndpass" id="cnew2ndpass" required>
                        <p class="input-desc"><?=lang('Validation.matchpass');?></p>
                    </div>
                </div>
                <div class="form-flex">
                    <label class="form-label"></label>
                    <input type="submit" class="btn" value="<?=lang('Nav.submit');?>">
                </div>
            <?=form_close();?>
        </div>	
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.user-nav a[data-page=password]').addClass("cur");

    $('.chgPassForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.chgPassForm [type=submit]').prop('disabled', true);

            const pw1 = document.getElementById('newpass').value;
            const pw2 = document.getElementById('cnewpass').value;
            if( pw1!=pw2 ) {
                swal.fire("<?=lang('Label.notif');?>", "<?=lang('Validation.matchpass');?>", "warning").then(()=>{
                    $('.chgPassForm [type=submit]').prop('disabled', false);
                    return false;
                });
            } else {
                var params = {};
                var formObj = $(this).closest("form");
                $.each($(formObj).serializeArray(), function (index, value) {
                    params[value.name] = value.value;
                });

                $.post('/user/login-password/modify', {
                    params
                }, function(data, status) {
                    $('.chgPassForm [type=submit]').prop('disabled', false);
                    const obj = JSON.parse(data);
                    if( obj.code==1 ) {
                        swal.fire("Success!", obj.message, "success").then(() => {
                            $('form').removeClass('was-validated');
                            $('form').trigger('reset');
                            window.location.href = "<?=base_url('user/logout');?>";
                        });
                    } else {
                        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                            $('.chgPassForm [type=submit]').prop('disabled', false);
                        });
                    }
                })
                .done(function() {
                    $('.chgPassForm [type=submit]').prop('disabled', false);
                })
                .fail(function() {
                    swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
                        $('.chgPassForm [type=submit]').prop('disabled', false);
                    });
                });
            }
        }
    });

    $('.chg2ndPassForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.chg2ndPassForm [type=submit]').prop('disabled', true);

            const pw1 = document.getElementById('new2ndpass').value;
            const pw2 = document.getElementById('cnew2ndpass').value;
            if( pw1!=pw2 ) {
                swal.fire("<?=lang('Label.notif');?>", "<?=lang('Validation.matchpass');?>", "warning").then(()=>{
                    $('.chg2ndPassForm [type=submit]').prop('disabled', false);
                    return false;
                });
            } else {
                var params = {};
                var formObj = $(this).closest("form");
                $.each($(formObj).serializeArray(), function (index, value) {
                    params[value.name] = value.value;
                });

                $.post('/user/secondary-password/modify', {
                    params
                }, function(data, status) {
                    $('.chg2ndPassForm [type=submit]').prop('disabled', false);
                    const obj = JSON.parse(data);
                    if( obj.code==1 ) {
                        swal.fire("Success!", obj.message, "success").then(() => {
                            $('form').removeClass('was-validated');
                            $('form').trigger('reset');
                        });
                    } else {
                        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                            $('.chg2ndPassForm [type=submit]').prop('disabled', false);
                        });
                    }
                })
                .done(function() {
                    $('.chg2ndPassForm [type=submit]').prop('disabled', false);
                })
                .fail(function() {
                    swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
                        $('.chg2ndPassForm [type=submit]').prop('disabled', false);
                    });
                });
            }
        }
    });
});
</script>