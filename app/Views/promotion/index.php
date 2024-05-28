<div class="inner-top d-h5-none">
    <div class="container">
        <h3><?=strtoupper(lang('Label.promotion'));?></h3>
    </div>
</div>
<div class="container">
    <div class="tabContent promo-list">
    <?=$allPromo;?>
    <?=$promotionReadOnly;?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.h5-tabbar a[data-page=promo]').addClass("cur");
});
</script>