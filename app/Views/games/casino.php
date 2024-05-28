<!--Desktop View-->
<div id="grid-casino-lobby" class="d-h5-none">
</div>

<!--Mobile View-->
<div class="d-lg-none container">
    <div id="grid-casino" class="game-list">
    </div>
</div>	

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.header-nav li[data-page=casino]').addClass("cur");

    $.get('/device/check', function(dataDevice, statusDevice) {
        const objDevice = JSON.parse(dataDevice);

        if( objDevice.mobile==true ){
            callingCasino();
        } else {
            callingCasinoLobby();
        }
    });
});
</script>