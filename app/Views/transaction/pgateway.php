<main>

<nav class="page-header d-block text-decoration-none p-3 fs-4 d-flex justify-content-between align-items-center mb-3">
    <a class="d-inline-block text-decoration-none" href="javascript:history.go(-1)"><i class="bx bx-chevrons-left"></i></a>
    <label class="mx-auto"><?=$secTitle;?></label>
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target=".modal-support"><?=lang('Nav.on9support');?></button>
</nav>

<div class="container">

<section class="card bg-secondary my-3 shadow">
    <div class="card-body">
        <?=form_open('deposit/bank-info', ['class'=>'form-validation pgatewayForm','novalidate'=>'novalidate'],['channel'=>'']);?>
        <div class="row mb-3">
            <label class="col-xl-3 col-lg-3 col-md-3 col-4 col-form-label fs-xl-4 fs-lg-4 fs-md-4 fs-5"><?=lang('Input.amount');?>:</label>
            <div class="col-xl-9 col-lg-9 col-md-9 col-8">
                <input type="text" class="form-control form-control-lg" name="amount" placeholder="<?=lang('Validation.amount');?>" required>
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
                <?php if( $pgid!=[] ): ?>
                <span class="d-inline-block position-relative pg"><?=lang('Input.banktransfer');?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mb-3 <?=$pgid!=base64_encode($_ENV['payessence'])?'visually-hidden':'';?>">
            <label class="col-xl-3 col-lg-3 col-md-3 col-4 col-form-label fs-xl-4 fs-lg-4 fs-md-4 fs-5"><?=lang('Input.paychannel');?>:</label>
            <div class="col-xl-9 col-lg-9 col-md-9 col-8 payment-channel">
                <div class="p-2 rounded">
                    <div class="btn-group" id="depositChannel-list" role="group"></div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-secondary btn-lg w-100" <?=$pgid==[] ? 'disabled' : '';?>><?=lang('Nav.submit');?></button>
        </div>
        <?=form_close();?>

        <article class="mt-4">
            <p><?=lang('Validation.pgatewaynotice');?></p>

            <span><?=lang('Validation.pgatewaynoticetitle');?></span>
            <ul class="list-unstyled">
            <!--<li><?//=lang('Validation.pgatewaynotice1');?></li>-->
            <!--<li><?//=lang('Validation.pgatewaynotice2');?></li>-->
            <li><?=lang('Validation.pgatewaynotice3');?></li>
            <li><?=lang('Validation.pgatewaynotice4');?></li>
            <li><?=lang('Validation.pgatewaynotice5');?></li>
            <!--<li><?//=lang('Validation.pgatewaynotice6');?></li>-->
            </ul>

            <p><?=lang('Validation.pgatewaysentence1');?></p>
            <p><?=lang('Validation.pgatewaysentence2');?></p>
        </article>

    </div>
</section>

</div>

</main>

<section class="modal fade modal-depositFrame" id="modal-depositFrame" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-depositFrame" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-light bg-dark">
                <h1 class="modal-title fs-5"><?=lang('Nav.instanttransfer');?></h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <article class="depositScreen" id="depositScreen"></article>
            </div>
            <div class="modal-footer border-light bg-dark">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=lang('Nav.close');?></button>
            </div>
        </div>
    </div>
</section>

<script>
var pgChecking = '<?=$pgid!=[]?true:false;?>';
document.addEventListener('DOMContentLoaded', (event) => {
    promoList('promo-list');

    if( pgChecking )
    {
        // getPgChannel('<?//=$payGateway['data']!=[]?$payGateway['data']['bankId']:'';?>','<?//=$payGateway['data']!=[]?$payGateway['data']['merchant']:'';?>');
        getPgChannel('<?=$pgid!=[]?$pgid:'';?>','<?=$merchant!=[]?$merchant:'';?>');
    }

    const depositFrameEvent = document.getElementById('modal-depositFrame');
    depositFrameEvent.addEventListener('hidden.bs.modal', function (event) {
        $('.modal').find('form').removeClass('was-validated');
        $('.modal').find('form').trigger('reset');
        $('#depositScreen').html('');
    });

    $('#depositChannel-list').off().on('change', function(e) {
        const channelcode = $('#depositChannel-list input:radio[name=paychannel]:checked').val();
        const mindep = $('#depositChannel-list input:radio[name=paychannel]:checked').data('min');
        const maxdep = $('#depositChannel-list input:radio[name=paychannel]:checked').data('max');

        $('.pgatewayForm [name=channel]').val(channelcode);
        $('.pgatewayForm [name=amount]').attr('min', mindep);
        $('.pgatewayForm [name=amount]').attr('max', maxdep);
        $('.pgatewayForm [name=amount]').attr('placeholder', "Min: "+mindep+" / "+"Max: "+maxdep);
    });

    $('.pgatewayForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();
            $('.pgatewayForm [type=submit]').prop('disabled', true);

            const pgChecking = '<?=$pgid!=[]?true:false;?>';
            const merchant = '<?=$merchant!=[]?$merchant:'';?>';
            const bankid = '<?=$pgid!=[]?$pgid:'';?>';

            let amount = Number($('.pgatewayForm [name=amount]').val());
            // let random = Math.floor(Math.random() * (100 - 10) + 10) / 100;
            // let finalAmount = amount + random;

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
                params['merchant'] = merchant;
                params['bankid'] = bankid;
                // params['amount'] = finalAmount;
            });

            swal.fire({
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                title: '<?=lang('Validation.confirmamount');?>',
                text: '<?=$_ENV['currency'];?>'+amount,
                showDenyButton: true,
                confirmButtonText: '<?=lang('Nav.submit');?>',
                denyButtonText: `<?=lang('Nav.thinkagain');?>`,
            }).then( (result) => {
                if( result.isConfirmed ) {
                    const promoExist = $('.pgatewayForm #promo-list').html();
                    // alert(promoExist.length);
                    if( promoExist.length>0 )
                    {
                        if( params['promotion']=='' )
                        {
                            swal.fire({
                                backdrop: true,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                title: '<?=lang('Validation.rusure');?>',
                                text: '<?=lang('Validation.nopromotion');?>',
                                showDenyButton: true,
                                confirmButtonText: '<?=lang('Nav.submit');?>',
                                denyButtonText: `<?=lang('Nav.thinkagain');?>`,
                            }).then( (result) => {
                                if( result.isConfirmed ) {
                                    beforeDeposit(params);
                                    //submitPGatetway(params);
                                    // submitBankTransfer(params, imgSource);
                                } else if ( result.isDenied ) {
                                    swal.close();
                                    $('.pgatewayForm [type=submit]').prop('disabled', false);
                                }
                            });
                            return false;
                        } else {
                            beforeDeposit(params);
                            //submitPGatetway(params);
                        }
                    } else {
                        beforeDeposit(params);
                        //submitPGatetway(params);
                    }
                } else if ( result.isDenied ) {
                    swal.close();
                    $('.pgatewayForm [type=submit]').prop('disabled', false);
                }
            });
            return false;
        }
    });
});

function submitPGatetway(params)
{
    $.post('/payment/payment-gateway/deposit', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            $('form').removeClass('was-validated');
            $('form').trigger('reset');

            var launchPG = new FormData();
            launchPG.append('lang', '<?=$_SESSION['lang'];?>');
            launchPG.append('type', obj.paymentGatewayParams.type);
            launchPG.append('userid', obj.paymentGatewayParams.userid);
            launchPG.append('apikey', obj.paymentGatewayParams.apikey);
            launchPG.append('payurl', obj.paymentGatewayParams.payurl);
            launchPG.append('successurl', obj.paymentGatewayParams.successurl);
            launchPG.append('failureurl', obj.paymentGatewayParams.failureurl);
            launchPG.append('callbackurl', obj.paymentGatewayParams.callbackurl);
            launchPG.append('amount', obj.paymentGatewayParams.amount);
            launchPG.append('currency', obj.paymentGatewayParams.currency);
            launchPG.append('item_id', obj.paymentGatewayParams.item_id);
            launchPG.append('item_description', obj.paymentGatewayParams.item_description);
            launchPG.append('name', obj.paymentGatewayParams.name);
            launchPG.append('email', obj.paymentGatewayParams.email);
            launchPG.append('telephone', obj.paymentGatewayParams.telephone);
            launchPG.append('accountid', obj.paymentGatewayParams.accountid);
            launchPG.append('bankcode', obj.paymentGatewayParams.bankcode);
            launchPG.append('merchantcode', obj.paymentGatewayParams.merchantcode);
            launchPG.append('channelcode', obj.paymentGatewayParams.channelcode);
            launchPG.append('channelremark', obj.paymentGatewayParams.channelremark);
            launchPG.append('charges', obj.paymentGatewayParams.charges);
            launchPG.append('ip', obj.paymentGatewayParams.ip);
            launchPG.append('remark', obj.paymentGatewayParams.remark);

            var myJSON = JSON.stringify(obj.paymentGatewayParams);
            const ss = btoa(myJSON);

            $.ajax({
                type: 'GET',
                url: obj.paymentGatewayUrl + '?verify=' + ss, 
                success: function (data) {
                    // var win = window.open(data, '_blank');
                    // win.document.write(data);
                    // win.document.close();

                    if( obj.paymentGatewayParams.channelcode!='USDT' && params['bankid']!=btoa('<?=$_ENV['payessence'];?>') )
                    {
                        $('.modal-depositFrame').modal('show');
                        var node = document.createElement('iframe');
                        node.setAttribute('allowfullscreen','allowfullscreen');
                        node.setAttribute('frameborder','0');
                        node.setAttribute('loading','lazy');
                        node.setAttribute('width','100%');
                        node.setAttribute('height','100%');
                        node.src = obj.paymentGatewayUrl + '?verify=' + ss;
                        node.seamless;
                        document.getElementById("depositScreen").appendChild(node);
                    } else {
                        var win = window.open(obj.paymentGatewayUrl + '?verify=' + ss, '_blank');
                        win.document.write(data);
                        win.document.close();
                    }
                },
                error: function(xhr, type, exception){},
                beforeSend: function() {}
            }).done(function() {
                swal.close();
            });
            // e.stopImmediatePropagation();
            return false;


            // swal.fire("Success!", obj.message, "success").then(() => {
            //     $('form').removeClass('was-validated');
            //     $('form').trigger('reset');
            // });
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                $('.pgatewayForm [type=submit]').prop('disabled', false);
            });
        }
    })
    .done(function() {
        $('.pgatewayForm [type=submit]').prop('disabled', false);
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
            $('.pgatewayForm [type=submit]').prop('disabled', false);
        });
    });
}

function getPgChannel(pgid,merchant)
{
    var params = {};
    params['bankid'] = pgid;
    params['merchant'] = merchant;

    $.post('/list/payment-channel/company', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.close();
            const channel = obj.data;
            channel.forEach(function(item, index) {
                var node = document.createElement("input");
                var nodeLabel = document.createElement("label");
                var textNodeLabel = document.createTextNode(item.channelName);

                node.setAttribute("type", 'radio');
                node.setAttribute("name", 'paychannel');
                node.setAttribute("required", 'required');
                node.setAttribute("id", 'channel-'+index);
                node.setAttribute("autocomplete", 'off');
                node.setAttribute("value", item.code);
                node.setAttribute("data-min", item.minDeposit);
                node.setAttribute("data-max", item.maxDeposit);
                node.classList.add('btn-check');

                if( index==0 )
                {
                    node.setAttribute("checked", 'checked');
                }

                nodeLabel.setAttribute("for", 'channel-'+index);
                nodeLabel.classList.add('btn','btn-outline-secondary');

                nodeLabel.appendChild(textNodeLabel);
                document.getElementById('depositChannel-list').appendChild(node);
                document.getElementById('depositChannel-list').appendChild(nodeLabel);
            });

            $('.pgatewayForm [name=channel]').val(obj.data[0].code);
            // $('.pgatewayForm [name=amount]').val(obj.data[0].minDeposit);
            $('.pgatewayForm [name=amount]').attr('min', obj.data[0].minDeposit);
            $('.pgatewayForm [name=amount]').attr('max', obj.data[0].maxDeposit);
            $('.pgatewayForm [name=amount]').attr('placeholder', "Min: "+obj.data[0].minDeposit+" / "+"Max: "+obj.data[0].maxDeposit);
            // $('.pgatewayForm [name=amount]').attr('placeholder', "Min: "+obj.data[0].minDeposit);

            // $('.pgMinDeposit').html(obj.data[0].minDeposit);
            // $('.pgMaxDeposit').html(obj.data[0].maxDeposit);
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

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

function beforeDeposit(params)
{
    $.get('/refresh-credit/all', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            submitPGatetway(params);
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