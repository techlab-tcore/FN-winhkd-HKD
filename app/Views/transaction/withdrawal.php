<div class="user-container container">
    <!-- Sidebar -->
    <?=view('sidebar');?>
    <!-- End Sidebar -->
    <div class="user-content">
        <!-- User Account -->
        <?=view('useraccount');?>
        <!-- End User Account -->
        <div class="box-black box-withdraw">
            <div>
                <p>Currency</p>
                <p><?=$_ENV['currencyCode'];?></p>
            </div>
            <div>
                <p><?=lang('Input.bank');?></p>
                <p class="label-bankName"></p>
            </div>
            <div class="info-large">
                <p><?=lang('Input.accno');?></p>
                <p class="text-primary label-accNo"></p>
            </div>
            <div class="info-large">
                <p><?=lang('Input.accholder');?></p>
                <p class="text-primary label-holder"></p>
            </div>
        </div>
        <?=form_open('',['class'=>'user-form form-validation customForm withdrawalForm','novalidate'=>'novalidate'],['currency'=>'']);?>
            <div class="form-flex">
                <label class="form-label"><?=lang('Label.withdrawalamount');?><i>*</i></label>
                <div class="input-wrap">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><?=$_ENV['currencyCode'];?></div>
                        </div>
                        <input type="number" step="any" min="100" max="10000" class="form-control" name="amount" placeholder="<?=lang('Validation.minwthdrawal',[100]);?>" required>
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
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.user-nav a[data-page=withdrawal]').addClass("cur");
    
    getUserDefaultBankCard();

    $('.withdrawalForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.withdrawalForm [type=submit]').prop('disabled', true);

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });

            $.post('/payment/withdrawal', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    swal.fire("Success!", obj.message, "success").then(() => {
                        getProfile();
                        $('form').removeClass('was-validated');
                        $('form').trigger('reset');
                    });
                } else {
                    swal.fire("<?=lang('Label.notif');?>", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                        $('.withdrawalForm [type=submit]').prop('disabled', false);
                    });
                }
            })
            .done(function() {
                $('.withdrawalForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
                    $('.withdrawalForm [type=submit]').prop('disabled', false);
                });
            });
        }
    });
});

async function getUserDefaultBankCard()
{
    generalLoading();

    $.get('/list/raw/bank-account/user', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 && obj.data!='' ) {
            swal.close();
            // getTransactionCount(2);

            const acc = obj.data;
            acc.forEach(function(item, index) {
                if( item.isDefault==1 ) {
                    $('.label-currency').html(item.currency);
                    $('.label-bankName').html(item.name);
                    $('.label-accNo').html(item.accno);
                    $('.label-holder').html(item.holder);

                    $('.withdrawalForm [name=currency]').val(item.currency);

                    if( item.currency=='MYR' )
                    {
                        $('.withdrawalForm [name=amount]').attr('placeholder', '<?=lang('Validation.minwthdrawal',[100]);?>');
                        $('.withdrawalForm [name=amount]').attr('min', 100);
                        $('.withdrawalForm [name=amount]').attr('max', 10000);
                    } else if( item.currency=='USDT' ) {
                        $('.withdrawalForm [name=amount]').attr('placeholder', '<?=lang('Validation.minwthdrawal',[100]);?>');
                        $('.withdrawalForm [name=amount]').attr('min', 100);
                        $('.withdrawalForm [name=amount]').attr('max', 5000);
                    } else { // HKD
                        $('.withdrawalForm [name=amount]').attr('placeholder', '<?=lang('Validation.minwthdrawal',[100]);?>');
                        $('.withdrawalForm [name=amount]').attr('min', 100);
                        $('.withdrawalForm [name=amount]').attr('max', 200000);
                    }

                    setTimeout(function(){
                        var ub = $('.user-wallet .userBalance').html();
                        // console.log(ub);
                        const convert = ub * item.withdrawRate;
                        $('.convertAmount').html(convert.toFixed(2));
                    }, 2000); 
                }
            });
        } else if( obj.code==1 && obj.data=='' ) {
            swal.fire({
                title: '<?=lang('Validation.tiedbc');?>'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('<?=base_url('user/bank-account');?>');
                }
            });
        } else if( obj.code==39 ) {
            forceUserLogout();
        } else {
            swal.fire("<?=lang('Label.error');?>!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}
</script>