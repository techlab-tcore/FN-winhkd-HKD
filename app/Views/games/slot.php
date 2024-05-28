<!--Desktop View-->
<div class="d-h5-none">
    <div class="inner-top">
        <div class="container">
            <div class="games-nav tabNav">
                <h3><?=strtoupper(lang('Nav.slot'));?> <?=strtoupper(lang('Nav.games'));?></h3>
                <ul>
                    <li target="#slots1x" class="cur"><span><?=strtoupper(lang('Label.slot'));?> 1X</span></li>
                    <li target="#slots2x"><span><?=strtoupper(lang('Label.slot'));?> 2X</span></li>
                    <li target="#slots5x"><span><?=strtoupper(lang('Label.slot'));?> 5X</span></li>
                    <li target="#slots10x"><span><?=strtoupper(lang('Label.slot'));?> 10X</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="slots1x" class="tabContent child-games">
            <div class="grid-1x row row-cols-3">
            </div>
        </div>
        <div id="slots2x" class="tabContent child-games" style="display:none">
            <div class="grid-2x row row-cols-3">
            </div>
        </div>
        <div id="slots5x" class="tabContent child-games" style="display:none">
            <div class="grid-5x row row-cols-3">
            </div>
        </div>
        <div id="slots10x" class="tabContent child-games" style="display:none">
            <div class="grid-10x row row-cols-3">
            </div>
        </div>
    </div>
</div>

<!--Mobile View-->
<div class="d-lg-none">
    <div class="inner-top">
        <div class="container">
            <div class="games-nav tabNav">
                <ul>
                    <li target="#slots1xM" class="cur"><span>1X</span></li>
                    <li target="#slots2xM"><span>2X</span></li>
                    <li target="#slots5xM"><span>5X</span></li>
                    <li target="#slots10xM"><span>10X</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="slots1xM" class="tabContent child-games">
            <div class="grid-1x row row-cols-3">
            </div>
        </div>
        <div id="slots2xM" class="tabContent child-games" style="display:none">
            <div class="grid-2x row row-cols-3">
            </div>
        </div>
        <div id="slots5xM" class="tabContent child-games" style="display:none">
            <div class="grid-5x row row-cols-3">
            </div>
        </div>
        <div id="slots10xM" class="tabContent child-games" style="display:none">
            <div class="grid-10x row row-cols-3">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        $('.header-nav li[data-page=slot]').addClass("cur");

        callingSlotMultiX(1);

        //Desktop
        const tabslot1Event = document.querySelector('li[target="#slots1x"]');
        tabslot1Event.addEventListener('click', function (event) {
            event.target // newly activated tab
            event.relatedTarget // previous active tab
            callingSlotMultiX(1);
        });

        const tabslot2Event = document.querySelector('li[target="#slots2x"]');
        tabslot2Event.addEventListener('click', function (event) {
            event.target // newly activated tab
            event.relatedTarget // previous active tab
            callingSlotMultiX(2);
        });

        const tabslot5Event = document.querySelector('li[target="#slots5x"]');
        tabslot5Event.addEventListener('click', function (event) {
            event.target // newly activated tab
            event.relatedTarget // previous active tab
            callingSlotMultiX(5);
        });

        const tabslot10Event = document.querySelector('li[target="#slots10x"]');
        tabslot10Event.addEventListener('click', function (event) {
            event.target // newly activated tab
            event.relatedTarget // previous active tab
            callingSlotMultiX(10);
        });

        //Mobile
        const tabslot1EventM = document.querySelector('li[target="#slots1xM"]');
        tabslot1EventM.addEventListener('click', function (event) {
            event.target // newly activated tab
            event.relatedTarget // previous active tab
            callingSlotMultiX(1);
        });

        const tabslot2EventM = document.querySelector('li[target="#slots2xM"]');
        tabslot2EventM.addEventListener('click', function (event) {
            event.target // newly activated tab
            event.relatedTarget // previous active tab
            callingSlotMultiX(2);
        });

        const tabslot5EventM = document.querySelector('li[target="#slots5xM"]');
        tabslot5EventM.addEventListener('click', function (event) {
            event.target // newly activated tab
            event.relatedTarget // previous active tab
            callingSlotMultiX(5);
        });

        const tabslot10EventM = document.querySelector('li[target="#slots10xM"]');
        tabslot10EventM.addEventListener('click', function (event) {
            event.target // newly activated tab
            event.relatedTarget // previous active tab
            callingSlotMultiX(10);
        });
    });
</script>