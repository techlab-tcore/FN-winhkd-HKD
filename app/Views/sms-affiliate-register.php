<div class="container container-960 content">
    <h3><?=$secTitle;?></h3>
    <div class="box">

    <?=form_open('',['class'=>'form-validation smsRegisForm','novalidate'=>'novalidate'], ['affiliate'=>$affiliate]);?>
        <div class="form-div">
            <label class="form-label"><?=lang('Input.username');?></label>
            <input class="form-control" type="text" pattern="^[a-zA-Z0-9]{6,12}$" name="username" id="username" placeholder="<?=lang('Sentence.enterusername');?>" required>
            <p class="input-desc"><?=lang('Validation.username');?></p>
        </div>
        <div class="form-div">
            <label class="form-label"><?=lang('Input.password');?></label>
            <input class="form-control" type="password" pattern="^[a-zA-Z0-9]{6,}$" name="password" id="password" placeholder="<?=lang('Sentence.enterpassword');?>" required>
            <p class="input-desc"><?=lang('Validation.password');?></p>
        </div>
        <div class="form-div">
            <label class="form-label"><?=lang('Input.fullname');?></label>
            <input class="form-control" type="text" pattern="^{3,}$" name="fname" placeholder="<?=lang('Sentence.enterfullname');?>" required>
            <p class="input-desc"><?=lang('Validation.fullname');?></p>
        </div>
        <div class="form-div">
            <label class="form-label"><?=lang('Input.mobileno');?></label>
            <select class="form-control form-select mb-2 regi-mobile-code" name="regionCode" required>
                <option value="HKD" selected><?=lang('Label.hongkong');?></option>
            </select>
            <div class="otp-flex">
                <input class="form-control" type="text" pattern="^[0-9]{8,12}$" name="mobile" placeholder="e.g. 95155555" required>
                <a class="btn" id="timer" onclick="requestSmsTac2('smsRegisForm');"><?=lang('Nav.gettac');?></a>
            </div>
            <p class="input-desc"> </p>
        </div>
        <div class="form-div">
            <label class="form-label"><?=lang('Input.smstac');?></label>
            <input class="form-control" type="text" name="veritac" placeholder="<?=lang('Sentence.entersmstac');?>" required>
            <p class="input-desc"> </p>
        </div>

        <input type="submit" class="btn w-100" value="<?=lang('Nav.createacc');?>">
    <?=form_close();?>
    </div>
</div>

</div>
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

            $.post('/user/affiliate-registration', {
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