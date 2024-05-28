<main>

<nav class="page-header d-block text-decoration-none p-3 fs-4 d-flex justify-content-between align-items-center mb-3">
    <a class="d-inline-block text-decoration-none" href="javascript:history.go(-1)"><i class="bx bx-chevrons-left"></i></a>
    <label class="mx-auto"><?=$secTitle;?></label>
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target=".modal-support"><?=lang('Nav.on9support');?></button>
</nav>

<div class="container">

<section class="card bg-dark my-3 shadow">
    <div class="card-body">
        <h4 class="text-center text-warning">
            <?=lang('Input.amount');?>: <?=$_POST['currency'].number_format($_POST['amount'],2,'.',',');?>
        </h4>
        <h3 class="text-center opacity-50"><?=lang('Validation.paymentdesc');?></h3>

        <?=form_open('', ['class'=>'form-validation qr711Form','novalidate'=>'novalidate'],['bank'=>$_POST['bank'],'accno'=>$_POST['accNo'],'card'=>$_POST['cardNo'],'currency'=>$_POST['currency'], 'amount'=>$_POST['amount'], 'promotion'=>$_POST['promotion']]);?>
        <div class="p-xl-5 p-lg-5 p-md-5 p-3 text-center">
            <img class="d-inline-block w-50" src="<?=$_POST['qrimg'];?>">
        </div>
        <article class="mb-3 text-danger text-center fs-5">
            <?=lang('Validation.pgatewaysentence3',[100,3000]);?>
            <br>
            <?=lang('Validation.pgatewaysentence4');?>
        </article>
        <div class="row mb-3">
            <label class="col-xl-3 col-lg-3 col-md-3 col-4 col-form-label fs-xl-4 fs-lg-4 fs-md-4 fs-5"><?=lang('Input.uploadreceipt');?>:</label>
            <div class="col-xl-9 col-lg-9 col-md-9 col-8">
                <input class="form-control form-control-lg" type="file" id="receipt" name="receipt" required>
            </div>
        </div>
        <div class="d-grid gap-2 d-flex justify-content-between">
            <a class="btn btn-light btn-lg rounded-0 w-100" href="<?=base_url('choose-payment-method');?>"><?=lang('Nav.backreenter');?></a>
            <button type="submit" class="btn btn-secondary btn-lg rounded-0 w-100"><?=lang('Nav.donedeposit');?></button>
        </div>
        <?=form_close();?>

        <article class="mt-4">
            <p><?=lang('Validation.pgatewaynotice');?></p>

            <span><?=lang('Validation.bankinfo1');?></span>

            <p><?=lang('Validation.pgatewaysentence1');?></p>
            <p><?=lang('Validation.pgatewaysentence2');?></p>
        </article>

    </div>
</section>

</div>

</main>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.qr711Form').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();
            $('.qr711Form [type=submit]').prop('disabled', true);
            
            const imgSource = $('.qr711Form [name=receipt]')[0].files[0];
            const img = $('.qr711Form [name=receipt]')[0].files[0]['name'];
            const ext = img.substr( (img.lastIndexOf('.') +1) );

            let timestamp = Math.floor(Date.now() / 1000);
            const userstamp = '<?=isset($_SESSION['username'])?$_SESSION['username']:'';?>';
            const filename = userstamp + timestamp + '.' + ext;

            var params = {};
            var formObj = $('.qr711Form').closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
                params['slip'] = filename;
            });
            
            if( params['promotion']!='' )
            {
                beforeDeposit(params, imgSource);
                //submitBankTransfer(params, imgSource);
            } else {
                swal.fire({
                    title: '<?=lang('Validation.rusure');?>',
                    text: '<?=lang('Validation.nopromotion');?>',
                    showDenyButton: true,
                    confirmButtonText: '<?=lang('Nav.proceed');?>',
                    denyButtonText: `<?=lang('Nav.thinkagain');?>`,
                }).then( (result) => {
                    if( result.isConfirmed ) {
                        beforeDeposit(params, imgSource);
                        //submitBankTransfer(params, imgSource);
                    } else if ( result.isDenied ) {
                        // swal.close();
                        $('.qr711Form [type=submit]').prop('disabled', false);
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
            swal.fire("", obj.message + " (Code: "+obj.code+")", "success").then(() => {
                getProfile();
                $('form').removeClass('was-validated');
                $('form').trigger('reset');
                $('.qr711Form [type=submit]').prop('disabled', false);

                window.location.replace("<?=base_url('choose-payment-method');?>");
            });
        } else {
            swal.fire("", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
        $('.qr711Form [type=submit]').prop('disabled', false);
    })
    .fail(function() {
        swal.fire("", "Please try again later.", "error").then(() => {
            $('.qr711Form [type=submit]').prop('disabled', false);
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