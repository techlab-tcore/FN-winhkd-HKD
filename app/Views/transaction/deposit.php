<div class="user-container container">
    <!-- Sidebar -->
    <?=view('sidebar');?>
    <!-- End Sidebar -->
    <div class="user-content">
        <!-- User Account -->
        <?=view('useraccount');?>
        <!-- End User Account -->
        <div class="user-form">
            <div class="form-flex">
                <label class="form-label"><?=lang('Input.depotion');?><i>*</i></label>
                <ul class="btn-selections btnSelections tabNav">
                    <li id="nav-instant-tab" target="#nav-instant" class="cur"><?=lang('Nav.instanttransfer');?></li>
                    <li id="nav-bank-tab" target="#nav-bank"><?=lang('Nav.banktransfer');?></li>
                </ul>
            </div>
            
            <div id="nav-instant" class="tabContent">
                <?=form_open('',['class'=>'form-validation pgatewayForm','novalidate'=>'novalidate'],['channel'=>'','currency'=>'']);?>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Input.pgateway');?><i>*</i></label>
                        <div class="btn-selections btnSelections" id="depositChannel-list">
                        </div>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Input.depchannel');?><i>*</i></label>
                        <div class="btn-selections btnSelections" id="depositPayGatewayBank-list">
                        </div>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Label.depositamount');?><i>*</i></label>
                        <input type="number" step="any" class="form-control" name="amount" required>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Label.promotion');?></label>
                        <div class="select-wrap">
                            <select class="form-select" name="promotion" id="promo-list">
                            </select>
                        </div>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"></label>
                        <input type="submit" class="btn" value="<?=lang('Nav.submit');?>">
                    </div>
                    <div class="reminder-box">
                        <h6><?=strtoupper(lang('Label.importantnotice'));?></h6>
                        <p class="reminder-list">
                        <p><?=lang('Validation.instransfer1');?></p>
                        <p><?=lang('Validation.instransfer2');?></p>
                    </div>
                <?=form_close();?>
            </div>
            
            <div id="nav-bank" class="tabContent" style="display:none;">
                <?=form_open('',['class'=>'form-validation bankTransferForm','novalidate'=>'novalidate'],['card'=>'','currency'=>'']);?>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Input.bankoption');?><i>*</i></label>
                        <div class="select-wrap">
                            <select class="form-select" name="bank" id="bankOption-list" required>
                            </select>
                        </div>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Input.bankacc');?><i>*</i></label>
                        <div class="input-wrap">
                            <div class="input-group">
                                <input type="text" class="form-control" name="accholder" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text copy-btn btn-copy-holder"><?=lang('Nav.copy');?></div>
                                </div>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" name="accno" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text copy-btn btn-copy-accno"><?=lang('Nav.copy');?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                            <label class="col-xl-4 col-lg-4 col-md-4 col-12 col-form-label color-55vp3"><?=lang('Input.bankqr');?><span class="text-danger">*</span></label>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                <img id="bankQr" class="d-inline-block w-50" src="">
                            </div>
                        </div>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Label.depositamount');?><i>*</i></label>
                        <input type="number" step="any" class="form-control" name="amount" required>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Input.uploadreceipt');?><i>*</i></label>
                        <input type="file" class="form-control" id="receipt" name="receipt" required>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"><?=lang('Label.promotion');?></label>
                        <div class="select-wrap">
                            <select class="form-select" name="promotion" id="bankPromo-list">
                            </select>
                        </div>
                    </div>
                    <div class="form-flex">
                        <label class="form-label"></label>
                        <input type="submit" class="btn" value="<?=lang('Nav.submit');?>">
                    </div>
                    <div class="reminder-box">
                        <h6><?=strtoupper(lang('Label.importantnotice'));?></h6>
                        <p class="reminder-list">
                        <p><?=lang('Validation.banktransfer1');?></p>
                        <p><?=lang('Validation.banktransfer2');?></p>
                        <p><?=lang('Validation.banktransfer3');?></p>
                        <p><?=lang('Validation.banktransfer4');?></p>
                    </div>
                <?=form_close();?>
            </div>
        </div>		
    </div>
</div>

<section class="modal fade modal-depositFrame" id="modal-depositFrame" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-depositFrame">
    <div class="modal-dialog modal-lg modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-light bg-55vp4">
                <h1 class="modal-title fs-5"><?=lang('Nav.instanttransfer');?></h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 bg-white">
                <article class="depositScreen h-100" id="depositScreen"></article>
            </div>
            <div class="modal-footer border-light bg-55vp4">
                <button type="button" class="btn btn-55vp" data-bs-dismiss="modal"><?=lang('Nav.close');?></button>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.user-nav a[data-page=commission]').addClass("cur");
    $('.h5-tabbar a[data-page=funds]').addClass("cur");

    getRadioPGatewayList('depositChannel-list');
    getCompanyCDM('bankOption-list');

    let checkChannel = $('#depositChannel-list input:radio[name=bankid]:checked').val();
    if( typeof checkChannel!='undefined' )
    {
        $('.pgatewayForm [name=amount]').prop('disabled',false);
        $('.pgatewayForm [type=submit]').prop('disabled', false);
    } else {
        $('.pgatewayForm [name=amount]').prop('disabled',true);
        $('.pgatewayForm [type=submit]').prop('disabled', true);
    }

    $('.bankTransferForm .btn-copy-holder').on('click', function() {
        const copytext = $('.bankTransferForm [name=accholder]');
        if( copytext!='' || copytext!=null ) {
            copytext.select();
            document.execCommand('copy');

            $('.bankTransferForm .btn-copy-holder').html('Copied');
            setInterval(function(){ 
                $('.bankTransferForm .btn-copy-holder').html('Copy');
            }, 1500);
        }
    });

    $('.bankTransferForm .btn-copy-accno').on('click', function() {
        const copytext = $('.bankTransferForm [name=accno]');
        if( copytext!='' || copytext!=null ) {
            copytext.select();
            document.execCommand('copy');

            $('.bankTransferForm .btn-copy-accno').html('Copied');
            setInterval(function(){ 
                $('.bankTransferForm .btn-copy-accno').html('Copy');
            }, 1500);
        }
    });

    $('#bankOption-list').on('change', function() {
        const idx = this.options.selectedIndex;
        const currency = this.options[idx].dataset.currency;
        const card = this.options[idx].dataset.cardno;
        const accno = this.options[idx].dataset.accno;
        const holder = this.options[idx].dataset.holder;
        const remark = this.options[idx].dataset.remark;
        const minDep = this.options[idx].dataset.mindep;
        const maxDep = this.options[idx].dataset.maxdep;
        const bankQr = this.options[idx].dataset.qrimg;

        //$('.bankTransferForm [name=currency]').val(currency);
        $('.bankTransferForm [name=accholder]').val(holder);
        $('.bankTransferForm [name=accno]').val(accno);
        $('.bankTransferForm [name=card]').val(card);
        $('.bankTransferForm [name=currency]').val(currency);
        $('.bankTransferForm .bank-remark').html(remark);

        // $('.bankTransferForm [name=amount]').val(minDep);
        $('.bankTransferForm [name=amount]').attr('min', minDep);
        $('.bankTransferForm [name=amount]').attr('max', maxDep);
        $('.bankTransferForm [name=amount]').attr('placeholder', "Min: "+minDep+" / "+"Max: "+maxDep);
        $('.bankMinDeposit').html(minDep);
        $('.bankMaxDeposit').html(maxDep);
        $("#bankQr").attr("src", bankQr);
    });

    $('#depositChannel-list').off().on('change', function(e) {
        generalLoading();
        $('#depositPayGatewayBank-list').html('');

        const pgid = $('#depositChannel-list input:radio[name=bankid]:checked').val();
        const currency = $('#depositChannel-list input:radio[name=bankid]:checked').data('currency');
        const merchant = $('#depositChannel-list input:radio[name=bankid]:checked').data('merchant');

        let checkChannel = $('#depositChannel-list input:radio[name=bankid]:checked').val();
        if( typeof checkChannel!='undefined' )
        {
            $('.pgatewayForm [name=amount]').prop('disabled',false);
            $('.pgatewayForm [type=submit]').prop('disabled', false);
        } else {
            $('.pgatewayForm [name=amount]').prop('disabled',true);
            $('.pgatewayForm [type=submit]').prop('disabled', true);
        }

        getPgChannel('depositPayGatewayBank-list',pgid,merchant,currency);
    });

    const tabInstantEvent = document.querySelector('[target="#nav-instant"]');
    tabInstantEvent.addEventListener('click', function (event) {
        $('#nav-instant').find('form').trigger('reset');
        $('#nav-instant #promo-list').html(' ');
    });
    tabInstantEvent.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        getPromoList('promo-list');
    });

    const tabBankEvent = document.querySelector('[target="#nav-bank"]');
    tabBankEvent.addEventListener('click', function (event) {
        $('#nav-bank').find('form').trigger('reset');
        $('#nav-bank #bankPromo-list').html(' ');
    });
    tabBankEvent.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        getPromoList('bankPromo-list');
    });

    $('.pgatewayForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();
            $('.pgatewayForm [type=submit]').prop('disabled', true);

            const bankid = $('.pgatewayForm [name=bankid]:checked').val();
            const merchant = $('.pgatewayForm [name=bankid]:checked').data('merchant');

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
                params['bankid'] = bankid;
                params['merchant'] = merchant;
            });

            const channelExist = $('#depositChannel-list').html();
            let checkChannel = $('#depositChannel-list input:radio[name=bankid]:checked').val();
            if( channelExist=='' || typeof checkChannel=='undefined' ) 
            {
                $('.pgatewayForm [type=submit]').prop('disabled', true);
                return false;
            }

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
                            submitPGatetway(params);
                            // submitBankTransfer(params, imgSource);
                        } else if ( result.isDenied ) {
                            swal.close();
                            $('.pgatewayForm [type=submit]').prop('disabled', false);
                        }
                    });
                    return false;
                } else {
                    submitPGatetway(params);
                }
            } else {
                submitPGatetway(params);
            }
        }
    });

    $('.bankTransferForm').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();
            $('.bankTransferForm [type=submit]').prop('disabled', true);

            const imgSource = $('.bankTransferForm [name=receipt]')[0].files[0];
            const img = $('.bankTransferForm [name=receipt]')[0].files[0]['name'];
            const ext = img.substr( (img.lastIndexOf('.') +1) );

            let timestamp = Math.floor(Date.now() / 1000);
            const userstamp = '<?=isset($_SESSION['username'])?$_SESSION['username']:'';?>';
            const filename = userstamp + timestamp + '.' + ext;

            var params = {};
            var formObj = $('.bankTransferForm').closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
                params['slip'] = filename;
            });

            const bankOptionExist = $('#bankOption-list').html();
            if( bankOptionExist=='' ) 
            {
                $('.bankTransferForm [type=submit]').prop('disabled', true);
                return false;
            }
            
            const promoExist = $('.bankTransferForm #bankPromo-list').html();
            if( promoExist.length>0 )
            {
                if( params['promotion']=='' )
                {
                    swal.fire({
                        title: '<?=lang('Validation.rusure');?>',
                        text: '<?=lang('Validation.nopromotion');?>',
                        showDenyButton: true,
                        confirmButtonText: '<?=lang('Nav.submit');?>',
                        denyButtonText: `<?=lang('Nav.thinkagain');?>`,
                    }).then( (result) => {
                        if( result.isConfirmed ) {
                            submitBankTransfer(params, imgSource);
                        } else if ( result.isDenied ) {
                            swal.close();
                            $('.bankTransferForm [type=submit]').prop('disabled', false);
                        }
                    });
                } else {
                    submitBankTransfer(params, imgSource);
                }
            } else {
                submitBankTransfer(params, imgSource);
            }
        }
    });

    const depositFrameModel = document.getElementById('modal-depositFrame');
    depositFrameModel.addEventListener('hidden.bs.modal', function (event) {
        $(this).find('form').trigger('reset');
        $(this).find('form').removeClass('was-validated');
        $('.modal-depositFrame .depositScreen').html('');
    });
});

async function getPromoList(element)
{
    var params = {};
    params['category'] = 0;
    params['type'] = 1;

    $.post('/list/user-promotion/all', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            // swal.fire("Success!", obj.message, "success").then(() => {
            //     $('form').removeClass('was-validated');
            //     $('form').trigger('reset');
            // });
            var nodeAll = document.createElement("option");
            var textNodeAll = document.createTextNode('---<?=lang('Label.promotion');?>---');
            nodeAll.setAttribute("value", '');
            nodeAll.appendChild(textNodeAll);
            document.getElementById(element).appendChild(nodeAll);

            const promo = obj.data;
            promo.forEach(function(item, index) {
                var node = document.createElement("option");
                var textNode = document.createTextNode(item.title);
                node.setAttribute("value", item.id);
                node.appendChild(textNode);
                document.getElementById(element).appendChild(node);
            });
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                
            });
        }
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
            
        });
    });
}

function getPgChannel(element,pgid,merchant,currency)
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

            $('.pgatewayForm [name=currency]').val(currency);
            $('.pgatewayForm [name=channel]').val(obj.data[0].code);
            $('.pgatewayForm [name=amount]').val(obj.data[0].minDeposit);
            $('.pgatewayForm [name=amount]').attr('min', obj.data[0].minDeposit);
            $('.pgatewayForm [name=amount]').attr('max', obj.data[0].maxDeposit);
            $('.pgatewayForm [name=amount]').attr('placeholder', "Min: "+obj.data[0].minDeposit+" / "+"Max: "+obj.data[0].maxDeposit);

            $('.pgMinDeposit').html(obj.data[0].minDeposit);
            $('.pgMaxDeposit').html(obj.data[0].maxDeposit);

            // Gateway Channel
            const channel = obj.data;
            if( channel!='' )
            {
                channel.forEach(function(item, index) {
                    var node = document.createElement("input");
                    var nodeLabel = document.createElement("label");
                    var textNodeLabel = document.createTextNode(item.channelName.EN);

                    node.setAttribute("type", 'radio');
                    node.setAttribute("name", 'channel');
                    node.setAttribute("id", 'pgchannel-'+index);
                    node.setAttribute("autocomplete", 'off');
                    node.setAttribute("value", item.code);
                    node.classList.add('btn-check');

                    nodeLabel.setAttribute("for", 'pgchannel-'+index);
                    nodeLabel.classList.add('btn','btn-outline-success');

                    nodeLabel.appendChild(textNodeLabel);
                    document.getElementById(element).appendChild(node);
                    document.getElementById(element).appendChild(nodeLabel);
                });
            } else {
                swal.close();
                $('.pgatewayForm [type=submit]').prop('disabled', true);
            }
            // End Gateway Channel
        } else {
            swal.fire("", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("", "Please try again later.", "error");
    });
}

async function getRadioPGatewayList(element)
{
    generalLoading();

    $.get('/list/payment-gateway/company', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.close();
            const pg = obj.data;

            if( pg!='' )
            {
                pg.forEach(function(item, index) {
                    var node = document.createElement("input");
                    var nodeLabel = document.createElement("label");
                    var textNodeLabel = document.createTextNode(item.name);

                    node.setAttribute("type", 'radio');
                    node.setAttribute("name", 'bankid');
                    node.setAttribute("id", 'channel-'+index);
                    node.setAttribute("autocomplete", 'off');
                    node.setAttribute("value", btoa(item.bank));
                    node.setAttribute("data-currency", item.currency);
                    node.setAttribute("data-merchant", item.merchant);
                    node.classList.add('btn-check');

                    if( index==0 )
                    {
                        // node.setAttribute("checked", 'checked');
                    }

                    nodeLabel.setAttribute("for", 'channel-'+index);
                    nodeLabel.classList.add('btn','btn-outline-success');

                    nodeLabel.appendChild(textNodeLabel);
                    document.getElementById(element).appendChild(node);
                    document.getElementById(element).appendChild(nodeLabel);
                });

            } else {
                swal.close();
                $('.pgatewayForm [type=submit]').prop('disabled', true);
            }
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
        getPromoList('promo-list');
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
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

function submitBankTransfer(params, imgSource)
{
    $.post('/payment/deposit', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            uploadslip(obj.agentid, obj.sessionid, obj.userid, obj.slipname, imgSource);
            swal.fire("Updated!", obj.message , "success").then(() => {
                getProfile();
                $('form').removeClass('was-validated');
                $('form').trigger('reset');
                $('.bankTransferForm [type=submit]').prop('disabled', false);
            });
        } else {
            swal.fire("<?=lang('Label.error');?>!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
        $('.bankTransferForm [type=submit]').prop('disabled', false);
    })
    .fail(function() {
        swal.fire("<?=lang('Label.error');?>!", "Oopss! There are something wrong. Please try again later.", "error").then(() => {
            $('.bankTransferForm [type=submit]').prop('disabled', false);
        });
    });
}

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
            launchPG.append('type', obj.paymentGatewayParams.type);
            launchPG.append('userid', obj.paymentGatewayParams.userid);
            launchPG.append('merchantcode', obj.paymentGatewayParams.merchantcode);
            launchPG.append('apikey', obj.paymentGatewayParams.apikey);
            launchPG.append('payurl', obj.paymentGatewayParams.payurl);
            launchPG.append('successurl', obj.paymentGatewayParams.successurl);
            launchPG.append('failureurl', obj.paymentGatewayParams.failureurl);
            launchPG.append('callbackurl', obj.paymentGatewayParams.callbackurl);
            launchPG.append('amount', obj.paymentGatewayParams.amount);
            launchPG.append('systemamount', obj.paymentGatewayParams.systemamount);
            launchPG.append('currency', obj.paymentGatewayParams.currency);
            launchPG.append('item_id', obj.paymentGatewayParams.item_id);
            launchPG.append('item_description', obj.paymentGatewayParams.item_description);
            launchPG.append('name', obj.paymentGatewayParams.name);
            launchPG.append('email', obj.paymentGatewayParams.email);
            launchPG.append('telephone', obj.paymentGatewayParams.telephone);
            launchPG.append('accountid', obj.paymentGatewayParams.accountid);
            launchPG.append('bankcode', obj.paymentGatewayParams.bankcode);
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

                    if( obj.paymentGatewayParams.channelcode!='USDT' )
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

                        //byPassBlockPopUp(obj.paymentGatewayUrl + '?verify=' + ss);
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
</script>