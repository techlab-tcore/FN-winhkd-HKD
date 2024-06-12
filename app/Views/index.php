<div class="banner-area">
    <!-- Slider -->
    <?=view('banner');?>
    <!-- End Slider -->

    <!-- Announcement -->
    <?=view('announcement');?>
    <!-- End Announcement -->
</div>

<!--Desktop View-->
<div class="d-h5-none">
    <div class="home-steps container">
        <div>
            <img src="../assets/img/home/steps_account.png" alt="Account" loading="lazy">
            <p>1.<br/><?=strtoupper(lang('Sentence.createacc'));?></p>
        </div>
        <div>
            <img src="../assets/img/home/steps_coin.png" alt="Deposit" loading="lazy">
            <p>2.<br/><?=strtoupper(lang('Sentence.makeadeposit'));?></p>
        </div>
        <div>
            <img src="../assets/img/home/steps_winning.png" alt="Winning" loading="lazy">
            <p>3.<br/><?=strtoupper(lang('Sentence.startwinning'));?></p>
        </div>
    </div>
    <div class="home-games">
        <div class="container">
            <div class="games-nav tabNav">
                <h1><?=strtoupper(lang('Nav.games'));?></h1>
                <ul>
                    <li target="#providersSportsD" onclick="callingSport();" class="cur"><i class="icon-ball"></i><span><?=strtoupper(lang('Nav.sport'));?></span></li>
                    <li target="#providersCasinoD" onclick="callingCasino();"><i class="icon-poker"></i><span><?=strtoupper(lang('Nav.casino'));?></span></li>
                    <li target="#providersSlotsD" onclick="callingSlot();"><i class="icon-slot"></i><span><?=strtoupper(lang('Nav.slot'));?></span></li>
                    <!-- <li target="#providersLotteryD" onclick="callingLotto();"><i class="icon-lottery"></i><span><?=strtoupper(lang('Nav.lottery'));?></span></li> -->
                </ul>
            </div>
            <div id="providersSportsD" class="tabContent home-games-content">
                <div>
                    <img class="gameImg" src="../assets/img/home/game_sports.png" alt="<?=lang('Nav.sport');?>" onerror="this.onerror=null;this.src='../assets/img/home/game_sports.png';">
                </div>
                <div class="home-games-slick">
                    <div id="grid-sport-d" class="gameSlick">
                    </div>
                </div>
            </div>
            
            <div id="providersCasinoD" class="tabContent home-games-content" style="display:none;">
                <div>
                    <img class="gameImg" src="../assets/img/home/game_livecasino.png" alt="<?=lang('Nav.casino');?>" onerror="this.onerror=null;this.src='../assets/img/home/game_livecasino.png';">
                </div>
                <div class="home-games-slick">
                    <div id="grid-casino-d" class="gameSlick">
                    </div>
                </div>
            </div>
            
            <div id="providersSlotsD" class="tabContent home-games-content" style="display:none;">
                <div>
                    <img class="gameImg" src="../assets/img/home/game_slots.png" alt="<?=lang('Nav.slot');?>" onerror="this.onerror=null;this.src='../assets/img/home/game_slots.png';">
                </div>
                <div class="home-games-slick">
                    <div id="grid-slot-d" class="gameSlick">
                    </div>
                </div>
            </div>
            
            <!-- <div id="providersLotteryD" class="tabContent home-games-content" style="display:none;">
                <div>
                    <img class="gameImg" src="../assets/img/home/game_lottery.png" alt="<?=lang('Nav.lottery');?>" onerror="this.onerror=null;this.src='../assets/img/home/game_lottery.png';">
                </div>
                <div class="home-games-slick">
                    <div id="grid-lottery-d" class="gameSlick">
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>

<!--Mobile View-->
<div class="d-lg-none">
    <?php if( isset($_SESSION['logged_in']) ): ?>
        <div class="account-highlight container">
            <div>
                <p><?=strtoupper(lang('Label.balance'));?> (<?=$_ENV['currencyCode'];?>)</p>
                <p class="text-primary"><span class="userBalance"></span><a onclick="refreshAndWithdrawGame();"><i class="icon-refresh"></i></a></p>
            </div>
            <div><a href="<?=base_url('deposit');?>"><i class="icon-deposit"></i><?=strtoupper(lang('Nav.deposit'));?></a></div>
            <div><a href="<?=base_url('withdrawal');?>"><i class="icon-withdraw"></i><?=strtoupper(lang('Nav.withdrawal'));?></a></div>
            <div><a href="<?=base_url('transaction/history');?>"><i class="icon-history"></i><?=strtoupper(lang('Nav.history'));?></a></div>
        </div>
    <?php endif; ?>
    <div class="home-providers">
        <div id="providerSlick" class="providers-nav tabNav">
            <!--
            <div>
                <div class="providers-tab cur" target="#providersSlots">
                    <i class="icon-slot"></i>
                    <span><?//=strtoupper(lang('Nav.slot'));?></span>
                </div>
            </div>
            -->
            <div>
                <div class="providers-tab cur" target="#providersMultiple">
                    <i class="icon-slot"></i>
                    <span><?=strtoupper(lang('Nav.slot'));?></span>
                </div>
            </div>
            <div>
                <div class="providers-tab" target="#providersCasino">
                    <i class="icon-poker"></i>
                    <span><?=strtoupper(lang('Nav.casino'));?></span>
                </div>
            </div>
            <div>
                <div class="providers-tab" target="#providersSports">
                    <i class="icon-ball"></i>
                    <span><?=strtoupper(lang('Nav.sport'));?></span>
                </div>
            </div>
            <div>
                <div class="providers-tab" target="#providersFishing">
                    <i class="icon-fish-solid"></i>
                    <span><?=strtoupper(lang('Nav.fishing'));?></span>
                </div>
            </div>
            <!-- <div>
                <div class="providers-tab" target="#providersLottery">
                    <i class="icon-lottery"></i>
                    <span><?//=strtoupper(lang('Nav.lottery'));?></span>
                </div>
            </div> -->
        </div>
        <!--
        <div id="providersSlots" class="tabContent container">
            <div id="grid-slot" class="row row-cols-3">
            </div>
        </div>
        -->
        <div id="providersMultiple" class="tabContent container">
            <div class="providers-subnav tabNav">
                <div class="container sub-nav">
                    <div target="#grid-1x" class="cur"><?=strtoupper(lang('Nav.arena1x'));?></div>
                    <div target="#grid-2x"><?=strtoupper(lang('Nav.arena2x'));?></div>
                    <div target="#grid-5x"><?=strtoupper(lang('Nav.arena5x'));?></div>
                    <div target="#grid-10x"><?=strtoupper(lang('Nav.arena10x'));?></div>
                </div>
            </div>
            <div id="grid-1x" class="grid-1x row row-cols-3 row-cols-sm-4 row-cols-md-5 tabContent">
            </div>
            <div id="grid-2x" class="grid-2x row row-cols-3 row-cols-sm-4 row-cols-md-5 tabContent" style="display:none">
            </div>
            <div id="grid-5x" class="grid-5x row row-cols-3 row-cols-sm-4 row-cols-md-5 tabContent" style="display:none">
            </div>
            <div id="grid-10x" class="grid-10x row row-cols-3 row-cols-sm-4 row-cols-md-5 tabContent" style="display:none">
            </div>
        </div>
        <div id="providersCasino" class="tabContent container" style="display:none">
            <div id="grid-casino" class="game-list">
            </div>
        </div>
        <div id="providersSports" class="tabContent container" style="display:none">
            <div id="grid-sport" class="game-list">
            </div>
        </div>
        <div id="providersFishing" class="tabContent container" style="display:none">
            <ul id="grid-fishing" class="list-unstyled row p-0 gx-1 game-list justify-content-center">
            </ul>
        </div>
        <!-- <div id="providersLottery" class="tabContent container" style="display:none">
            <div id="grid-lottery" class="game-list">
            </div>
        </div> -->
    </div>		
</div>

<div class="home-app">
    <div class="container">
        <div class="d-h5-none">
            <img src="../assets/img/home/download_app.png" alt="Download App" loading="lazy">
        </div>
        <div class="app-content">
            <h1 class="text-nowrap justify-content-center"><?=lang('Nav.downloadapp');?></h1>
            <div class="text-center mx-auto p-2 bg-light rounded-3 col-6 col-lg-6 col-md-6">
                <!--<div class="qrcode">
                    <img src="../assets/img/qrcode.png" alt="QR Code">
                </div>-->
                <figure id="appQR" class="p-0 m-0"></figure>
                <!--<a href="">
                    <img src="../assets/img/home/btn_googleplay.png" alt="Google Play">
                </a>-->
            </div>
        </div>
    </div>
</div>

<section class="modal fade modal-announcement" id="modal-announcement" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-announcement" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-light">
                <h5 class="modal-title"><i class="bx bxs-megaphone me-1"></i><?=lang('Label.announcement');?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="announcemenet">
            </div>
			<div class="text-center py-3">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=lang('Nav.close');?></button>
			</div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.h5-tabbar a[data-page=games]').addClass("cur");
	$('.header-nav li[data-page=home]').addClass("cur");

    $(document).on('click','.gameSlick img',function(){
		var imgname = $(this).attr('src').split('/').pop();
		var category = $(this).attr('cat');
		var parent = $(this).closest('.home-games-content');
		parent.find('.games-card').removeClass('cur');
		$(this).parent().addClass('cur');
		parent.find('.gameImg').attr('src','<?=$_ENV['gameProviderCard'];?>' + '/desktop/' + category + '/' + imgname);
	})

    $.get('/device/check', function(dataDevice, statusDevice) {
        const objDevice = JSON.parse(dataDevice);

        if( objDevice.mobile==true ){
            callingSlotMultiX(1);
            //callingSlot();
        } else {
            callingSport();
        }
    });

    //Download app QR
    downloadAppQR();
    
	if( logged ) {
        announcementPopList();
    }

    // Category
    // const tablotteryEvent = document.querySelector('div[target="#providersLottery"]');
    // tablotteryEvent.addEventListener('click', function (event) {
    //     event.target // newly activated tab
    //     event.relatedTarget // previous active tab
    //     callingLotto();
    // });

    const tabcasinoEvent = document.querySelector('div[target="#providersCasino"]');
    tabcasinoEvent.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        callingCasino();
    });

    const tabsportEvent = document.querySelector('div[target="#providersSports"]');
    tabsportEvent.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        callingSport();
    });

    //const tabslotEvent = document.querySelector('div[target="#providersSlots"]');
    //tabslotEvent.addEventListener('click', function (event) {
    //    event.target // newly activated tab
    //    event.relatedTarget // previous active tab
    //    callingSlot();
    //});

    const tabmultipleEvent = document.querySelector('div[target="#providersMultiple"]');
    tabmultipleEvent.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        callingSlotMultiX(1);
    });

    const tabslot1Event = document.querySelector('div[target="#grid-1x"]');
    tabslot1Event.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        callingSlotMultiX(1);
    });

    const tabslot2Event = document.querySelector('div[target="#grid-2x"]');
    tabslot2Event.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        callingSlotMultiX(2);
    });

    const tabslot5Event = document.querySelector('div[target="#grid-5x"]');
    tabslot5Event.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        callingSlotMultiX(5);
    });

    const tabslot10Event = document.querySelector('div[target="#grid-10x"]');
    tabslot10Event.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        callingSlotMultiX(10);
    });

    const tabfishingEvent = document.querySelector('div[target="#providersFishing"]');
    tabfishingEvent.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        callingFishing();
    });

});

async function announcementPopList()
{
    $.get('/list/announcement/pop/all', function(res, status) {
        const obj = JSON.parse(res);
        if( obj.code==1 ) {
            if( obj.data!='' ) {
                $('.modal-announcement').modal('toggle');
                const msg = obj.data;
                msg.forEach( (item, index) => {
                    var node = document.createElement("article");
                    var textnode = item.content;
                    node.classList.add('mb-3','p-2','border','border-light','rounded');
                    node.innerHTML = textnode;
                    var ele = document.getElementById("announcemenet").appendChild(node);
                });
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

//Download app QR
function downloadAppQR()
{
    const appURL = '<?=$_ENV['androidAppURL'];?>';
    var qcode = new QRCode(document.getElementById("appQR"), {
        text: appURL,
        correctLevel : QRCode.CorrectLevel.H
    });
}
</script>