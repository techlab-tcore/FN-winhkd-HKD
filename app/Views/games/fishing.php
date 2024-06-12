<!--Desktop View-->
<div id="grid-fishing-lobby" class="">
    <div class="inner-top">
        <div class="container-fluid">
            <h3><?=strtoupper(lang('Nav.fishing'));?></h3>
            <ul id="grid-fishing" class="list-unstyled row mx-auto p-0 g-4 justify-content-center">
            </ul>
        </div>
    </div>
</div>

<!--Mobile View-->
<!--<div class="container">
    <div id="grid-fishing" class="game-list">
    </div>
</div>-->

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.header-nav li[data-page=fishing]').addClass("cur");

    callingFishing();
});
</script>