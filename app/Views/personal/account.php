<main>

<a class="page-header d-block text-decoration-none p-3 fs-4 d-flex justify-content-between align-items-center mb-3" href="<?=base_url();?>">
    <i class="bx bx-chevrons-left"></i>
    <span class="mx-auto"><?=$secTitle;?></span>
</a>

<div class="container">

    <section class="general-info p-xl-4 p-lg-4 p-md-4 p-3 rounded">
        <article class="d-flex justify-content-between align-items-center py-xl-3 py-lg-3 py-md-3 py-0">
            <h4 class="m-0"><i class="bx bxs-user-circle me-1"></i><?=$_SESSION['username'];?></h4>
            <!-- <a class="d-inline-block text-decoration-none" href="<?=base_url('user/bank-account');?>"><i class="bx bxs-credit-card"></i></a> -->
            <a class="d-inline-block text-decoration-none" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target=".modal-affiliateQR"><i class="bx bx-qr"></i></a>
        </article>

        <nav class="nav justify-content-start">
            <a class="d-inline-block text-decoration-none text-light" href="<?=base_url('user-password');?>"><i class="bx bxs-lock me-1"></i><?=lang('Nav.password');?></a>
        </nav>
    </section>

    
    <section class="my-xl-5 my-lg-5 my-md-5 my-3">
        <h6 class="fw-light"><?=lang('Label.turnoverwithdrawal');?></h6>
        <div class="justify-content-between align-items-center">
            <section class="progress turnover-progress">
                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </section>
            <h5 class="text-danger"><span class="current-turnover">0</span>/<span class="total-turnover">0</span></h5>
        </div>
    </section>
    

    <section class="user-wallet my-xl-5 my-lg-5 my-md-5 my-3">
        <h2 class="fw-bold pb-2"><?=lang('Label.balance');?></h2>
        <div class="d-flex justify-content-between align-items-center">
            <label class="position-relative"><span class="userBalance d-block">0.00</span></label>
            <button type="button" class="btn btn-secondary rorunded-pill" onclick="refreshAndWithdrawGame();"><?=lang('Nav.restore');?></button>
        </div>
    </section>

    <section class="d-grid gap-2 d-flex justify-content-between nav-account">
        <a class="btn btn-secondary btn-lg w-100" href="<?=base_url('deposit');?>"><?=lang('Nav.deposit');?></a>
        <a class="btn btn-outline-secondary btn-lg w-100" href="<?=base_url('withdrawal');?>"><?=lang('Nav.withdrawal');?></a>
        <a class="btn btn-outline-secondary btn-lg w-100" href="<?=base_url('user/bank-account');?>"><?=lang('Nav.bankacc');?></a>
    </section>

    <a class="btn btn-secondary btn-lg w-100 mt-3" href="<?=base_url('user-commission');?>"><?=lang('Nav.affdownline');?></a>

    <section class="promotion my-5">
        <h2 class="fw-bold pb-2 d-flex justify-content-between align-items-center"><?=lang('Nav.promo');?> <a class="d-inline-block text-decoration-none fs-5 fw-light" href="<?=base_url('promotions');?>"><?=lang('Nav.moreinfo');?><i class="bx bx-chevron-right ms-1"></i></a></h2>
        <a class="d-block text-decoration-none p-4 position-relative d-flex justify-content-between align-items-center rounded shadow nav-promo" href="javascript:void(0);" id="firstPromo">
            <!-- <article>
                <h4 class="fw-light">每日首充额外送20%</h4>
                <span class="opacity-25">2022-11-28 03:28:00</span>
            </article>
            <i class="bx bxs-gift fs-1"></i> -->
        </a>
    </section>

    <section class="report my-5">
        <h2 class="fw-bold pb-2 d-flex justify-content-between align-items-center"><?=lang('Label.reports');?> <a class="d-inline-block text-decoration-none fs-5 fw-light" href="<?=base_url('transaction/history');?>"><?=lang('Nav.viewdetail');?><i class="bx bx-chevron-right ms-1"></i></a></h2>

        <a class="d-block text-decoration-none p-4 position-relative d-flex justify-content-between align-items-center rounded shadow nav-record mb-3" id="latestDeposit" href="javascript:void(0);">
            <!-- <label class="text-center record-type">
                <i class="bx bx-history fs-1"></i>
                <span class="d-block w-100 fw-bold">存款</span>
            </label>
            <article class="d-block w-100 text-center">
                <h4 class="fw-light">充值金额: <b><?=$_ENV['currency'];?> 1000</b></h4>
                <span class="opacity-25">2022-11-28 03:28:00</span>
                <label class="report-status bg-success bg-gradient">成功</label>
            </article> -->
        </a>

        <a class="d-block text-decoration-none p-4 position-relative d-flex justify-content-between align-items-center rounded shadow nav-record" id="latestWithdrawal" href="javascript:void(0);">
            <!-- <label class="text-center record-type">
                <i class="bx bx-history fs-1"></i>
                <span class="d-block w-100 fw-bold">提现</span>
            </label>
            <article class="d-block w-100 text-center">
                <h4 class="fw-light m-0 opacity-25">暫無記錄</h4>
            </article> -->
        </a>
    </section>

    <a class="btn btn-secondary btn-lg w-100 py-3 rounded-3" href="<?=base_url('message');?>"><i class='bx bxs-envelope me-2'></i><?=lang('Nav.message');?></a>

    <a class="btn btn-logout text-uppercase w-100 mt-3 mb-2 opacity-50" href="<?=base_url('user/logout');?>"><?=lang('Nav.logout');?></a>

</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    //$('footer nav > a[data-page=account]').addClass('active');
    $('.mobile-footer [data-page=account] a').addClass("active");

    todayLatestTransaction(1, 'latestDeposit');
    todayLatestTransaction(2, 'latestWithdrawal');

    firstPromotion('firstPromo');
});

function firstPromotion(element)
{
	// generalLoading();

	$.get('/first-promotion', function(data, status) {
		const obj = JSON.parse(data);
		if( obj.code==1 ) {
			// swal.close();
			// getProfile();

            if( obj.code==1 && obj.data!='' )
            {
                const promo = obj.data;
                var node = document.createElement("article");
                var nodeH4 = document.createElement("h4");
                var nodeSpan = document.createElement("span");
                var nodeIcon = document.createElement("i");

                var textNodeH4 = document.createTextNode(promo.title);
                var textNodeSpan = document.createTextNode(promo.endDate);

                nodeH4.classList.add('fw-light');
                nodeSpan.classList.add('opacity-25');
                nodeIcon.classList.add('bx','bxs-gift','fs-1');

                nodeH4.appendChild(textNodeH4);
                nodeSpan.appendChild(textNodeSpan);
                node.appendChild(nodeH4);
                node.appendChild(nodeSpan);
                
                document.getElementById(element).appendChild(node);
                document.getElementById(element).appendChild(nodeIcon);
            } else if( obj.code==1 && obj.data=='' ) {
                const promo = obj.data;
                var node = document.createElement("article");
                var nodeH4 = document.createElement("h4");
                var nodeIcon = document.createElement("i");

                var textNodeH4 = document.createTextNode('<?=lang('Label.norecord');?>');

                nodeH4.classList.add('fw-light','opacity-25');
                nodeIcon.classList.add('bx','bxs-gift','fs-1');

                nodeH4.appendChild(textNodeH4);
                node.appendChild(nodeH4);
                
                document.getElementById(element).appendChild(node);
                document.getElementById(element).appendChild(nodeIcon);
            }


		} else if( obj.code==39 ) {
            forceUserLogout();
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

function todayLatestTransaction(type, element)
{
	// generalLoading();

    params = {};
    params['type'] = type;

	$.post('/latest-transaction', {
        params
    }, function(data, status) {
		const obj = JSON.parse(data);
		if( obj.code==1 ) {
			// swal.close();
			// getProfile();

            if( obj.code==1 && obj.data!='' )
            {
                const trx = obj.data;
                // trx.forEach(function(item, index) {
                    var node = document.createElement("label");
                    var nodeIcon = document.createElement("i");
                    var nodeSpan = document.createElement("span");
                    var nodeArticle = document.createElement("article");
                    var nodeH4 = document.createElement("h4");
                    var nodeBold = document.createElement("b");
                    var nodeTime = document.createElement("span");
                    var nodeStatus = document.createElement("label");

                    if( type==1 ) {
                        var textNodeSpan = document.createTextNode('<?=lang('Label.deposit');?>');
                        var textNodeH4 = document.createTextNode('<?=lang('Label.deposit');?>: <?=$_ENV['currency'];?>'+trx.amount);
                    } else if( type==2 ) {
                        var textNodeSpan = document.createTextNode('<?=lang('Label.depositamount');?>');
                        var textNodeH4 = document.createTextNode('<?=lang('Label.withdrawalamount');?>: <?=$_ENV['currency'];?>'+trx.amount);
                    }

                    var textNodeStatus = document.createTextNode('<?=lang('Label.success');?>');
                    var textNodeTime = document.createTextNode(trx.depositDate);

                    node.classList.add('text-center','record-type');
                    nodeIcon.classList.add('bx','bx-history','fs-1');
                    nodeSpan.classList.add('d-block','w-100','fw-bold');
                    nodeSpan.appendChild(textNodeSpan);

                    nodeArticle.classList.add('d-block','w-100','text-center');
                    nodeH4.classList.add('fw-light');
                    nodeTime.classList.add('opacity-25');
                    nodeStatus.classList.add('report-status','bg-success','bg-gradient');

                    // node.setAttribute("value", item.bank);
                    nodeBold.appendChild(textNodeH4);
                    nodeTime.appendChild(textNodeTime);
                    nodeStatus.appendChild(textNodeStatus);
                    nodeH4.appendChild(nodeBold);
                    nodeH4.appendChild(nodeTime);
                    nodeH4.appendChild(nodeStatus);

                    node.appendChild(nodeIcon);
                    node.appendChild(nodeSpan);
                    nodeArticle.appendChild(nodeH4);
                    nodeArticle.appendChild(nodeTime);
                    nodeArticle.appendChild(nodeStatus);
                    document.getElementById(element).appendChild(node);
                    document.getElementById(element).appendChild(nodeArticle);
                // });
            } else if( obj.code==1 && obj.data=='' ) {
                var node = document.createElement("label");
                var nodeIcon = document.createElement("i");
                var nodeSpan = document.createElement("span");
                var nodeArticle = document.createElement("article");
                var nodeH4 = document.createElement("h4");

                if( type==1 ) {
                    var textNodeSpan = document.createTextNode('<?=lang('Label.deposit');?>');
                } else if( type==2 ) {
                    var textNodeSpan = document.createTextNode('<?=lang('Label.withdrawal');?>');
                }
                var textNodeNoRecord = document.createTextNode('<?=lang('Label.norecord');?>');

                node.classList.add('text-center','record-type');
                nodeIcon.classList.add('bx','bx-history','fs-1');
                nodeSpan.classList.add('d-block','w-100','fw-bold');
                nodeSpan.appendChild(textNodeSpan);

                node.appendChild(nodeIcon);
                node.appendChild(nodeSpan);

                nodeArticle.classList.add('d-block','w-100','text-center');
                nodeH4.classList.add('fw-light','m-0','opacity-25');
                nodeH4.appendChild(textNodeNoRecord);
                nodeArticle.appendChild(nodeH4);

                document.getElementById(element).appendChild(node);
                document.getElementById(element).appendChild(nodeArticle);
            }


		} else if( obj.code==39 ) {
            forceUserLogout();
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
</script>