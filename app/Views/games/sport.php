<!--Desktop View-->
<div id="grid-sport-lobby" class="d-h5-none">
</div>

<!--Mobile View-->
<div class="d-lg-none container">
    <div id="grid-sport" class="game-list">
    </div>
</div>	

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.header-nav li[data-page=sport]').addClass("cur");

    $.get('/device/check', function(dataDevice, statusDevice) {
        const objDevice = JSON.parse(dataDevice);

        if( objDevice.mobile==true ){
            callingSport();
        } else {
            callingSportLobby();
        }
    });
});
</script>