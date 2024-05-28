<main>

<nav class="page-header d-block text-decoration-none p-3 fs-4 d-flex justify-content-between align-items-center mb-3">
    <a class="d-inline-block text-decoration-none" href="javascript:history.go(-1)"><i class="bx bx-chevrons-left"></i></a>
    <label class="mx-auto"><?=$secTitle;?></label>
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target=".modal-support"><?=lang('Nav.on9support');?></button>
</nav>


<div class="container">

    <ul class="list-unstyled row g-3 align-items-center payment-method">
        <!--
        <li class="col-12">
            <a class="d-block text-decoration-none p-xl-5 p-lg-5 p-md-5 p-3 rounded d-flex justify-content-between align-items-center" href="<?//=base_url('deposit/bank-transfer');?>">
                <span class="d-inline-block position-relative">银行卡转账 / 转数快</span><i class="bx bx-chevron-right"></i>
            </a>
        </li>
        -->
        <!--
        <li class="col-12">
            <a class="d-block text-decoration-none p-xl-5 p-lg-5 p-md-5 p-3 rounded d-flex justify-content-between align-items-center" href="<?//=base_url('deposit/payment-gateway');?>">
                <span class="d-inline-block position-relative">银行卡转账 / 转数快</span><i class="bx bx-chevron-right"></i>
            </a>
        </li>
        -->
        <?=$bankCard;?>
        <?=$payGateway;?>
    </ul>

</div>

<!-- Widgets -->
<nav class="wrap-float-widget guideline" id="guideline">
    <a href="<?=base_url('instruction');?>" class="btn-float-content"><img class="w-100" src="<?=base_url('assets/img/tutorial/tutorial_btn_'.$_SESSION['lang'].'.png');?>"></a>
</nav>
<!-- End Widgets -->

</main>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    
});
</script>