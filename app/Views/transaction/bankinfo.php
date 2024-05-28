<main>

<nav class="page-header d-block text-decoration-none p-3 fs-4 d-flex justify-content-between align-items-center mb-3">
    <a class="d-inline-block text-decoration-none" href="javascript:history.go(-1)"><i class="bx bx-chevrons-left"></i></a>
    <label class="mx-auto"><?=$secTitle;?></label>
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target=".modal-support"><?=lang('Nav.on9support');?></button>
</nav>


<div class="container">
    <section class="">
        <h4 class="text-center text-warning"><?=lang('Input.amount');?>: <?=$_POST['currency'];?> <span class="finalAmount"></span></h4>
        <h3 class="text-center opacity-50"><?=lang('Validation.paymentdesc');?></h3>

        <?=form_open('',['class'=>'form-validation cdmForm mt-3','novalidate'=>'novalidate'],['amount'=>$_POST['amount'],'bank'=>$bankId,'card'=>$bankCardNo,'promotion'=>$_POST['promotion'], 'currency'=>$_POST['currency']]);?>
        <div class="row g-1 mb-3 d-flex align-items-center">
            <label class="col-form-label col-xl-3 col-lg-3 col-md-3 col-12 fs-xl-4 fs-lg-4 fs-md-4 fs-6 text-warning"><?=lang('Input.bankacc');?>:</label>
            <div class="col-xl-7 col-lg-7 col-md-7 col-9">
                <input type="text" class="form-control form-control-plaintext" name="accno" value="<?=$bankAccountNo;?>" readOnly required>
            </div>
            <div class="col-xl-auto col-lg-auto col-md-auto col-3 ms-auto text-end">
                <button type="button" class="btn btn-sm btn-secondary btn-copy-bankacc"><?=lang('Nav.copy');?></button>
            </div>
        </div>
        <div class="row g-1 mb-3 d-flex align-items-center">
            <label class="col-form-label col-xl-3 col-lg-3 col-md-3 col-12 fs-xl-4 fs-lg-4 fs-md-4 fs-6 text-warning"><?=lang('Input.accholder');?>:</label>
            <div class="col-xl-7 col-lg-7 col-md-7 col-9">
                <input type="text" class="form-control form-control-plaintext" name="accholder" value="<?=$holder;?>" readOnly required>
            </div>
            <div class="col-xl-auto col-lg-auto col-md-auto col-3 ms-auto text-end">
                <button type="button" class="btn btn-sm btn-secondary btn-copy-holder"><?=lang('Nav.copy');?></button>
            </div>
        </div>
        <div class="row g-1 mb-3 d-flex align-items-center">
            <label class="col-form-label col-xl-3 col-lg-3 col-md-3 col-12 fs-xl-4 fs-lg-4 fs-md-4 fs-6 text-warning"><?=lang('Input.branch');?>:</label>
            <div class="col-xl-7 col-lg-7 col-md-7 col-9">
                <input type="text" class="form-control form-control-plaintext" name="branch" value="<?=$branch;?>" readOnly required>
            </div>
            <div class="col-xl-auto col-lg-auto col-md-auto col-3 ms-auto text-end">
                <button type="button" class="btn btn-sm btn-secondary btn-copy-branch"><?=lang('Nav.copy');?></button>
            </div>
        </div>
        <div class="row g-1 mb-3 d-flex align-items-center">
            <label class="col-xl-3 col-lg-3 col-md-3 col-12 col-form-label fs-xl-4 fs-lg-4 fs-md-4 fs-6 text-warning"><?=lang('Input.uploadreceipt');?>:<span class="text-danger">*</span></label>
            <div class="col-xl-7 col-lg-7 col-md-7 col-12">
                <input class="form-control" type="file" id="receipt" name="receipt" required>
            </div>
        </div>
        <div class="d-grid gap-2 d-flex justify-content-between">
            <a class="btn btn-light btn-lg rounded-0 w-100" href="<?=base_url('choose-payment-method');?>"><?=lang('Nav.backreenter');?></a>
            <button type="submit" class="btn btn-secondary btn-lg rounded-0 w-100"><?=lang('Nav.donedeposit');?></button>
        </div>
        <?=form_close();?>

        <article class="mt-4">
            <p><?=lang('Validation.pgatewaynotice');?></p>

            <ul class="list-unstyled">
                <li><?=lang('Validation.bankinfo1');?></li>
                <li><?=lang('Validation.bankinfo2');?></li>
                <li><?=lang('Validation.bankinfo3');?></li>
                <li><?=lang('Validation.bankinfo4');?></li>
            </ul>

            <p><?=lang('Validation.bankinfosentence1');?></p>
            <p><?=lang('Validation.bankinfosentence2');?></p>
        </article>

    </section>
</div>

</main>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    let amount = Number('<?=$_POST['amount'];?>');
    //let random = Math.floor(Math.random() * (100 - 10) + 10) / 100;
    //let finalAmount = amount + random;
    let finalAmount = amount;
    $('.finalAmount').html(finalAmount);
    $('.cdmForm [name=amount]').val(finalAmount);

    $('.cdmForm .btn-copy-bankacc').on('click', function() {
        const copytext = $('.cdmForm [name=accno]');
        if( copytext!='' || copytext!=null ) {
            copytext.select();
            document.execCommand('copy');

            $('.cdmForm .btn-copy-bankacc').html('Copied');
            setInterval(function(){ 
                $('.cdmForm .btn-copy-bankacc').html('<?=lang('Nav.copy');?>');
            }, 1500);
        }
    });

    $('.cdmForm .btn-copy-holder').on('click', function() {
        const copytext = $('.cdmForm [name=accholder]');
        if( copytext!='' || copytext!=null ) {
            copytext.select();
            document.execCommand('copy');

            $('.cdmForm .btn-copy-holder').html('Copied');
            setInterval(function(){ 
                $('.cdmForm .btn-copy-holder').html('<?=lang('Nav.copy');?>');
            }, 1500);
        }
    });

    $('.cdmForm .btn-copy-branch').on('click', function() {
        const copytext = $('.cdmForm [name=branch]');
        if( copytext!='' || copytext!=null ) {
            copytext.select();
            document.execCommand('copy');

            $('.cdmForm .btn-copy-branch').html('Copied');
            setInterval(function(){ 
                $('.cdmForm .btn-copy-branch').html('<?=lang('Nav.copy');?>');
            }, 1500);
        }
    });

    $('.cdmForm').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            $('.cdmForm [type=submit]').prop('disabled', true);

            const imgSource = $('.cdmForm [name=receipt]')[0].files[0];
            const img = $('.cdmForm [name=receipt]')[0].files[0]['name'];
            const ext = img.substr( (img.lastIndexOf('.') +1) );

            let timestamp = Math.floor(Date.now() / 1000);
            const userstamp = '<?=isset($_SESSION['username'])?$_SESSION['username']:'';?>';
            const filename = userstamp + timestamp + '.' + ext;

            var params = {};
            var formObj = $('.cdmForm').closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
                //params['slip'] = '';
                params['slip'] = filename;
            });
            
            if( params['promotion']!='' )
            {
                // submitBankTransfer(params, imgSource);
                beforeDeposit(params, imgSource);
                //submitBankTransfer(params);
            } else {
                swal.fire({
                    title: '<?=lang('Validation.rusure');?>',
                    text: '<?=lang('Validation.nopromotion');?>',
                    showDenyButton: true,
                    confirmButtonText: '<?=lang('Nav.proceed');?>',
                    denyButtonText: `<?=lang('Nav.thinkagain');?>`,
                }).then( (result) => {
                    if( result.isConfirmed ) {
                        // submitBankTransfer(params, imgSource);
                        beforeDeposit(params, imgSource);
                        //submitBankTransfer(params);
                    } else if ( result.isDenied ) {
                        swal.close();
                        $('.cdmForm [type=submit]').prop('disabled', false);
                    }
                });
            }
        }
    });
});

function submitBankTransfer(params, imgSource)
{
    $.post('/payment/deposit', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            uploadslip(obj.agentid, obj.sessionid, obj.userid, obj.slipname, imgSource);
            swal.fire("<?=lang('Nav.donedeposit');?>!", obj.message + " (Code: "+obj.code+")", "success").then(() => {
                // getProfile();
                $('form').removeClass('was-validated');
                $('form').trigger('reset');
                $('.cdmForm [type=submit]').prop('disabled', false);

                window.location.replace("<?=base_url();?>");
            });
        } else {
            swal.fire("<?=lang('Label.error');?>!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
        $('.cdmForm [type=submit]').prop('disabled', false);
    })
    .fail(function() {
        swal.fire("<?=lang('Label.error');?>!", "Oopss! There are something wrong. Please try again later.", "error").then(() => {
            $('.cdmForm [type=submit]').prop('disabled', false);
        });
    });
}

function uploadslip(agid, sid, uid, slipname, imgSource)
{
    var fd = new FormData();
    fd.append('agentid', agid);
    fd.append('sessionid', sid);
    fd.append('userid', uid);
    fd.append('filename', slipname);
    fd.append('image', imgSource, slipname);

    $.ajax({
        type: 'POST',
        url: '<?=$_ENV['uploadurl']?>', 
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: function (obj) {},
        error: function(err){},
        beforeSend: function() {}
    }).done(function() {});
}

function beforeDeposit(params, imgSource)
{
    $.get('/refresh-credit/all', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            submitBankTransfer(params, imgSource);
        } else {
            swal.fire("", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
        
    })
    .fail(function() {
        swal.fire("", "Please try again later.", "error").then(() => {
            $('.cdmForm [type=submit]').prop('disabled', false);
        });
    });
}
</script>