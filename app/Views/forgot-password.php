<div class="container container-960 content">
    <h3><?=strtoupper(lang('Nav.forgotpass'));?></h3>
    <?=form_open('', ['class'=>'form-validation forgotPassForm','novalidate'=>'novalidate']);?>
    <div id="pwStep1" class="box">
        <div class="password-steps">
            <div class="cur">
                <div class="step-number">1</div>
                <span><?=lang('Input.mobileno');?></span>
            </div>
            <i></i>
            <div>
                <div class="step-number">2</div>
                <span><?=lang('Label.resetpass');?></span>
            </div>
            <i></i>
            <div>
                <div class="step-number">3</div>
                <span><?=lang('Label.done');?></span>
            </div>
        </div>
        <div class="form-div">
            <label class="form-label"><?=lang('Input.mobileno');?></label>
            <select class="form-control form-select mb-2 regi-mobile-code" name="regionCode" required>
                <option value="HKD" selected><?=lang('Label.hongkong');?></option>
            </select>
            <div class="otp-flex">
                <input type="text" pattern="^[0-9]{8,11}$" class="form-control" id="regisUsername" name="mobile" placeholder="e.g. 0123456789" required>
                <a id="timer" class="btn" onclick="requestSmsTac2('forgotPassForm');"><?=lang('Nav.gettac');?></a>
            </div>
        </div>
        <div class="form-div">
            <label class="form-label"><?=lang('Input.smstac');?></label>
            <input class="form-control" type="text" id="floatingTAC" name="veritac" placeholder="<?=lang('Sentence.entersmstac');?>" required>
        </div>
        <input class="btn w-100" value="<?=lang('Nav.next');?>" onclick="$('#pwStep1').hide();$('#pwStep2').show();">
    </div>
    
    <div id="pwStep2" class="box" style="display:none;">
        <div class="password-steps">
            <div class="correct">
                <div class="step-number">1</div>
                <span><?=lang('Input.mobileno');?></span>
            </div>
            <i></i>
            <div class="cur">
                <div class="step-number">2</div>
                <span><?=lang('Label.resetpass');?></span>
            </div>
            <i></i>
            <div>
                <div class="step-number">3</div>
                <span><?=lang('Label.done');?></span>
            </div>
        </div>
        <div class="form-div">
            <label class="form-label"><?=lang('Input.newpassword');?></label>
            <input class="form-control" type="password" id="newPass" name="newpass" placeholder="<?=lang('Sentence.enterpassword');?>" required>
            <p class="input-desc"><?=lang('Validation.password');?></p>
        </div>
        <div class="form-div">
            <label class="form-label"><?=lang('Input.confirmpass');?></label>
            <input class="form-control" type="password" id="cNewPass" name="cnewpass" placeholder="<?=lang('Input.confirmpass');?>" required>
            <p class="input-desc"><?=lang('Validation.password');?></p>
        </div>
        <button type="submit" class="btn w-100"><?=lang('Label.resetpass');?></button>
    </div>
    
    <div id="pwStep3" class="box" style="display:none;">
        <div class="password-steps">
            <div class="correct">
                <div class="step-number">1</div>
                <span><?=lang('Input.mobileno');?></span>
            </div>
            <i></i>
            <div class="correct">
                <div class="step-number">2</div>
                <span><?=lang('Label.resetpass');?></span>
            </div>
            <i></i>
            <div class="cur">
                <div class="step-number">3</div>
                <span><?=lang('Label.done');?></span>
            </div>
        </div>
        <p class="box-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean faucibus iaculis convallis. Curabitur vel congue tellus, sit amet tempus tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <a class="btn w-100" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
    </div>
    <?=form_close();?>
</div>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.forgotPassForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.forgotPassForm [type=submit]').prop('disabled', true);

            const pw1 = document.getElementById('newPass').value;
            const pw2 = document.getElementById('cNewPass').value;
            if( pw1!=pw2 ) {
                swal.fire("Error!", "Passwords did not match", "error").then(()=>{
                    return false;
                });
            } else {
                var params = {};
                var formObj = $(this).closest("form");
                $.each($(formObj).serializeArray(), function (index, value) {
                    params[value.name] = value.value;
                });

                $.post('/user/forgot-password', {
                    params
                }, function(data, status) {
                    $('.forgotPassForm [type=submit]').prop('disabled', false);
                    const obj = JSON.parse(data);
                    if( obj.code==1 ) {
                        swal.fire("Success!", obj.message, "success").then(()=>{
                            window.location.replace("<?=base_url();?>");
                        });
                    } else {
                        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                            $('.forgotPassForm [type=submit]').prop('disabled', false);
                        });
                    }
                })
                .done(function() {
                    $('.forgotPassForm [type=submit]').prop('disabled', false);
                    $('#pwStep2').hide();$('#pwStep3').show();
                })
                .fail(function() {
                    swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
                        $('.forgotPassForm [type=submit]').prop('disabled', false);
                    });
                });
            }
        }
    });
});
</script>