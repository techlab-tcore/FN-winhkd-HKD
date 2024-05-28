<div class="user-container container">
    <!-- Sidebar -->
    <?=view('sidebar');?>
    <!-- End Sidebar -->
    <div class="user-content">
        <!-- User Account -->
        <?=view('useraccount');?>
        <!-- End User Account -->
        <?=form_open('',['class'=>'user-form form-validation vaultForm','novalidate'=>'novalidate']);?>
            <div class="form-flex">
                <label class="form-label"><?=lang('Input.amount');?></label>
                <input type="number" step="any" class="form-control" name="amount" required>
            </div>
            <div class="form-flex">
                <label class="form-label"><?=lang('Input.vaultpin');?><i>*</i></label>
                <div class="input-group">
                    <input type="password" class="form-control" name="vaultpin" required>
                    <div class="input-group-append">
                        <div class="btn" data-bs-toggle="modal" data-bs-target="#modal-editpin"><?=lang('Nav.editpin');?></div>
                    </div>
                </div>
            </div>
            <div class="form-flex">
                <label class="form-label"></label>
                <input type="submit" class="btn" value="<?=lang('Nav.submit');?>">
            </div>
        <?=form_close();?>
    </div>
</div>
	
<div class="modal fade modal-setupVaultPin" id="modal-setupVaultPin" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?=lang('Label.newvaultpin');?></h3>
                <a class="modal-close icon-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <?=form_open('', ['class'=>'form-validation setupVaultPinForm user-form', 'novalidate'=>'novalidate']);?>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Input.vaultpin');?><i>*</i></label>
                        <div class="input-wrap">
                            <input class="form-control" type="password" pattern="^[0-9]{6,6}$" id="pin" name="pin" required>
                            <p class="input-desc"><?=lang('Validation.newvaultpin',[6]);?></p>
                        </div>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Input.confirmpin');?><i>*</i></label>
                        <input class="form-control" type="password" pattern="^[0-9]{6,6}$" id="cpin" name="cnewpin" required>
                    </div>
                    <input type="submit" class="btn w-100" value="<?=lang('Nav.submit');?>">
                <?=form_close();?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-editpin" id="modal-editpin" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?=lang('Label.editvaultpin');?></h3>
                <a class="modal-close icon-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <?=form_open('', ['class'=>'form-validation editVaultPinForm user-form', 'novalidate'=>'novalidate']);?>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Input.currentpin');?><i>*</i></label>
                        <div class="input-wrap">
                            <input class="form-control" type="password" pattern="^[0-9]{6,6}$" id="curpin" name="pin" required>
                            <p class="input-desc"><?=lang('Validation.vaultpin',[6]);?></p>
                        </div>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Input.newpin');?><i>*</i></label>
                        <div class="input-wrap">
                            <input class="form-control" type="password" pattern="^[0-9]{6,6}$" id="newpin" name="newpin" required>
                            <p class="input-desc"><?=lang('Validation.vaultpin',[6]);?></p>
                        </div>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Input.confirmpin');?><i>*</i></label>
                        <input class="form-control" type="password" pattern="^[0-9]{6,6}$" id="cnewpin" name="cnewpin" required>
                    </div>
                    <input type="submit" class="btn w-100" value="<?=lang('Nav.submit');?>">
                <?=form_close();?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.user-nav a[data-page=vault]').addClass("cur");

    checkExistVaultPin();

    $('.setupVaultPinForm').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            $('.setupVaultPinForm [type=submit]').prop('disabled', true);

            const pw1 = document.getElementById('pin').value;
            const pw2 = document.getElementById('cpin').value;
            if( pw1!=pw2 ) {
                swal.fire("Error!", "Pin did not match", "error").then(()=>{
                    return false;
                });
            }

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });
            
            $.post('/user/vault-pin/modify', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    swal.fire("Success!", obj.message, "success").then(() => {
                        $('.modal-setupVaultPin').modal('hide');
                    });
                } else {
                    swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                        $('.setupVaultPinForm [type=submit]').prop('disabled', false);
                    });
                }
            })
            .done(function() {
                $('.setupVaultPinForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(() => {
                    $('.setupVaultPinForm [type=submit]').prop('disabled', false);
                });
            });
        }
    });

    const setupVaultPinEvent = document.getElementById('modal-setupVaultPin');
    setupVaultPinEvent.addEventListener('hidden.bs.modal', function (event) {
        $('.modal').find('form').removeClass('was-validated');
        $('.modal').find('form').trigger('reset');
    });

    $('.editVaultPinForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            $('.editVaultPinForm [type=submit]').prop('disabled', true);

            const pw1 = document.getElementById('newpin').value;
            const pw2 = document.getElementById('cnewpin').value;
            if( pw1!=pw2 ) {
                swal.fire("Error!", "Pin did not match", "error").then(()=>{
                    return false;
                });
            }

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });
            
            $.post('/user/vault-pin/modify', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    swal.fire("Success!", obj.message, "success").then(() => {
                        $('.modal-editpin').modal('hide');
                        $('.editVaultPinForm [type=submit]').prop('disabled', false);
                    });
                } else {
                    swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                        $('.editVaultPinForm [type=submit]').prop('disabled', false);
                    });
                }
            })
            .done(function() {
                $('.editVaultPinForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(() => {
                    $('.editVaultPinForm [type=submit]').prop('disabled', false);
                });
            });
        }
    });

    const editpinEvent = document.getElementById('modal-editpin');
    editpinEvent.addEventListener('hidden.bs.modal', function (event) {
        $('.modal').find('form').removeClass('was-validated');
        $('.modal').find('form').trigger('reset');
    });

    $('.vaultForm').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            $('.vaultForm [type=submit]').prop('disabled', true);

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });
            
            $.post('/user/vault/balance/transfer', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    swal.fire("Success!", obj.message, "success").then(() => {
                        refreshBalance();
                    });
                } else {
                    swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                        $('.vaultForm [type=submit]').prop('disabled', false);
                    });
                }
            })
            .done(function() {
                $('.vaultForm [type=submit]').prop('disabled', false);
                $('form').removeClass('was-validated');
                $('form').trigger('reset');
            })
            .fail(function() {
                swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(() => {
                    $('.vaultForm [type=submit]').prop('disabled', false);
                });
            });
        }
    });
});

function checkExistVaultPin()
{
    generalLoading();

    $.get('/user/vault-pin/check', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.close();
            if( obj.havePassword==true ) {
                // verify2ndPass(user,amount);
            } else {
                $('.modal-setupVaultPin').modal('toggle');
            }
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                // $('.userTransferForm [type=submit]').prop('disabled', true);
            });
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}
</script>