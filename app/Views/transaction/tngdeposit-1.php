<main>

<nav class="page-header d-block text-decoration-none p-3 fs-4 d-flex justify-content-between align-items-center mb-3">
    <a class="d-inline-block text-decoration-none" href="javascript:history.go(-1)"><i class="bx bx-chevrons-left"></i></a>
    <label class="mx-auto"><?=$secTitle;?></label>
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target=".modal-support"><?=lang('Nav.on9support');?></button>
</nav>

<div class="container">

<section class="card bg-secondary my-3 shadow">
    <div class="card-body">
        <?=form_open('deposit/tng-qr-final', ['class'=>'form-validation qr711Form','novalidate'=>'novalidate'],['bank'=>$bank,'accNo'=>$accNo,'cardNo'=>$cardNo,'currency'=>$currency,'qrimg'=>$qrUrl,'drate'=>$depositRate, 'wrate'=>$withdrawRate]);?>
        <div class="row mb-3">
            <label class="col-xl-3 col-lg-3 col-md-3 col-4 col-form-label fs-xl-4 fs-lg-4 fs-md-4 fs-5"><?=lang('Input.amount');?>:</label>
            <div class="col-xl-9 col-lg-9 col-md-9 col-8">
                <input type="text" class="form-control form-control-lg" name="amount" placeholder="Min: <?=$minDeposit;?> / Max: <?=$maxDeposit;?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-xl-3 col-lg-3 col-md-3 col-4 col-form-label fs-xl-4 fs-lg-4 fs-md-4 fs-5"><?=lang('Label.choosepromo');?>:</label>
            <div class="col-xl-9 col-lg-9 col-md-9 col-8">
                <select class="form-select form-select-lg" name="promotion" id="promo-list"></select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-xl-3 col-lg-3 col-md-3 col-4 col-form-label fs-xl-4 fs-lg-4 fs-md-4 fs-5"><?=lang('Input.receivebank');?>:</label>
            <div class="col-xl-9 col-lg-9 col-md-9 col-8 payment-method">
                <?php if( $comp711QrAvailabel==true ): ?>
                <span class="d-inline-block position-relative <?=$currency=='MYR'?'tngqr':'qr711';?>"><?//=lang('Nav.deposit711qr');?><?=$bankName;?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-secondary btn-lg w-100" <?=$comp711QrAvailabel==false ? 'disabled' : '';?>><?=lang('Nav.getbankinfo');?></button>
        </div>
        <?=form_close();?>

        <article class="mt-4">
            <p><?=lang('Validation.tngtxt1',[60,1000]);?></p>
            <p><?=lang('Validation.tngtxt2');?></p>
        </article>
    </div>
</section>

</div>

</main>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    promoList('promo-list');
});

function promoList(element)
{
    generalLoading();

    var params = {};
    params['category'] = 0;
    params['type'] = 1;

    $.post('/list/user-promotion/all', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 && obj.data!='' ) {
            swal.close();
            const promo = obj.data;

            var nodeLast = document.createElement("option");
            var textnodeLast = document.createTextNode('<?=lang('Label.choosepromo');?>');
            nodeLast.setAttribute("value", '');
            nodeLast.appendChild(textnodeLast);
            document.getElementById(element).appendChild(nodeLast);

            promo.forEach(function(item, index) {
                var node = document.createElement("option");
                var textnode = document.createTextNode(item.title);
                node.setAttribute("value", item.id);
                node.appendChild(textnode);
                document.getElementById(element).appendChild(node);
            });
        } else {
            swal.close();
            var nodeLast = document.createElement("option");
            var textnodeLast = document.createTextNode('<?=lang('Label.choosepromo');?>');
            nodeLast.setAttribute("value", '');
            nodeLast.appendChild(textnodeLast);
            document.getElementById(element).appendChild(nodeLast);
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
            $('.modal-promoBox').modal('hide');
        });
    });
}
</script>