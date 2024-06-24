</div>

<section class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
    <div id="liveToast" class="toast hide bg-secondary" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-primary text-white">
            <span class="me-auto"><?=lang('Label.notif');?></span>
            <button type="button" class="btn-close bg-danger" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</section>

<section class="modal fade modal-support" id="modal-support" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-support" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-uppercase fs-5"><?=lang('Input.choosesupport');?></h1>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled row text-uppercase justify-content-center gy-4 gx-3">
                    <li class="col-6 text-center">
                        <a target="_blank" class="d-block text-decoration-none text-light whatsapp"><img class="d-block img-fluid mx-auto" src="<?=base_url('../assets/img/support/whatsapp.png');?>"><?=lang('Nav.support');?></a>
                    </li>
                    <li class="col-6 text-center">
                        <a target="_blank" class="d-block text-decoration-none text-light telegram"><img class="d-block img-fluid mx-auto" src="<?=base_url('../assets/img/support/telegram.png');?>">Telegram</a>
                    </li>
                    <li class="col-6 text-center">
                        <a onclick="LC_API.open_chat_window();return false;" class="d-block text-decoration-none text-light"><img class="d-block img-fluid mx-auto" src="<?=base_url('../assets/img/support/livechat.png');?>">Livechat</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Games -->
<section class="modal fade modal-gameLanding" id="modal-gameLanding" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-gameLanding" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-0 border-0 bg-dark">
            <div class="modal-header">
                <button type="button" class="btn btn-primary" onclick="getProfile();"><?=$_ENV['currency'];?><span class="ms-1 userBalance"></span></button>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-dark">
                <figure class="text-center text-light">
                    <img class="w-50" src="">
                    <input type="text" class="w-100 border-0 bg-transparent text-center text-light" name="gamebalance" readonly>
                    <label><?=lang('Input.gamebalance');?></label>
                </figure>
                <?=form_open('',['class'=>'form-validation customForm','novalidate'=>'novalidate'],['provider'=>'','gname'=>'','species'=>'']);?>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg"><?=lang('Nav.playgame');?></button>
                </div>
                <?=form_close();?>
            </div>
        </div>
    </div>
</section>

<section class="modal fade modal-gameLobby" id="modal-gameLobby" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-gameLobby" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-xl-down">
        <div class="modal-content p-0 bg-dark">
            <div class="modal-header">
                <h5 class="modal-title gamename"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <article class="lobby" id="gameLobby"></article>
            </div>
        </div>
    </div>
</section>

<section class="modal fade modal-slotLobby" id="modal-slotLobby" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-slotLobby" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-xl-down">
        <div class="modal-content p-0 bg-dark">
            <div class="modal-body p-0 position-relative">
                <a class="dgb-lobby"><img class="d-inline-block" src="<?=base_url('../assets/img/btn_home.png');?>"></a>
                <article class="lobby" id="slotLobby"></article>
            </div>
        </div>
    </div>
</section>

<section class="modal fade modal-prompt" id="modal-prompt" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-prompt" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-dark">
            <div class="modal-header">
                <h5 class="modal-title"><?=lang('Label.notif');?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <article class="p-4">
                    <ul class="row list-unstyled m-0">
                        <li class="col-6">
                            <a class="btn btn-primary w-100 text-uppercase btn-lobby" href="javascript:void(0);"><?=lang('Nav.lobby');?></a>
                        </li>
                        <li class="col-6">
                            <a class="btn btn-danger bg-gradient w-100 text-uppercase btn-exit" href="javascript:void(0);"><?=lang('Nav.exitgame');?></a>
                        </li>
                    </ul>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="modal fade modal-appLanding" id="modal-appLanding" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-appLanding" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header border-dark">
                <button type="button" class="btn btn-secondary" onclick="getProfile();"><?=$_ENV['currency'];?><span class="ms-1 userBalance"></span></button>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <figure class="text-center text-light">
                    <img class="w-50" src="">
                    <input type="text" class="w-100 border-0 bg-transparent text-center text-light" name="gamebalance" readonly>
                    <label><?=lang('Input.gamebalance');?></label>
                </figure>
                <?=form_open('',['class'=>'form-validation','novalidate'=>'novalidate'],['provider'=>'','gname'=>'','species'=>'','platform'=>'']);?>
                <div class="mb-3">
                    <div class="input-group">
                        <div class="btn btn-secondary"><i class="icon-account"></i></div>
                        <input type="text" class="form-control" name="gameuserid" id="gameuserid" readonly>
                        <button type="button" class="btn btn-secondary" id="btn-copygid"><i class="icon-copy"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <div class="btn btn-secondary"><i class="icon-lock1"></i></div>
                        <input type="text" class="form-control" name="gameuserpass" id="gameuserpass" readonly>
                        <button type="button" class="btn btn-secondary" id="btn-copygpass"><i class="icon-copy"></i></button>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-secondary btn-lg"><?=lang('Nav.playgame');?></button>
                    <a target="_blank" class="text-decoration-none btn btn-light btn-download" href=""><?=lang('Nav.dwgameapp');?></a>
                </div>
                <?=form_close();?>
            </div>
        </div>
    </div>
</section>

<section class="modal fade modal-appUrlLanding" id="modal-appUrlLanding" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-appUrlLanding" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-0 border-0">
            <div class="modal-header">
                <button type="button" class="modal-title modalBalance userBalance" onclick="getProfile();"></button>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-dark">
                <figure class="text-center text-light">
                    <img class="w-50" src="">
                    <input type="text" class="w-100 border-0 bg-transparent text-center text-light" name="gamebalance" readonly>
                    <label><?=lang('Input.gamebalance');?></label>
                </figure>
                <?=form_open('',['class'=>'form-validation customForm','novalidate'=>'novalidate'],['provider'=>'','gname'=>'','species'=>'','platform'=>'']);?>
                <div class="d-grid gap-2 d-md-block">
                    <button type="submit" class="btn btn-primary btn-lg"><?=lang('Nav.playgame');?></button>
                </div>
                <?=form_close();?>
            </div>
        </div>
    </div>
</section>

<section class="modal fade modal-lottoLanding" id="modal-lottoLanding" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-lottoLanding" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-0 border-0">
            <div class="modal-header">
                <button type="button" class="btn btn-primary" onclick="getProfile();"><?=$_ENV['currency'];?><span class="ms-1 userBalance"></span></button>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-dark">
                <figure class="text-center text-light">
                    <img class="w-50" src="">
                    <input type="text" class="w-100 border-0 bg-transparent text-center text-light" name="gamebalance" readonly>
                    <label><?=lang('Input.gamebalance');?></label>
                </figure>
                <?=form_open('',['class'=>'form-validation customForm','novalidate'=>'novalidate'],['provider'=>'','gname'=>'','species'=>'']);?>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg"><?=lang('Nav.playgame');?></button>
                </div>
                <?=form_close();?>
            </div>
        </div>
    </div>
</section>

<section class="modal fade modal-lottoBonusLanding" id="modal-lottoBonusLanding" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-lottoBonusLanding" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-0 border-0">
            <div class="modal-header">
                <button type="button" class="btn btn-primary" onclick="getProfile();"><?=$_ENV['currency'];?><span class="ms-1 userBalance"></span></button>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-dark">
                <figure class="text-center text-light">
                    <img class="w-50" src="">
                    <input type="text" class="w-100 border-0 bg-transparent text-center text-light" name="gamebalance" readonly>
                    <label><?=lang('Input.gamebalance');?></label>
                </figure>
                <?=form_open('',['class'=>'form-validation customForm','novalidate'=>'novalidate'],['provider'=>'','gname'=>'','species'=>'']);?>
                <div class="mb-3 text-center">
                    <div class="input-group mb-3">
                        <span class="input-group-text btn-primary minLottoBonus">0</span>
                        <input type="number" step="any" class="form-control text-center" min="1" name="amount" required>
                        <span class="input-group-text btn-primary maxLottoBonus">0</span>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg"><?=lang('Nav.claimbonus');?></button>
                    <a target="_blank" class="btn btn-primary btn-lg btn-play"><?=lang('Nav.playgame');?></a>
                </div>
                <?=form_close();?>
            </div>
        </div>
    </div>
</section>

<section class="modal fade modal-singleGameLanding" id="modal-singleGameLanding" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-singleGameLanding" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-0 border-0">
            <div class="modal-header">
                <button type="button" class="btn btn-primary" onclick="getProfile();"><?=$_ENV['currency'];?><span class="ms-1 userBalance"></span></button>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-dark">
                <figure class="text-center text-light">
                    <img class="d-inline-block w-50" src="">
                </figure>
                <?=form_open('',['class'=>'form-validation','novalidate'=>'novalidate'],['provider'=>'','gname'=>'','species'=>'']);?>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg"><?=lang('Nav.playgame');?></button>
                </div>
                <?=form_close();?>
            </div>
        </div>
    </div>
</section>
<!-- End Games -->

<!-- Promotion -->
<div class="modal fade modal-promo" id="promoModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 id="promoTitle" class="modal-title promo-title"></h3>
					<a class="modal-close icon-close" data-bs-dismiss="modal" aria-label="Close"></a>
				</div>
				<div class="modal-body">
					<img class="modal-promo-image promo-banner" id="promoImg">
					<div class="promo-desc"></div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
<!-- End Promotion -->

<!-- Tutorial -->
<section class="modal fade modal-tutorialBox" id="modal-tutorialBox" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-tutorialBox" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-fullscreen-lg-down modal-dialog-scrollable">
		<article class="modal-content bg-dark">
			<div class="modal-header border-dark">
				<h4 class="modal-title tutor-title"></h4>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!--<article class="tutorial-desc"></article>-->
				<article class="tutor-desc"></article>
			</div>
		</article>
	</div>
</section>
<!-- End Tutorial -->

<!--- ByPassBlockPopUp --->
<section class="modal fade modal-byPassPopUp" id="modal-byPassPopUp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-byPassPopUp" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<article class="modal-content border-0">
			<div class="modal-header visually-hidden">
				<h5 class="modal-title fs-5">Notification</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
                <p><?=lang('Validation.opennewtab');?></p>
				<a target="_blank" class="btn btn-primary" href="javascript:void(0);" data-bs-dismiss="modal" aria-label="Close">OK</a>
			</div>
		</article>
	</div>
</section>
<!--- End ByPassBlockPopUp --->

<section class="modal fade modal-gameTransferBox" id="modal-gameTransferBox" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-gameTransferBox" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-0 bg-dark">
            <div class="modal-header">
                <h5><?=lang('Label.transfer2');?>【<span class="gamename"></span>】</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?=form_open('',['class'=>'form-validation customForm','novalidate'=>'novalidate'],['provider'=>'','gname'=>'','species'=>'']);?>
                <div class="row gx-3 mb-3">
                    <label class="col-auto col-form-label"><?=lang('Label.currentbalance');?>：<span class="userBalance">0.00</span></label>
                    <div class="col-auto ms-auto">
                        <button type="button" class="btn btn-secondary rounded" onclick="refreshAndWithdrawGame();"><?=lang('Nav.restore');?></button>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-9">
                        <input type="text" class="form-control border" name="amount" placeholder="<?=lang('Label.enteramount');?>" required>
                    </div>
                    <div class="col-3 ms-auto">
                        <button type="button" class="btn btn-primary rounded w-100 h-100" onclick="copyAllBalance('modal-gameTransferBox');"><?=lang('Label.all');?></button>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-4">
                        <input type="radio" class="btn-check" name="room" id="room2" value="2X" autocomplete="off"><label class="btn btn-light w-100" for="room2">2X</label>
                    </div>
                    <div class="col-4">
                        <input type="radio" class="btn-check" name="room" id="room5" value="5X" autocomplete="off"><label class="btn btn-light w-100" for="room5">5X</label>
                    </div>
                    <div class="col-4">
                        <input type="radio" class="btn-check" name="room" id="room10" value="10X" autocomplete="off"><label class="btn btn-light w-100" for="room10">10X</label>
                    </div>
                </div>
                <div class="row gx-3">
                    <div class="col-6"><button type="button" class="btn btn-outline-secondary w-100" onclick="gameTransferOpenDirect();"><?=lang('Label.entergame');?></button></div>
                    <div class="col-6"><button type="submit" class="btn btn-secondary w-100"><?=lang('Label.transfer2game');?></button></div>
                </div>
                <?=form_close();?>
            </div>
        </div>
    </div>
</section>

<section class="modal fade modal-appTransferBox" id="modal-appTransferBox" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-appTransferBox" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5><?=lang('Label.transfer2');?>【<span class="gamename"></span>】</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?=form_open('',['class'=>'form-validation','novalidate'=>'novalidate'],['provider'=>'','gname'=>'','species'=>'']);?>
                <div class="row gx-3 mb-3">
                    <label class="col-auto col-form-label"><?=lang('Label.currentbalance');?>: <span class="userBalance">0.00</span></label>
                    <div class="col-auto ms-auto">
                        <button type="button" class="btn btn-secondary rounded" onclick="refreshAndWithdrawGame();"><?=lang('Nav.restore');?></button>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-8">
                        <input type="text" class="form-control border" name="amount" placeholder="输入金额" required>
                    </div>
                    <div class="col-4 ms-auto">
                        <button type="button" class="btn btn-primary rounded w-100 h-100" onclick="copyAllBalance('modal-appTransferBox');"><?=lang('Label.all');?></button>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-3">
                        <input type="radio" class="btn-check" name="room" id="room2m" value="2X" autocomplete="off" checked><label class="btn btn-light w-100" for="room2m">2X</label>
                    </div>
                    <div class="col-3">
                        <input type="radio" class="btn-check" name="room" id="room5m" value="5X" autocomplete="off"><label class="btn btn-light w-100" for="room5m">5X</label>
                    </div>
                    <div class="col-3">
                        <input type="radio" class="btn-check" name="room" id="room10m" value="10X" autocomplete="off"><label class="btn btn-light w-100" for="room10m">10X</label>
                    </div>
                    <div class="col-3">
                        <input type="radio" class="btn-check" name="room" id="room20m" value="20X" autocomplete="off"><label class="btn btn-light w-100" for="room20m">20X</label>
                    </div>
                </div>

                <div class="mb-3 visually-hidden">
                    <div class="input-group">
                        <div class="input-group-text btn btn-secondary"><i class="bx bxs-user"></i></div>
                        <input type="text" class="form-control form-control-lg bg-white" name="gameuserid" id="gameuserid" readonly>
                        <button type="button" class="btn btn-secondary" id="btn-copygid"><i class="bx bxs-copy-alt"></i></button>
                    </div>
                </div>
                <div class="mb-3 visually-hidden">
                    <div class="input-group">
                        <div class="input-group-text btn btn-secondary"><i class="bx bxs-lock"></i></div>
                        <input type="text" class="form-control form-control-lg bg-white" name="gameuserpass" id="gameuserpass" readonly>
                        <button type="button" class="btn btn-secondary" id="btn-copygpass"><i class="bx bxs-copy-alt"></i></button>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-secondary"><?=lang('Label.transfer2game');?></button>
                    <button type="button" class="btn btn-light w-100" onclick="gameAppTransferOpenDirect();"><?=lang('Label.entergame');?></button>
                    <a target="_blank" class="text-decoration-none btn btn-link text-primary btn-download" href=""><?=lang('Nav.dwgameapp');?></a>
                </div>
                <?=form_close();?>
            </div>
        </div>
    </div>
</section>

<!-- fishing -->
<section class="modal fade modal-singleGameTransferBox" id="modal-singleGameTransferBox" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-singleGameTransferBox" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-0 bg-dark">
            <div class="modal-header">
                <h5><?=lang('Label.transfer2');?>【<span class="gamename"></span>】<!--【<span class="providername"></span>】--></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?=form_open('',['class'=>'form-validation customForm','novalidate'=>'novalidate'],['provider'=>'','gname'=>'','species'=>'','gamecode'=>'']);?>
                <div class="row gx-3 mb-3">
                    <label class="col-auto col-form-label"><?=lang('Label.currentbalance');?>：<span class="userBalance">0.00</span></label>
                    <div class="col-auto ms-auto">
                        <button type="button" class="btn btn-secondary rounded" onclick="refreshAndWithdrawGame();"><?=lang('Nav.restore');?></button>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-9">
                        <input type="text" class="form-control border" name="amount" placeholder="<?=lang('Label.enteramount');?>" required>
                    </div>
                    <div class="col-3 ms-auto">
                        <button type="button" class="btn btn-primary rounded w-100 h-100" onclick="copyAllBalance('modal-singleGameTransferBox');"><?=lang('Label.all');?></button>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-3">
                        <input type="radio" class="btn-check" name="sroom" id="sroom1" value="" autocomplete="off" checked><label class="btn btn-light w-100" for="sroom1">1X</label>
                    </div>
                    <div class="col-3">
                        <input type="radio" class="btn-check" name="sroom" id="sroom2" value="2X" autocomplete="off"><label class="btn btn-light w-100" for="sroom2">2X</label>
                    </div>
                    <div class="col-3">
                        <input type="radio" class="btn-check" name="sroom" id="sroom5" value="5X" autocomplete="off"><label class="btn btn-light w-100" for="sroom5">5X</label>
                    </div>
                    <div class="col-3">
                        <input type="radio" class="btn-check" name="sroom" id="sroom10" value="10X" autocomplete="off"><label class="btn btn-light w-100" for="sroom10">10X</label>
                    </div>
                    <!--<div class="col-3">
                        <input type="radio" class="btn-check" name="sroom" id="sroom20" value="20X" autocomplete="off"><label class="btn btn-light w-100" for="sroom20">20X</label>
                    </div>-->
                </div>
                <div class="row gx-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-secondary w-100"><?=lang('Label.transfer2game');?></button>
                        <!--<button type="button" class="btn btn-secondary w-100" onclick="singleGameLaunch();"><?=lang('Label.entergame');?></button>-->
                    </div>
                </div>
                <?=form_close();?>
            </div>
        </div>
    </div>
</section>

<script src="<?=base_url('../assets/vendors/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
<script src="<?=base_url('../assets/vendors/sweetalert2/sweetalert2.min.js');?>"></script>
<script src="<?=base_url('../assets/vendors/airdatepicker/js/datepicker.min.js');?>"></script>
<script src="<?=base_url('../assets/vendors/airdatepicker/js/i18n/datepicker.en.js');?>"></script>
<script src="<?=base_url('../assets/vendors/airdatepicker/js/i18n/datepicker.zh.js');?>"></script>
<script src="<?=base_url('../assets/js/master.js?v='.rand());?>"></script>
<!--<script src="<?=base_url('../assets/js/add2home.js?v='.rand());?>"></script>-->
<script src="<?=base_url('../assets/vendors/html2canvas/html2canvas.js');?>"></script>
<script src="<?=base_url('../assets/vendors/qrcode/qrcode.min.js');?>"></script>
<script src="<?=base_url('../assets/vendors/chatscreen/chatscreen.js?v='.rand());?>"></script>
<script src="<?=base_url('../assets/vendors/slick/js/slick.min.js');?>"></script>
<script src="<?=base_url('../assets/vendors/notify/js/notify.js');?>"></script>
<script src="<?=base_url('../assets/js/jquery.marquee.min.js');?>"></script>
<script src="<?=base_url('../assets/js/main.js');?>"></script>

<audio id="audio" src="<?=base_url('../assets/sound/celebration.mp3');?>" autostart="false" ></audio>

<?php if( isset($_SESSION['logged_in']) ): ?>
<section class="modal fade modal-affiliateQR" id="modal-affiliateQR" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-affiliateQR" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
        <article class="modal-content bg-dark">
            <div class="modal-header border-dark">
                <h5 class="modal-title"><?=lang('Sentence.shareqr');?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-0 pb-3 text-center">
                <div class="qrcard">
                    <figure class="px-3 pt-2 pb-3 w-50 mx-auto my-0">
                        <img class="w-100" src="<?=!empty($logo) ? $logo : base_url('../assets/img/logo/logo.png');?>" title="<?=$_ENV['company'];?>" alt="<?=$_ENV['company'];?>">
                    </figure>
                    <div class="text-center w-50 mx-auto p-2 bg-white rounded-3">
                        <figure id="qrcode" class="w-100 p-0 m-0"></figure>
                    </div>

                    <input type="text" class="form-control border-0 my-0 w-75 mx-auto bg-transparent text-warning text-center" placeholder="<?=lang('Validation.nickname');?>">

                    <small class="d-block bg-primary p-2 my-3 fw-light text-uppercase">
                        <!-- <span class="d-block">Scan untuk daftar</span> -->
                        <span class="d-block">Scan to register</span>
                        <span class="d-block">只需掃二維碼即馬上可註冊</span>
                    </small>
                </div>
                <div class="">
                    <a href="javascript:void(0);" class="btn btn-secondary btn-qrreg"><?=lang('Nav.share');?></a>
                    <!-- <a href="javascript:void(0);" class="btn btn-primary btn-lg getscreen" onclick="getScreen();"><?//=lang('Nav.save');?></a> -->
                </div>
            </div>
        </article>
    </div>
</section>

<script src="<?=base_url('../assets/vendors/draggable/draggabilly.js');?>"></script>
<script src="<?=base_url('../assets/vendors/draggable/draggabilly.pkgd.min.js');?>"></script>
<?php endif; ?>

</body>
</html>

<script>
const logged = '<?=$session;?>';
document.addEventListener('DOMContentLoaded', (event) => {
    supportList();

    callingSlotMenu();
    callingSportMenu();
    callingCasinoMenu();
    callingLottoMenu();
    
    if( logged )
    {
        announcementList();
        getProfile();

        const affiliateQREvent = document.getElementById('modal-affiliateQR');
        affiliateQREvent.addEventListener('shown.bs.modal', function (event) {
            affiliateQR();
        });
        affiliateQREvent.addEventListener('hidden.bs.modal', function (event) {
            document.getElementById("qrcode").innerHTML = '';
        });
    }

    let copyGid = document.getElementById('btn-copygid');
    copyGid.addEventListener('click', () => {
        let str = document.getElementById('gameuserid');
        str.select();
        str.setSelectionRange(0, 99999);
        document.execCommand('copy');
    });

    let copyGpass = document.getElementById('btn-copygpass');
    copyGpass.addEventListener('click', () => {
        let str = document.getElementById('gameuserpass');
        str.select();
        str.setSelectionRange(0, 99999);
        document.execCommand('copy');
    });

    function byPassBlockPopUp(url) {
        $('.modal-byPassPopUp').modal('toggle');
        $('.modal-byPassPopUp .modal-body a').attr('onclick', 'return pop("'+url+'",300,200);');
    }

    // Games
    $('.modal-gameLanding .btn-close, .modal-gameLobby .btn-close, .modal-slotLobby .btn-close, .modal-prompt .btn-exit, .modal-appLanding .btn-close, .modal-appUrlLanding .btn-close, .modal-lottoLanding .btn-close, .modal-singleGameLanding .btn-close, .modal-gameTransferBox .btn-close, .modal-singleGameTransferBox .btn-close').off().on('click', function(e) {
        e.preventDefault();
        const provider = $(this).data('provider');
        $('.modal-slotLobby').modal('hide');
        $('.modal-prompt').modal('hide');
        $('.modal-appLanding').modal('hide');
        $('.modal-appUrlLanding').modal('hide');
        // alert(provider);
        if( provider ) {
            gameWithdrawal(provider);
        }
    });

    $('.modal-gameLanding form').on('submit', function(e) {
        e.preventDefault();
        let name = $('.modal-gameLanding [name=gname]').val();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.modal-gameLanding [type=submit]').prop('disabled', true);

            $.get('/device/check', function(dataDevice, statusDevice) {
                const objDevice = JSON.parse(dataDevice);

                let isMobile;
                if( objDevice.mobile==true ) {
                    isMobile = 1;
                } else {
                    isMobile = 0;
                }

                var params = {};
                var formObj = $('.modal-gameLanding form').closest("form");
                $.each($(formObj).serializeArray(), function (index, value) {
                    params[value.name] = value.value;
                    params['isMobile'] = isMobile;
                    params['credit'] = $('.modal-gameLanding .userBalance').html();
                    params['type'] = 1;
                });

                $.post('/game/lobby/open', {
                    params
                }, function(data, status) {
                    const obj = JSON.parse(data);
                    if( obj.code==1 ) {
                        swal.close();
                        refreshBalance();

                        if( objDevice.mobile==true ) {
                            if( params['species']==1 ) {
                                getGameBalance(1,params['provider']);
                                $('.modal-gameLobby').modal('toggle');
                                $('.modal-gameLobby .gamename').html(name);
                                $('.modal-gameLobby .btn-close').data('provider', params['provider']);
                            } else if( params['species']==2 ) {
                                getGameBalance(2,params['provider']);
                                $('.modal-slotLobby').modal('toggle');
                                // $('.modal-slotLobby .btn-close').data('provider', params['provider']);
                                // $('.modal-slotLobby .draggable').attr('href',obj.url);

                                prompt(params['provider'], obj.url);
                            }
                        } else {
                            if( params['species']==1 ) {
                                getGameBalance(1,params['provider']);
                            } else if( params['species']==2 ) {
                                getGameBalance(2,params['provider']);
                            }
                            window.open(obj.url, '_blank');
                        }
                        gameLobby(params['species'], obj.url);
                    } else {
                        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                    }
                })
                .done(function() {
                    $('.modal-gameLanding [type=submit]').prop('disabled', false);
                })
                .fail(function() {
                    swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
                });
            });
        }
    });

    const gameLandingModel = document.getElementById('modal-gameLanding');
    gameLandingModel.addEventListener('hidden.bs.modal', function (event) {
        $(this).find('.btn-close').data('provider','');
        $(this).find('[name=gamebalance]').val(0);
    });

    const gameLobbyModel = document.getElementById('modal-gameLobby');
    gameLobbyModel.addEventListener('hidden.bs.modal', function (event) {
        $(this).find('.lobby').html('');
    });

    const slotLobbyModel = document.getElementById('modal-slotLobby');
    slotLobbyModel.addEventListener('hidden.bs.modal', function (event) {
        $('.modal-prompt .btn-exit').data('provider', '');
        $(this).find('.btn-close').data('provider', '');
        $(this).find('.lobby').html('');
    });
    slotLobbyModel.addEventListener('shown.bs.modal', function (event) {
        var $draggableLobby = $('.dgb-lobby').draggabilly({
            containment: true
        });

        var startOrientationLobby = $('.dgb-lobby').data('draggabilly');
        startOrientationLobby.setPosition(100,0);

        $draggableLobby.on('staticClick',function( event, pointer ) {
            // $('.modal-slotLobby').modal('toggle');
            $('.modal-prompt').modal('toggle');
        });

        window.addEventListener("orientationchange", function() {
            // console.log("the orientation of the device is now " + screen.orientation.angle);
            var revertOrientationLobby = $('.dgb-lobby').data('draggabilly');
            revertOrientationLobby.setPosition(200,0);
        }, false);
    });

    const promptyModel = document.getElementById('modal-prompt');
    promptyModel.addEventListener('hidden.bs.modal', function (event) {
        // $(this).find('.btn-exit').data('provider', '');
    });

    $('.modal-appLanding form').on('submit', function(e) {
        e.preventDefault();
        let name = $('.modal-appLanding [name=gname]').val();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.modal-appLanding [type=submit]').prop('disabled', true);

            $.get('/device/check', function(dataDevice, statusDevice) {
                const objDevice = JSON.parse(dataDevice);

                let isMobile;
                if( objDevice.mobile==true && objDevice.platform=='iOS' ) {
                    isMobile = 3;
                } else if( objDevice.mobile==true && objDevice.platform=='Android' ) {
                    isMobile = 2;
                } else {
                    isMobile = 1;
                }

                var params = {};
                var formObj = $('.modal-appLanding form').closest("form");
                $.each($(formObj).serializeArray(), function (index, value) {
                    params[value.name] = value.value;
                    params['isMobile'] = isMobile;
                    params['credit'] = $('.modal-appLanding .userBalance').html();
                    params['type'] = 1;
                });

                $.post('/game/lobby/open', {
                    params
                }, function(data, status) {
                    const obj = JSON.parse(data);
                    if( obj.code==1 ) {
                        swal.close();
                        $('.modal-appLanding [type=submit]').prop('disabled', false);

                        const checkJson = isJson(obj.url);
                        const station = JSON.parse(obj.url);

                        refreshBalance();
                        getGameBalance(params['species'], params['provider']);

                        if( objDevice.mobile==true && checkJson==true ) {
                            if( objDevice.platform=='Android' ) {
                                station.Android!='' ? window.location = station.Android : '';
                            } else if( objDevice.platform=='iOS' ) {
                                station.IOS!='' ? window.open(station.IOS, '_blank') : '';
                            }
                        }
                    } else {
                        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                    }
                })
                .done(function() {
                    $('.modal-appLanding [type=submit]').prop('disabled', false);
                })
                .fail(function() {
                    swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
                });
            });
        }
    });

    const applandingModel = document.getElementById('modal-appLanding');
    applandingModel.addEventListener('hidden.bs.modal', function (event) {
        $(this).find('form').trigger('reset');
        $(this).find('form').removeClass('was-validated');
        $(this).find('[type=submit]').prop('disabled', false);
        $(this).find('.btn-download').attr('href','');
        $(this).find('.btn-close').data('provider','');
        $('.modal-appLanding [name=gamebalance]').val(0);
    });

    $('.modal-appUrlLanding form').on('submit', function(e) {
        e.preventDefault();
        let name = $('.modal-appUrlLanding [name=gname]').val();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.modal-appUrlLanding [type=submit]').prop('disabled', true);

            $.get('/device/check', function(dataDevice, statusDevice) {
                const objDevice = JSON.parse(dataDevice);

                let isMobile;
                if( objDevice.mobile==true ) {
                    isMobile = 1;
                } else {
                    isMobile = 0;
                }

                var params = {};
                var formObj = $('.modal-appUrlLanding form').closest("form");
                $.each($(formObj).serializeArray(), function (index, value) {
                    params[value.name] = value.value;
                    params['isMobile'] = isMobile;
                    params['credit'] = $('.modal-appUrlLanding .userBalance').html();
                    params['type'] = 1;
                });

                $.post('/game/lobby/open', {
                    params
                }, function(data, status) {
                    const obj = JSON.parse(data);
                    if( obj.code==1 ) {
                        swal.close();
                        refreshBalance();
                        getGameBalance(params['species'], params['provider']);
                        window.open(obj.url);
                    } else {
                        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                    }
                })
                .done(function() {
                    $('.modal-appUrlLanding [type=submit]').prop('disabled', false);
                })
                .fail(function() {
                    swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
                });
            });
        }
    });

    $('.modal-lottoLanding form').on('submit', function(e) {
        e.preventDefault();
        let name = $('.modal-lottoLanding [name=gname]').val();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.modal-lottoLanding [type=submit]').prop('disabled', true);

            $.get('/device/check', function(dataDevice, statusDevice) {
                const objDevice = JSON.parse(dataDevice);

                let isMobile;
                if( objDevice.mobile==true ) {
                    isMobile = 1;
                } else {
                    isMobile = 0;
                }

                var params = {};
                var formObj = $('.modal-lottoLanding form').closest("form");
                $.each($(formObj).serializeArray(), function (index, value) {
                    params[value.name] = value.value;
                    params['isMobile'] = isMobile;
                    params['credit'] = $('.modal-lottoLanding .userBalance').html();
                    params['type'] = 1;
                });

                $.post('/game/lobby/open', {
                    params
                }, function(data, status) {
                    const obj = JSON.parse(data);
                    if( obj.code==1 ) {
                        swal.close();
                        refreshBalance();
                        getGameBalance(5,params['provider']);
                        window.open(obj.url, '_blank');
                    } else {
                        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                    }
                })
                .done(function() {
                    $('.modal-lottoLanding [type=submit]').prop('disabled', false);
                })
                .fail(function() {
                    swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
                });
            });
        }
    });

    const lottoLandingModel = document.getElementById('modal-lottoLanding');
    lottoLandingModel.addEventListener('hidden.bs.modal', function (event) {
        $(this).find('form').trigger('reset');
        $(this).find('form').removeClass('was-validated');
        $(this).find('.btn-close').data('provider','');
        $('.modal-lottoLanding [name=gamebalance]').val(0);
    });

    $('.modal-lottoBonusLanding form').on('submit', function(e) {
        e.preventDefault();
        let name = $('.modal-lottoBonusLanding [name=gname]').val();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.modal-lottoBonusLanding [type=submit]').prop('disabled', true);

            $.get('/device/check', function(dataDevice, statusDevice) {
                const objDevice = JSON.parse(dataDevice);

                let isMobile;
                if( objDevice.mobile==true ) {
                    isMobile = 1;
                } else {
                    isMobile = 0;
                }

                var params = {};
                var formObj = $('.modal-lottoBonusLanding form').closest("form");
                $.each($(formObj).serializeArray(), function (index, value) {
                    params[value.name] = value.value;
                    params['isMobile'] = isMobile;
                });

                $.post('/DIY-promotion/transfer', {
                    params
                }, function(data, status) {
                    const obj = JSON.parse(data);
                    if( obj.code==1 ) {
                        $('.modal-lottoBonusLanding').find('form').trigger('reset');
                        $('.modal-lottoBonusLanding').find('form').removeClass('was-validated');
                        swal.close();
                        refreshBalance();
                        getGameBalance(6,params['provider']);
                        window.open(obj.url, '_blank');
                    } else {
                        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                    }
                })
                .done(function() {
                    $('.modal-lottoBonusLanding [type=submit]').prop('disabled', false);
                })
                .fail(function() {
                    swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
                });
            });
        }
    });

    const lottoBonusLandingModel = document.getElementById('modal-lottoBonusLanding');
    lottoBonusLandingModel.addEventListener('hidden.bs.modal', function (event) {
        $(this).find('form').trigger('reset');
        $(this).find('form').removeClass('was-validated');
        $(this).find('[name=amount]').removeAttr('max');
    });
    // End Games

    //fishing
    $('.modal-singleGameTransferBox form').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            const provider = $('.modal-singleGameTransferBox [name=provider]').val();
            const species = $('.modal-singleGameTransferBox [name=species]').val();
            const room = $('.modal-singleGameTransferBox [name=sroom]:checked').val();
            let gname =  $('.modal-singleGameTransferBox [name=gname]').val();
            let gcode =  $('.modal-singleGameTransferBox [name=gamecode]').val();
            let transferamount = $('.modal-singleGameTransferBox [name=amount]').val();

            //console.log(provider);
            //console.log(room);
            let gameprovider
            /*if( typeof room!=='undefined' )
            {
                let chr2 = provider.slice(-2);
                let chr3 = provider.slice(-3);
                if( (chr2=='2X' || chr2=='5X') && (chr3!='10X' || chr3!='20X') ) {
                    const removeOriRoom = provider.slice(0,-2);
                    gameprovider = removeOriRoom + room;
                } else {
                    const removeOriRoom = provider.slice(0,-3);
                    gameprovider = removeOriRoom + room;
                }

                // const removeOriRoom = provider.slice(0,-2);
                // gameprovider = removeOriRoom + room;
            }
            else {
                gameprovider = $('.modal-singleGameTransferBox [name=provider]').val();
            }*/

            if( typeof room!=='undefined' ) {
                gameprovider = provider + room;
            }
            else {
                gameprovider = $('.modal-singleGameTransferBox [name=provider]').val();
            }

            console.log(gameprovider);

            var params = {};
            params['provider'] = gameprovider;
            //params['credit'] = $('header .userBalance').html();
            params['credit'] = transferamount
            params['type'] = 1;

            $.post('/game/credit/transfer', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    getProfile();
                    getSingleGameinfo(gname,gameprovider,gcode);
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
    });

    const singleGameTransferBoxModel = document.getElementById('modal-singleGameTransferBox');
    singleGameTransferBoxModel.addEventListener('hidden.bs.modal', function (event) {
        $(this).find('.btn-close').data('provider','');
        $(this).find('form').trigger('reset');
        $(this).find('form').removeClass('was-validated');
    });

    // Special Games
    $('.modal-gameTransferBox form').on('submit', function(e) {
        e.preventDefault();
        let name = $('.modal-gameTransferBox [name=gname]').val();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.modal-gameTransferBox [type=submit]').prop('disabled', true);

            $.get('/device/check', function(dataDevice, statusDevice) {
                const objDevice = JSON.parse(dataDevice);

                // let isMobile;
                // if( objDevice.mobile==true ) {
                //     isMobile = 1;
                // } else {
                //     isMobile = 0;
                // }

                let isMobile;
                if( objDevice.mobile==true && objDevice.platform=='iOS' ) {
                    isMobile = 3;
                } else if( objDevice.mobile==true && objDevice.platform=='Android' ) {
                    isMobile = 2;
                } else {
                    isMobile = 1;
                }

                const provider = $('.modal-gameTransferBox [name=provider]').val();
                const room = $('.modal-gameTransferBox [name=room]:checked').val();

                let gameprovider;
                if( typeof room!=='undefined' )
                {
                    let chr2 = provider.slice(-2);
                    let chr3 = provider.slice(-3);
                    if( (chr2=='2X' || chr2=='5X') && (chr3!='10X' || chr3!='20X') ) {
                        const removeOriRoom = provider.slice(0,-2);
                        gameprovider = removeOriRoom + room;
                    } else {
                        const removeOriRoom = provider.slice(0,-3);
                        gameprovider = removeOriRoom + room;
                    }

                    // const removeOriRoom = provider.slice(0,-2);
                    // gameprovider = removeOriRoom + room;
                } else {
                    gameprovider = $('.modal-gameTransferBox [name=provider]').val();
                }

                var params = {};
                var formObj = $('.modal-gameTransferBox form').closest("form");
                $.each($(formObj).serializeArray(), function (index, value) {
                    params[value.name] = value.value;
                    params['provider'] = gameprovider;
                    params['isMobile'] = isMobile;
                    params['type'] = 1;
                });

                $.post('/game/lobby/open-partial', {
                    params
                }, function(data, status) {
                    const obj = JSON.parse(data);
                    if( obj.code==1 ) {
                        swal.close();
                        refreshBalance();

                        if( objDevice.mobile==true ) {
                            if( gameprovider=='VP2X' || gameprovider=='VP5X' || gameprovider=='VP10X' || gameprovider=='VP20X' )
                            {
                                window.open(obj.url, '_blank');
                            } else {
                                if( params['species']==1 ) {
                                    getGameBalance(1,params['provider']);
                                    $('.modal-gameLobby').modal('toggle');
                                    $('.modal-gameLobby .gamename').html(name);
                                    $('.modal-gameLobby .btn-close').data('provider', params['provider']);
                                } else if( params['species']==2 ) {
                                    getGameBalance(2,params['provider']);
                                    $('.modal-slotLobby').modal('toggle');
                                    // $('.modal-slotLobby .btn-close').data('provider', params['provider']);
                                    // $('.modal-slotLobby .dgb').attr('href',obj.url);

                                    prompt(params['provider'], obj.url);
                                }
                            }
                        } else {
                            if( params['species']==1 ) {
                                getGameBalance(1,params['provider']);
                            } else if( params['species']==2 ) {
                                getGameBalance(2,params['provider']);
                            }
                            window.open(obj.url, '_blank');
                        }
                        gameLobby(params['species'], obj.url);
                        $('.modal').modal('hide');
                    } else {
                        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                            $('.modal-gameTransferBox [type=submit]').prop('disabled', false);
                        });
                    }
                })
                .done(function() {
                    $('.modal-gameTransferBox [type=submit]').prop('disabled', false);
                })
                .fail(function() {
                    swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(() => {
                        $('.modal-gameTransferBox [type=submit]').prop('disabled', false);
                    });
                });
            });
        }
    });

    const gameTransferBoxModel = document.getElementById('modal-gameTransferBox');
    gameTransferBoxModel.addEventListener('hidden.bs.modal', function (event) {
        $(this).find('.btn-close').data('provider','');
        $(this).find('form').trigger('reset');
        $(this).find('form').removeClass('was-validated');
    });

    $('.modal-appTransferBox form').on('submit', function(e) {
        e.preventDefault();
        let name = $('.modal-appTransferBox [name=gname]').val();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.modal-appTransferBox [type=submit]').prop('disabled', true);

            $.get('/device/check', function(dataDevice, statusDevice) {
                const objDevice = JSON.parse(dataDevice);

                let isMobile;
                if( objDevice.mobile==true && objDevice.platform=='iOS' ) {
                    isMobile = 3;
                } else if( objDevice.mobile==true && objDevice.platform=='Android' ) {
                    isMobile = 2;
                } else {
                    isMobile = 1;
                }

                const provider = $('.modal-appTransferBox [name=provider]').val();
                const room = $('.modal-appTransferBox [name=room]:checked').val();
                console.log(provider);
                console.log(room);

                let gameprovider;
                if( room!='2X' )
                {
                    const removeOriRoom = provider.slice(0,-2);
                    gameprovider = removeOriRoom + room;
                } else {
                    gameprovider = $('.modal-appTransferBox [name=provider]').val();
                }

                var params = {};
                var formObj = $('.modal-appTransferBox form').closest("form");
                $.each($(formObj).serializeArray(), function (index, value) {
                    params[value.name] = value.value;
                    params['provider'] = provider;
                    params['isMobile'] = isMobile;
                    params['type'] = 1;
                });

                $.post('/game/lobby/open-partial', {
                    params
                }, function(data, status) {
                    const obj = JSON.parse(data);
                    if( obj.code==1 ) {
                        swal.close();
                        $('.modal-appTransferBox [type=submit]').prop('disabled', false);

                        const checkJson = isJson(obj.url);
                        const station = JSON.parse(obj.url);

                        refreshBalance();

                        if( objDevice.mobile==true && checkJson==true ) {
                            if( objDevice.platform=='Android' ) {
                                if( params['species']==3 ) 
                                {
                                    jokerApp(params['gameuserid'],params['gameuserpass']);
                                } else {
                                    station.Android!='' ? window.location = station.Android : '';
                                }
                            } else if( objDevice.platform=='iOS' ) {
                                station.IOS!='' ? window.open(station.IOS, '_blank') : '';
                                $('.modal').modal('hide');
                            }
                        }
                    } else {
                        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                    }
                })
                .done(function() {
                    $('.modal-appTransferBox [type=submit]').prop('disabled', false);
                })
                //.fail(function() {:blank#blocked
                    //swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(() => {
                        //$('.modal-appTransferBox [type=submit]').prop('disabled', false);
                    //});
                //});
            });
        }
    });

    const appTransferBoxModel = document.getElementById('modal-appTransferBox');
    appTransferBoxModel.addEventListener('hidden.bs.modal', function (event) {
        $(this).find('.btn-close').data('provider','');
        $(this).find('form').trigger('reset');
        $(this).find('form').removeClass('was-validated');
    });
    // End Special Games

    // Promotion
    const promoBoxEvent = document.getElementById('promoModal');
    promoBoxEvent.addEventListener('hidden.bs.modal', function (event) {
        $('.modal').find('form').removeClass('was-validated');
        $('.modal').find('form').trigger('reset');

        document.getElementsByClassName('promo-title')[0].innerHTML = '';
        document.getElementsByClassName('promo-desc')[0].innerHTML = '';
        document.getElementsByClassName('promo-banner')[0].setAttribute("src", '');
    });
    // End Promotion

    // Tutorial
    const tutorialBoxEvent = document.getElementById('modal-tutorialBox');
    promoBoxEvent.addEventListener('hidden.bs.modal', function (event) {
        $('.modal').find('form').removeClass('was-validated');
        $('.modal').find('form').trigger('reset');

        document.getElementsByClassName('tutor-desc')[0].innerHTML = '';
    });
    // End Tutorial
});

// Category
function callingAppGames()
{
    generalLoading();

    var params = {};
    params['type'] = 1;

    $.post('/list/app/games', {
        params
    }, function(data, status) {
        document.getElementById("grid-appgame").innerHTML = data;
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingOther()
{
    generalLoading();

    var params = {};
    params['type'] = 7;

    $.post('/list/others/games', {
        params
    }, function(data, status) {
        document.getElementById("grid-others").innerHTML = data;
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingKeno()
{
    generalLoading();

    var params = {};
    params['type'] = 4;

    $.post('/list/keno/games', {
        params
    }, function(data, status) {
        document.getElementById("grid-keno").innerHTML = data;
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingLotto()
{
    generalLoading();

    var params = {};
    params['type'] = 5;

    $.post('/list/lottery/games', {
        params
    }, function(data, status) {
        $.get('/device/check', function(dataDevice, statusDevice) {
            const objDevice = JSON.parse(dataDevice);

            if( objDevice.mobile==true ){
                //Mobile
                document.getElementById("grid-lottery").innerHTML = data;
            } else {
                //Desktop
                $("#grid-lottery-d").slick('unslick');
                document.getElementById("grid-lottery-d").innerHTML = data;
                gameSlick('grid-lottery-d');
            }
        });
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingLottoMenu()
{
    generalLoading();

    var params = {};
    params['type'] = 5;

    $.post('/list/lottery/gamesmenu', {
        params
    }, function(data, status) {
        $('#grid-lottery-menu').slick('slickAdd', data);
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingLottoLobby()
{
    generalLoading();

    var params = {};
    params['type'] = 5;

    $.post('/list/lottery/gameslobby', {
        params
    }, function(data, status) {
        document.getElementById("grid-lottery-lobby").innerHTML = data;
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingSport()
{
    generalLoading();

    var params = {};
    params['type'] = 3;

    $.post('/list/sportbook/games', {
        params
    }, function(data, status) {
        $.get('/device/check', function(dataDevice, statusDevice) {
            const objDevice = JSON.parse(dataDevice);

            if( objDevice.mobile==true ){
                //Mobile
                document.getElementById("grid-sport").innerHTML = data;
            } else {
                $("#grid-sport-d").slick('unslick');
                document.getElementById("grid-sport-d").innerHTML = data;
                gameSlick('grid-sport-d');
            }
        });
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingSportMenu()
{
    generalLoading();

    var params = {};
    params['type'] = 3;

    $.post('/list/sportbook/gamesmenu', {
        params
    }, function(data, status) {
        $('#grid-sport-menu').slick('slickAdd', data);
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingSportLobby()
{
    generalLoading();

    var params = {};
    params['type'] = 3;

    $.post('/list/sportbook/gameslobby', {
        params
    }, function(data, status) {
        document.getElementById("grid-sport-lobby").innerHTML = data;
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingESport()
{
    generalLoading();

    var params = {};
    params['type'] = 8;

    $.post('/list/esport/games', {
        params
    }, function(data, status) {
        const collection = document.getElementsByClassName("grid-esport");
        for (let i = 0; i < collection.length; i++) {
            collection[i].innerHTML = data;
        }
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingCasino()
{
    generalLoading();

    var params = {};
    params['type'] = 2;

    $.post('/list/live-casino/games', {
        params
    }, function(data, status) {
        $.get('/device/check', function(dataDevice, statusDevice) {
            const objDevice = JSON.parse(dataDevice);

            if( objDevice.mobile==true ){
                //Mobile
                document.getElementById("grid-casino").innerHTML = data;
            } else {
                //Desktop
                $("#grid-casino-d").slick('unslick');
                document.getElementById("grid-casino-d").innerHTML = data;
                gameSlick('grid-casino-d');
            }
        });
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingCasinoMenu()
{
    generalLoading();

    var params = {};
    params['type'] = 2;

    $.post('/list/live-casino/gamesmenu', {
        params
    }, function(data, status) {
        $('#grid-casino-menu').slick('slickAdd', data);
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingCasinoLobby()
{
    generalLoading();

    var params = {};
    params['type'] = 2;

    $.post('/list/live-casino/gameslobby', {
        params
    }, function(data, status) {
        document.getElementById("grid-casino-lobby").innerHTML = data;
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingSlot()
{
    generalLoading();

    var params = {};
    params['type'] = 1;
    params['isLobby'] = 0;

    $.post('/list/slot/games', {
        params
    }, function(data, status) {
        $.get('/device/check', function(dataDevice, statusDevice) {
            const objDevice = JSON.parse(dataDevice);

            if( objDevice.mobile==true ){
                //Mobile
                document.getElementById("grid-slot").innerHTML = data;
            } else {
                //Desktop
                $("#grid-slot-d").slick('unslick');
                document.getElementById("grid-slot-d").innerHTML = data;
                gameSlick('grid-slot-d');
            }
        });
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingSlotMenu()
{
    generalLoading();

    var params = {};
    params['type'] = 1;

    $.post('/list/slot/gamesmenu', {
        params
    }, function(data, status) {
        $('#grid-slot-menu').slick('slickAdd', data);
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

//fishing
function callingFishing()
{
    generalLoading();

    var params = {};
    params['type'] = 1;
    params['room'] = 2;
    params['minigametype'] = 6;

    $.post('/list/slot/fishing-games', {
        params
    }, function(data, status) {
        document.getElementById("grid-fishing").innerHTML = data;
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function callingSlotMultiX(num)
{
    generalLoading();

    var params = {};
    params['type'] = 1;
    
    var postAction = '';

    if( num==1 ){
        postAction = '/list/slot/games';
        params['isLobby'] = 1;
    } else {
        postAction = '/list/slot-multiple-x/games-with-transfer';
        params['room'] = num;
    }

    $.post(postAction, {
        params
    }, function(data, status) {
        const collection = document.getElementsByClassName("grid-"+num+"x");
        for (let i = 0; i < collection.length; i++) {
            collection[i].innerHTML = data;
        }
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}
// End Category

// Special Games
function gameAppTransferOpenDirect()
{
    generalLoading();

    $.get('/device/check', function(dataDevice, statusDevice) {
        const objDevice = JSON.parse(dataDevice);

        let isMobile;
        if( objDevice.mobile==true && objDevice.platform=='iOS' ) {
            isMobile = 3;
        } else if( objDevice.mobile==true && objDevice.platform=='Android' ) {
            isMobile = 2;
        } else {
            isMobile = 1;
        }

        const provider = $('.modal-appTransferBox [name=provider]').val();
        const species = $('.modal-appTransferBox [name=species]').val();
        const room = $('.modal-appTransferBox [name=room]:checked').val();

        let gameprovider;
        if( room!='2X' )
        {
            const removeOriRoom = provider.slice(0,-2);
            gameprovider = removeOriRoom + room;
        } else {
            gameprovider = $('.modal-appTransferBox [name=provider]').val();
        }

        var params = {};
        params['provider'] = gameprovider;
        params['isMobile'] = isMobile;

        $.post('/game/lobby/get', {
            params
        }, function(data, status) {
            const obj = JSON.parse(data);
            if( obj.code==1 ) {
                swal.close();

                const checkJson = isJson(obj.url);
                const station = JSON.parse(obj.url);

                if( objDevice.mobile==true && checkJson==true ) {
                    if( objDevice.platform=='Android' ) {
                        if( species==3 ) 
                        {
                            jokerApp(station.LoginId,station.Password);
                        } else {
                            station.Android!='' ? window.location = station.Android : '';
                        }
                    } else if( objDevice.platform=='iOS' ) {
                        station.IOS!='' ? window.open(station.IOS, '_blank') : '';
                        $('.modal').modal('hide');
                    }
                }
            } else {
                swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
            }
        })
        .done(function() {
        })
        .fail(function() {
            swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
        });
    });
}

$('.modal-gameTransferBox [name=room]').on('click', function(e) {
    let room = this.value;
    alert(room);
});

//fishing
$('.modal-singleGameTransferBox [name=sroom]').on('click', function(e) {
    let sroom = this.value;
    if (sroom == "") { 
        sroom = "1X";
    }
    alert(sroom);
});

function gameTransferOpenDirect()
{
    generalLoading();

    $.get('/device/check', function(dataDevice, statusDevice) {
        const objDevice = JSON.parse(dataDevice);

        let isMobile;
        if( objDevice.mobile==true && objDevice.platform=='iOS' ) {
            isMobile = 3;
        } else if( objDevice.mobile==true && objDevice.platform=='Android' ) {
            isMobile = 2;
        } else {
            isMobile = 0;
        }

        const provider = $('.modal-gameTransferBox [name=provider]').val();
        const species = $('.modal-gameTransferBox [name=species]').val();
        const room = $('.modal-gameTransferBox [name=room]:checked').val();
        console.log(provider);
        console.log(room);
        let gameprovider;
        if( typeof room!=='undefined' )
        {
            let chr2 = provider.slice(-2);
            let chr3 = provider.slice(-3);
            if( (chr2=='2X' || chr2=='5X') && (chr3!='10X' || chr3!='20X') ) {
                const removeOriRoom = provider.slice(0,-2);
                gameprovider = removeOriRoom + room;
            } else {
                const removeOriRoom = provider.slice(0,-3);
                gameprovider = removeOriRoom + room;
            }

            // const removeOriRoom = provider.slice(0,-2);
            // gameprovider = removeOriRoom + room;
        }
        else {
            gameprovider = $('.modal-gameTransferBox [name=provider]').val();
        }

        var params = {};
        params['provider'] = gameprovider;
        params['isMobile'] = isMobile;

        $.post('/game/lobby/get', {
            params
        }, function(data, status) {
            const obj = JSON.parse(data);
            if( obj.code==1 ) {
                swal.close();

                if( objDevice.mobile==true ) {
                    // window.open(obj.url, '_parent');

                    if( gameprovider=='VP2X' || gameprovider=='VP5X' || gameprovider=='VP10X' || gameprovider=='VP20X' )
                    {
                        window.open(obj.url, '_blank');
                    } else {
                        if( species==1 ) {
                            $('.modal-gameLobby').modal('toggle');
                            $('.modal-gameLobby .gamename').html(name);
                            $('.modal-gameLobby .btn-close').data('provider', params['provider']);
                        } else if( species==2 ) {
                            $('.modal-slotLobby').modal('toggle');
                            prompt(params['provider'], obj.url);
                        }
                        gameLobby(species, obj.url);
                        $('.modal').modal('hide');
                    }
                } else {
                    window.open(obj.url, '_blank');
                }
            } else {
                swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
            }
        })
        .done(function() {
        })
        .fail(function() {
            swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
        });
    });
}

$('.modal-appTransferBox [name=room]').on('click', function(e) {
    const provider = $('.modal-appTransferBox [name=provider]').val();
    let room = this.value;
    // alert(room);
    let removeOriRoom;
    if( provider.length==5 ) {
        removeOriRoom = provider.slice(0,-2);
    } else if( provider.length==6 ) {
        removeOriRoom = provider.slice(0,-3);
    }

    // const removeOriRoom = provider.slice(0,-2);
    let gameprovider;
    gameprovider = removeOriRoom + room;
    console.log(gameprovider);
    // alert(gameprovider);

    $.get('/device/check', function(dataDevice, statusDevice) {
        const objDevice = JSON.parse(dataDevice);

        let isMobile;
        if( objDevice.mobile==true && objDevice.platform=='iOS' ) {
            isMobile = 3;
        } else if( objDevice.mobile==true && objDevice.platform=='Android' ) {
            isMobile = 2;
        } else {
            isMobile = 1;
        }
        
        var params = {};
        params['provider'] = gameprovider;
        params['isMobile'] = isMobile;

        $.post('/game/lobby/get', {
            params
        }, function(data, status) {
            const obj = JSON.parse(data);
            if( obj.code==1 ) {
                const checkJson = isJson(obj.url);
                const station = JSON.parse(obj.url);

                $('.modal-appTransferBox [name=gameuserid]').val(station.LoginId);
                $('.modal-appTransferBox [name=gameuserpass]').val(station.Password);

                if( checkJson==true ) {
                    if( objDevice.platform=='Android' ) {
                        if( gameprovider=='JKR' || gameprovider=='JKR2X' || gameprovider=='JKR5X' || gameprovider=='JKR10X' || gameprovider=='JKR20X' )
                        {
                            $('.modal-appTransferBox .btn-download').attr('href','https://cutt.ly/jokerapp678g');
                        } else {
                            $('.modal-appTransferBox .btn-download').attr('href',station.AndroidDownloadURL);
                        }
                    } else if( objDevice.platform=='iOS' ) {
                        $('.modal-appTransferBox .btn-download').attr('href',station.IOSDownloadURL);
                    } else {
                        $('.modal-appTransferBox .btn-download').attr('href',station.AndroidDownloadURL);
                    }
                }
            } else {
                swal.fire("", obj.message + " (Code: "+obj.code+")", "error");
            }
        })
        .done(function() {
            swal.close();
        })
        .fail(function() {
            swal.fire("", "Please try again later.", "error");
        });
    });
});

function appTransferBox(species, name, provider)
{
    if( logged )
    {
        $('.modal-appTransferBox').modal('show');
        $('.modal-appTransferBox .gamename').html(name);
        $('.modal-appTransferBox .btn-close').data('provider', provider);
        $('.modal-appTransferBox [name=species]').val(species);
        $('.modal-appTransferBox [name=provider]').val(provider);
        $('.modal-appTransferBox [name=gname]').val(name);

        $.get('/device/check', function(dataDevice, statusDevice) {
            const objDevice = JSON.parse(dataDevice);

            let isMobile;
            if( objDevice.mobile==true && objDevice.platform=='iOS' ) {
                isMobile = 3;
            } else if( objDevice.mobile==true && objDevice.platform=='Android' ) {
                isMobile = 2;
            } else {
                isMobile = 1;
            }
            
            var params = {};
            params['provider'] = provider;
            params['isMobile'] = isMobile;

            $.post('/game/lobby/get', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    const checkJson = isJson(obj.url);
                    const station = JSON.parse(obj.url);

                    $('.modal-appTransferBox [name=gameuserid]').val(station.LoginId);
                    $('.modal-appTransferBox [name=gameuserpass]').val(station.Password);

                    if( checkJson==true ) {
                        if( objDevice.platform=='Android' ) {
                            if( provider=='JKR' || provider=='JKR2X' || provider=='JKR5X' || provider=='JKR10X' || provider=='JKR20X' )
                            {
                                $('.modal-appTransferBox .btn-download').attr('href','https://cutt.ly/jokerapp678g');
                            } else {
                                $('.modal-appTransferBox .btn-download').attr('href',station.AndroidDownloadURL);
                            }
                        } else if( objDevice.platform=='iOS' ) {
                            $('.modal-appTransferBox .btn-download').attr('href',station.IOSDownloadURL);
                        } else {
                            $('.modal-appTransferBox .btn-download').attr('href',station.AndroidDownloadURL);
                        }
                    }
                } else {
                    swal.fire("", obj.message + " (Code: "+obj.code+")", "error");
                }
            })
            .done(function() {
                swal.close();
            })
            .fail(function() {
                swal.fire("", "Please try again later.", "error");
            });
        });
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

function appLaunch(species, name, provider)
{
    if( logged )
    {
        $('.modal-appLobby').modal('show');
        $('.modal-appLobby .gamename').html(name);
        $('.modal-appLobby .btn-close').data('provider', provider);
        $('.modal-appLobby [name=species]').val(species);
        $('.modal-appLobby [name=provider]').val(provider);
        $('.modal-appLobby [name=gname]').val(name);

        $.get('/device/check', function(dataDevice, statusDevice) {
            const objDevice = JSON.parse(dataDevice);

            let isMobile;
            if( objDevice.mobile==true && objDevice.platform=='iOS' ) {
                isMobile = 3;
            } else if( objDevice.mobile==true && objDevice.platform=='Android' ) {
                isMobile = 2;
            } else {
                isMobile = 1;
            }
            
            var params = {};
            params['provider'] = provider;
            params['isMobile'] = isMobile;

            $.post('/game/lobby/get', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    const checkJson = isJson(obj.url);
                    const station = JSON.parse(obj.url);

                    $('.modal-appLobby [name=gameuserid]').val(station.LoginId);
                    $('.modal-appLobby [name=gameuserpass]').val(station.Password);

                    if( checkJson==true ) {
                        if( objDevice.platform=='Android' ) {
                            $('.modal-appLobby .btn-download').attr('href',station.AndroidDownloadURL);
                        } else if( objDevice.platform=='iOS' ) {
                            $('.modal-appLobby .btn-download').attr('href',station.IOSDownloadURL);
                        } else {
                            $('.modal-appLobby .btn-download').attr('href',station.AndroidDownloadURL);
                        }
                    }
                } else {
                    swal.fire("", obj.message + " (Code: "+obj.code+")", "error");
                }
            })
            .done(function() {
                swal.close();
            })
            .fail(function() {
                swal.fire("", "Please try again later.", "error");
            });
        });
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

function gameTransferBox(species, name, provider)
{
    if( logged )
    {
        $('.modal-gameTransferBox').modal('show');
        $('.modal-gameTransferBox .gamename').html(name);
        $('.modal-gameTransferBox .btn-close').data('provider', provider);
        $('.modal-gameTransferBox [name=species]').val(species);
        $('.modal-gameTransferBox [name=provider]').val(provider);
        $('.modal-gameTransferBox [name=gname]').val(name);
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

//fishing
function singleGameTransferBox(species, name, provider, gamecode, providername)
{
    if( logged )
    {
        $('.modal-singleGameTransferBox').modal('show');
        $('.modal-singleGameTransferBox .gamename').html(name);
        //$('.modal-singleGameTransferBox .providername').html(providername);
        $('.modal-singleGameTransferBox .btn-close').data('provider', provider);
        $('.modal-singleGameTransferBox [name=species]').val(species);
        $('.modal-singleGameTransferBox [name=provider]').val(provider);
        $('.modal-singleGameTransferBox [name=gamecode]').val(gamecode);
        $('.modal-singleGameTransferBox [name=gname]').val(name);
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

// fishing
function singleGameLaunch()
{
    if( logged )
    {
        generalLoading();

        const provider = $('.modal-singleGameTransferBox [name=provider]').val();
        const species = $('.modal-singleGameTransferBox [name=species]').val();
        const room = $('.modal-singleGameTransferBox [name=sroom]:checked').val();
        let gname =  $('.modal-singleGameTransferBox [name=gname]').val();
        let gcode =  $('.modal-singleGameTransferBox [name=gamecode]').val();

        //console.log(provider);
        //console.log(room);
        let gameprovider;
        if( typeof room!=='undefined' )
        {
            let chr2 = provider.slice(-2);
            let chr3 = provider.slice(-3);
            if( (chr2=='2X' || chr2=='5X') && (chr3!='10X' || chr3!='20X') ) {
                const removeOriRoom = provider.slice(0,-2);
                gameprovider = removeOriRoom + room;
            } else {
                const removeOriRoom = provider.slice(0,-3);
                gameprovider = removeOriRoom + room;
            }

            // const removeOriRoom = provider.slice(0,-2);
            // gameprovider = removeOriRoom + room;
        }
        else {
            gameprovider = $('.modal-singleGameTransferBox [name=provider]').val();
        }

        console.log(gameprovider);

        var params = {};
        params['provider'] = gameprovider;
        params['credit'] = $('header .userBalance').html();
        params['type'] = 1;

        $.post('/game/credit/transfer', {
            params
        }, function(data, status) {
            const obj = JSON.parse(data);
            if( obj.code==1 ) {
                getProfile();
                getSingleGameinfo(gname,gameprovider,gcode);
            } else {
                swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
            }
        })
        .done(function() {
        })
        .fail(function() {
            swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
        });
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}
//fishing
function getSingleGameinfo(gname,gpcode,gcode)
{
    $.get('/device/check', function(dataDevice, statusDevice) {
        const objDevice = JSON.parse(dataDevice);

        let isMobile;
        if( objDevice.mobile==true ) {
            isMobile = 1;
        } else {
            isMobile = 0;
        }

        var params = {};
        params['provider'] = gpcode;
        params['gcode'] = gcode;
        params['isMobile'] = isMobile;
        //params['credit'] = transferamount;

        $.post('/single-game/open', {
            params
        }, function(data, status) {
            const obj = JSON.parse(data);
            if( obj.code==1 ) {
                swal.close();

                if( objDevice.mobile==true && isMobile!=0 )
                {
                    $('.modal-slotLobby').modal('show');
                    prompt(gpcode, obj.url);
                    gameLobby(2, obj.url);
                    $('.modal-singleGameTransferBox').modal('hide');
                    //$('.modal').modal('hide');
                }
                else
                {
                    window.open(obj.url, '_blank');
                }
            } else {
                swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
            }
        })
        .done(function() {
        })
        .fail(function() {
            swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
        });
    });
}

function copyAllBalance(element)
{
    const credit = $('.'+element+' .userBalance').html();
    $('.'+element + ' [name=amount]').val(credit);
}
// End Special Games

// Games
function jokerApp(gameid,gamepass)
{
    var params = {};
    params['gameid'] = gameid;
    params['gamepass'] = gamepass;

    $.post('/game/joker-app', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            window.open(obj.url, '_parent');
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

function prompt(provider, lobby)
{
    $('.modal-prompt .btn-exit').data('provider', provider);

    $('.modal-prompt .btn-lobby').on('click', function(e) {
        document.getElementById("slotLobby").innerHTML='';
        $('.modal-prompt').modal('toggle');
        gameLobby(2,lobby);
    });
}

function expressLobby(name, provider)
{
    generalLoading();
    
    $.get('/device/check', function(dataDevice, statusDevice) {
        const objDevice = JSON.parse(dataDevice);

        let isMobile;
        if( objDevice.mobile==true ) {
            isMobile = 1;
        } else {
            isMobile = 0;
        }

        var params = {};
        params['provider'] = provider;
        params['isMobile'] = isMobile;
        params['credit'] = $('header .userBalance').html();
        params['type'] = 1;

        $.post('/game/lobby/open', {
            params
        }, function(data, status) {
            const obj = JSON.parse(data);
            if( obj.code==1 ) {
                swal.close();
                refreshBalance();

                if( objDevice.mobile==true ) {
                    window.open(obj.url, '_parent');
                } else {
                    window.open(obj.url, '_blank');
                }
            } else {
                swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
            }
        })
        .done(function() {
        })
        .fail(function() {
            swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
        });
    });
}

function expressFloatLobby(species, name, provider)
{
    generalLoading();
    
    $.get('/device/check', function(dataDevice, statusDevice) {
        const objDevice = JSON.parse(dataDevice);

        let isMobile;
        if( objDevice.mobile==true ) {
            isMobile = 1;
        } else {
            isMobile = 0;
        }
        // if( objDevice.mobile==true && objDevice.platform=='iOS' ) {
        //     isMobile = 3;
        // } else if( objDevice.mobile==true && objDevice.platform=='Android' ) {
        //     isMobile = 2;
        // } else {
        //     isMobile = 0;
        // }

        var params = {};
        params['provider'] = provider;
        params['isMobile'] = isMobile;
        params['credit'] = $('header .userBalance').html();
        params['type'] = 1;

        $.post('/game/lobby/open', {
            params
        }, function(data, status) {
            const obj = JSON.parse(data);
            if( obj.code==1 ) {
                swal.close();
                refreshBalance();

                //window.open(obj.url, '_blank');

                if( objDevice.mobile==true ) {
                    // window.open(obj.url, '_parent');

                    if( provider=='VP' || provider=='XE8' || provider=='AC3' )
                    {
                        window.open(obj.url, '_blank');
                    } else {
                        if( species==1 ) {
                            $('.modal-gameLobby').modal('toggle');
                            $('.modal-gameLobby .gamename').html(name);
                            $('.modal-gameLobby .btn-close').data('provider', params['provider']);
                        } else if( species==2 ) {
                            $('.modal-slotLobby').modal('toggle');
                            prompt(params['provider'], obj.url);
                        }
                        gameLobby(species, obj.url);
                    }
                } else {
                    window.open(obj.url, '_blank');
                }
            } else {
                swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
            }
        })
        .done(function() {
        })
        .fail(function() {
            swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
        });
    });
}

function gameLobby(species, lobby)
{
    var node = document.createElement('iframe');
    node.setAttribute('allowfullscreen','allowfullscreen');
    node.setAttribute('frameborder','0');
    node.setAttribute('loading','lazy');
    node.setAttribute('width','100%');
    node.setAttribute('height','100%');
    node.src = lobby;
    node.seamless;

    if( species==1 ) {
        document.getElementById("gameLobby").appendChild(node);
    } else if( species==2 ) {
        document.getElementById("slotLobby").appendChild(node);
    }
}

function gameWithdrawal(provider)
{
    generalLoading();

    var params = {};
    params['provider'] = provider;
    params['type'] = 2;

    $.post('/game/lobby/close', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            refreshBalance();
            $('.modal').modal('hide');
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function getGameBalance(species, provider)
{
    var params = {};
    params['provider'] = provider;

    $.post('/game/balance/check', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            if( species==1 || species==2 ) {
                $('.modal-gameLanding [name=gamebalance]').val(obj.balance);
                // obj.balance>0 ? $('.modal-gameLanding .btn-close').data('provider', provider) : '';
                $('.modal-gameLanding .btn-close').data('provider', provider);
            } else if( species==3 ) {
                $('.modal-appLanding [name=gamebalance]').val(obj.balance);
                // obj.balance>0 ? $('.modal-appLanding .btn-close').data('provider', provider) : '';
                $('.modal-appLanding .btn-close').data('provider', provider);
            } else if( species==4 ) {
                $('.modal-appUrlLanding [name=gamebalance]').val(obj.balance);
                // obj.balance>0 ? $('.modal-appUrlLanding .btn-close').data('provider', provider) : '';
                $('.modal-appUrlLanding .btn-close').data('provider', provider);
            } else if( species==5 ) {
                $('.modal-lottoLanding [name=gamebalance]').val(obj.balance);
                // obj.balance>0 ? $('.modal-lottoLanding .btn-close').data('provider', provider) : '';
                $('.modal-lottoLanding .btn-close').data('provider', provider);
            } else if( species==6 ) {
                $('.modal-lottoBonusLanding [name=gamebalance]').val(obj.balance);
                let maxLottoBonus = $('.modal-lottoBonusLanding .maxLottoBonus').html();
                $('.modal-lottoBonusLanding [name=amount]').attr('max', maxLottoBonus);
            }
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

function appUrlLanding(species, name, provider)
{
    if( logged )
    {
        $('.modal-appUrlLanding').modal('toggle');
        $('.modal-appUrlLanding img').attr('src','<?=$_ENV['gameProviderLogo'];?>/'+provider+'.png');
        $('.modal-appUrlLanding [name=gname]').val(name);
        $('.modal-appUrlLanding [name=provider]').val(provider);
        $('.modal-appUrlLanding [name=species]').val(species);
        getGameBalance(species, provider);
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

function appLanding(species, name, provider)
{
    if( logged )
    {
        generalLoading();

        $('.modal-appLanding').modal('toggle');
        $('.modal-appLanding img').attr('src','<?=$_ENV['gameProviderLogo'];?>/'+provider+'.png');
        $('.modal-appLanding [name=gname]').val(name);
        $('.modal-appLanding [name=provider]').val(provider);
        $('.modal-appLanding [name=species]').val(species);
        getGameBalance(species, provider);

        $.get('/device/check', function(dataDevice, statusDevice) {
            const objDevice = JSON.parse(dataDevice);

            let isMobile;
            if( objDevice.mobile==true && objDevice.platform=='iOS' ) {
                isMobile = 3;
            } else if( objDevice.mobile==true && objDevice.platform=='Android' ) {
                isMobile = 2;
            } else {
                isMobile = 1;
            }
            
            var params = {};
            params['provider'] = provider;
            params['isMobile'] = isMobile;

            $.post('/game/lobby/get', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    const checkJson = isJson(obj.url);
                    const station = JSON.parse(obj.url);

                    $('.modal-appLanding [name=gameuserid]').val(station.LoginId);
                    $('.modal-appLanding [name=gameuserpass]').val(station.Password);

                    if( checkJson==true ) {
                        if( objDevice.platform=='Android' ) {
                            if( provider=='JKR' || provider=='JKR2X' || provider=='JKR5X' || provider=='JKR10X' || provider=='JKR20X' )
                            {
                                $('.modal-appLanding .btn-download').attr('href','https://cutt.ly/jokerapp678g');
                            } else {
                                $('.modal-appLanding .btn-download').attr('href',station.AndroidDownloadURL);
                            }
                        } else if( objDevice.platform=='iOS' ) {
                            $('.modal-appLanding .btn-download').attr('href',station.IOSDownloadURL);
                        } else {
                            $('.modal-appLanding .btn-download').attr('href',station.AndroidDownloadURL);
                        }
                    }
                } else {
                    swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                }
            })
            .done(function() {
                swal.close();
            })
            .fail(function() {
                swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
            });
        });
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

function gameLandingExpress(species, name, provider)
{
    if( logged )
    {
        expressFloatLobby(species, name, provider);
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

function gameLanding(species, name, provider)
{
    if( logged )
    {
        $('.modal-gameLanding').modal('toggle');
        $('.modal-gameLanding img').attr('src','<?=$_ENV['gameProviderLogo'];?>/'+provider+'.png');
        $('.modal-gameLanding [name=gname]').val(name);
        $('.modal-gameLanding [name=provider]').val(provider);
        $('.modal-gameLanding [name=species]').val(species);
        getGameBalance(species, provider);
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

function lottoLanding(species, name, provider)
{
    if( logged )
    {
        $('.modal-lottoLanding').modal('toggle');
        $('.modal-lottoLanding img').attr('src','<?=$_ENV['gameProviderLogo'];?>/'+provider+'.png');
        $('.modal-lottoLanding [name=gname]').val(name);
        $('.modal-lottoLanding [name=provider]').val(provider);
        $('.modal-lottoLanding [name=species]').val(species);
        getGameBalance(species, provider);
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

function lottoBonusLanding(species, name, provider)
{
    if( logged )
    {
        $('.modal-lottoBonusLanding').modal('toggle');
        $('.modal-lottoBonusLanding img').attr('src','<?=$_ENV['gameProviderLogo'];?>/'+provider+'.png');
        $('.modal-lottoBonusLanding [name=gname]').val(name);
        $('.modal-lottoBonusLanding [name=provider]').val(provider);
        $('.modal-lottoBonusLanding [name=species]').val(species);
        getGameBalance(species, provider);

        $.get('/device/check', function(dataDevice, statusDevice) {
            const objDevice = JSON.parse(dataDevice);

            let isMobile;
            if( objDevice.mobile==true ) {
                isMobile = 1;
            } else {
                isMobile = 0;
            }

            var params = {};
            params['provider'] = provider;
            params['isMobile'] = isMobile;

            $.post('/game/lobby/get', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    $('.modal-lottoBonusLanding .btn-play').attr('href',obj.url);
                } else {
                    swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                }
            })
            .done(function() {
            })
            .fail(function() {
                swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
            });
        });
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

function expressSingleFloatLobby(species, name, provider,code)
{
    generalLoading();
    
    $.get('/device/check', function(dataDevice, statusDevice) {
        const objDevice = JSON.parse(dataDevice);

        let isMobile;
        if( objDevice.mobile==true ) {
            isMobile = 1;
        } else {
            isMobile = 0;
        }

        var params = {};
        params['provider'] = provider;
        params['gcode'] = code;
        params['isMobile'] = isMobile;
        params['credit'] = $('header .userBalance').html();
        params['type'] = 1;

        $.post('/single-game/open', {
            params
        }, function(data, status) {
            const obj = JSON.parse(data);
            if( obj.code==1 ) {
                swal.close();
                refreshBalance();

                if( objDevice.mobile==true ) {
                    // window.open(obj.url, '_parent');
                    if( species==1 ) {
                        $('.modal-gameLobby').modal('toggle');
                        $('.modal-gameLobby .gamename').html(name);
                        $('.modal-gameLobby .btn-close').data('provider', params['provider']);
                    } else if( species==2 ) {
                        $('.modal-slotLobby').modal('toggle');
                        prompt(params['provider'], obj.url);
                    }
                    gameLobby(species, obj.url);
                } else {
                    window.open(obj.url, '_blank');
                }
            } else {
                swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
            }
        })
        .done(function() {
        })
        .fail(function() {
            swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
        });
    });
}

function singleGameLandingExpress(species, name, provider,code)
{
    if( logged )
    {
        expressSingleFloatLobby(species, name, provider,code);
    } else {
        alertToast('text-bg-dark', '<?=lang('Validation.loginaccount');?>');
    }
}

function singleGame(name,code,provider)
{
	generalLoading();

	$.get('/device/check', function(dataDevice, statusDevice) {
		const objDevice = JSON.parse(dataDevice);

        let isMobile;
        if( objDevice.mobile==true ) {
            isMobile = 1;
        } else {
            isMobile = 0;
        }

		var params = {};
		params['isMobile'] = isMobile;
		params['credit'] = $('.wallet-wrapper .userBalance').html();
		params['provider'] = provider;
		params['gcode'] = code;
		params['type'] = 1;

		$.post('/single-game/open', {
			params
		}, function(data, status) {
			const obj = JSON.parse(data);
			if( obj.code==1 ) {
				swal.close();
				getProfile();

				// $('.modal-singleGameLanding').modal('show');
				// $('.modal-singleGameLanding .btn-close').data('provider', provider);
				// $('.modal-singleGameLanding img').attr('src','<?//=$_ENV['gameProviderLogo'];?>/'+provider+'.png');

				if( objDevice.mobile==true ) {
					window.open(obj.url, '_parent');
				} else {
					window.open(obj.url, '_blank');
				}
			} else {
				swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
			}
		})
		.done(function() {
		})
		.fail(function() {
			swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
		});
	});
}

function refreshAndWithdrawGame()
{
	generalLoading();

	$.get('/refresh-credit/all', function(data, status) {
		const obj = JSON.parse(data);
		if( obj.code==1 ) {
			swal.close();
			getProfile();
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
// End Games

// Affiliate
function copyAffLink()
{
    // const affURL = '<?=$session ? $_SESSION['affiliate']:'';?>/' + btoa('<?=$session ? $_SESSION['token']:'';?>');
    const affURL = '<?=$session ? $_SESSION['affiliate']:'';?>/' + '<?=$session ? $_SESSION['username']:'';?>';
    $('.btn-copylink.allowed').attr('onclick', "copyRegUrl('" + affURL + "')");
}

function affiliateQR()
{
    // const affURL = '<?=$session ? $_SESSION['affiliate']:'';?>/' + btoa('<?=$session ? $_SESSION['token']:'';?>');
    const affURL = '<?=$session ? $_SESSION['affiliate']:'';?>/' + '<?=$session ? $_SESSION['username']:'';?>';

    var qcode = new QRCode(document.getElementById("qrcode"), {
        text: affURL,
        correctLevel: QRCode.CorrectLevel.H
    });

    $('.modal-affiliateQR .btn-qrreg').attr('onclick', "copyRegUrl('" + affURL + "')");
}

function copyRegUrl(url)
{
    swal.fire({
        title: 'Affiliate URL',
        text: url,  
        showCancelButton: true,
        confirmButtonText: 'Copy',
    })
    .then((value) => {
        if (value.isConfirmed) {
            var str = $('.swal2-html-container')[0].innerText;
            // console.log(str);
            navigator.clipboard.writeText(str);
        }
    });
}

function getScreen()
{
	html2canvas($(".modal-affiliateQR .qrcard"), {
        dpi: 1024,
        // scale: 4,
        logging: false,
        // width: 466,
        // height: 772,
        letterRendering: true,
        allowTaint: true,
        useCORS: false,
        foreignObjectRendering : true,
		onrendered: function(canvas) {
			$(".modal-affiliateQR .getscreen").attr('href', canvas.toDataURL("image/png").replace(/^data:image\/png/, "data:application/octet-stream"));
			$(".modal-affiliateQR .getscreen").attr('download', '<?=$_ENV['company'];?>.png');
			$(".modal-affiliateQR .getscreen")[0].click();
		}
	});
}
// End Affiliate

// Promotion
function claimPromo(promoId)
{
    var params = {};
    params['promotion'] = promoId;

    $.post('/payment/promotion-claim', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.fire("Success!", obj.message, "success").then(() => {
                // $('#bcTable').DataTable().ajax.reload(null,false);
            });
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
        });
    });
}

function getPromoReadOnly(id)
{
    $('.modal-promo').modal('toggle');

    generalLoading();
    
    var params = {};
    params['id'] = id;

    $.post('/promotion/read-only/get', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.close();
            $('.modal-promo .promo-title').html(obj.data.title);
            document.getElementsByClassName('promo-desc')[0].innerHTML = obj.data.content;
            document.getElementsByClassName('promo-banner')[0].setAttribute("src", obj.data.image);
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                $('.modal-promo').modal('hide');
            });
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
            $('.modal-promo').modal('hide');
        });
    });
}

function getPromo(promoId)
{
    $('.modal-promo').modal('toggle');

    generalLoading();

    var params = {};
    params['promoId'] = promoId;

    $.post('/promotion/get', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.close();
			$('.modal-promo .promo-title').html(obj.data.title);
            document.getElementsByClassName('promo-desc')[0].innerHTML = obj.data.content;
            document.getElementsByClassName('promo-banner')[0].setAttribute("src", obj.data.img);

			if( logged && obj.data.continueClaim==true ) {
				document.getElementsByClassName('modal-footer')[0].innerHTML = '<a class="btn apply-btn" onclick="claimPromo(\''+obj.data.id+'\');">APPLY NOW</a>';
			} else {
				document.getElementsByClassName('modal-footer')[0].innerHTML = '';
			}
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                $('.modal-promo').modal('hide');
            });
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
            $('.modal-promo').modal('hide');
        });
    });
}
// End Promotion

// Support
function getTutorial(id)
{
    $('.modal-tutorialBox').modal('toggle');

    generalLoading();
    
    var params = {};
    params['id'] = id;

    $.post('/instruction/get', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.close();
            $('.modal-tutorialBox .tutor-title').html(obj.data.title);
            document.getElementsByClassName('tutor-desc')[0].innerHTML = obj.data.content;
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error").then(() => {
                $('.modal-tutorialBox').modal('hide');
            });
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
            $('.modal-tutorialBox').modal('hide');
        });
    });
}

async function supportList()
{
    $.get('/list/support', function(data, status) {
        const obj = JSON.parse(data);
        const random = Math.floor(Math.random() * obj.data.length);
        const random2 = Math.floor(Math.random() * obj.data.length);
        if( obj.code==1 ) {
            if( obj.data!='' )
            {
                $('a.whatsapp').attr('href','https://wa.me/<?=$_ENV['mobileCode'];?>' + obj.data[random].whatsapp);
                $('a.whatsapp-forgotpass').attr('href','https://wa.me/<?=$_ENV['mobileCode'];?>' + obj.data[random].whatsapp + '?text=Forgot Password');
            } else {
                $('a.whatsapp').hide();
            }
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }

        userUplineContact();
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function whatsappRegisterList()
{
    $.get('/list/whatsapp/register', function(data, status) {
        const obj = JSON.parse(data);
        const random = Math.floor(Math.random() * obj.data.length);
        if( obj.code==1 ) {
            $('a.whatsapp-register').attr('href',"https://wa.me/<?=$_ENV['mobileCode'];?>" + obj.data[random].whatsapp + '?text=Register');
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

async function userUplineContact()
{
    $.get('/user/upline/contact', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            // $('a.whatsapp').attr('href','https://wa.me/6' + obj.whatsapp);
            //$('a.telegram').attr('href','https://t.me/' + obj.telegram);
            $('a.telegram').attr('href','https://' + obj.telegram);

            // $('a.whatsapp-forgotpass').attr('href','https://wa.me/6' + obj.whatsapp + '?text=Forgot Password');
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

function userUplineContact4BigJackpot(code)
{
    $.get('/user/upline/contact', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            var encodeText = 'UID: <?=$session ?  $_SESSION['token']:'';?>%0a';
            encodeText += '<?=lang('Input.password');?>: ' + code;

            $('a.whatsapp-jackpot').attr('href','https://wa.me/<?=$_ENV['mobileCode'];?>' + obj.whatsapp + '?text=' + encodeText);
        } else {
            // swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}
// End Support

// Jackpot
function playSound()
{
    var x = document.getElementById("audio");
    x.play();
}

function closeJackpot()
{
    document.getElementsByClassName('wrap-jackpot')[0].classList.remove('show');
}

function closeBigJackpot()
{
    document.getElementsByClassName('wrap-bigJackpot')[0].classList.remove('show','d-flex');
}

function jackportTrigger()
{
    $.get('/user/jackpot/trigger', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code == 1 ) {
            refreshBalance();
            playSound();
            
            if( obj.jackpotAmount==2999 ) {
                document.getElementsByClassName('wrap-bigJackpot')[0].classList.add('show','d-flex');
                $('.wrap-bigJackpot .jackpotAmount').html('<?=$_ENV['currency'];?> ' + obj.jackpotAmount);
                $('.wrap-bigJackpot .jackpotPass').html(obj.password);

                userUplineContact4BigJackpot(obj.password);

                $('.wrap-bigJackpot .img-bigjackpot').attr('src','<?=base_url('../assets/img/jackpot/jackpot_motor.gif');?>');
            } else if( obj.jackpotAmount==1999 ) {
                document.getElementsByClassName('wrap-bigJackpot')[0].classList.add('show','d-flex');
                $('.wrap-bigJackpot .jackpotAmount').html('<?=$_ENV['currency'];?> ' + obj.jackpotAmount);
                $('.wrap-bigJackpot .jackpotPass').html(obj.password);

                userUplineContact4BigJackpot(obj.password);

                $('.wrap-bigJackpot .img-bigjackpot').attr('src','<?=base_url('../assets/img/jackpot/jackpot_mobile.gif');?>');
            } else if( obj.jackpotAmount==999 ) {
                document.getElementsByClassName('wrap-bigJackpot')[0].classList.add('show','d-flex');
                $('.wrap-bigJackpot .jackpotAmount').html('<?=$_ENV['currency'];?> ' + obj.jackpotAmount);
                $('.wrap-bigJackpot .jackpotPass').html(obj.password);

                userUplineContact4BigJackpot(obj.password);

                $('.wrap-bigJackpot .img-bigjackpot').attr('src','<?=base_url('../assets/img/jackpot/jackpot_necklace.gif');?>');
            } else if( obj.jackpotAmount==299 ) {
                document.getElementsByClassName('wrap-bigJackpot')[0].classList.add('show','d-flex');
                $('.wrap-bigJackpot .jackpotAmount').html('<?=$_ENV['currency'];?> ' + obj.jackpotAmount);
                $('.wrap-bigJackpot .jackpotPass').html(obj.password);

                userUplineContact4BigJackpot(obj.password);

                $('.wrap-bigJackpot .img-bigjackpot').attr('src','<?=base_url('../assets/img/jackpot/jackpot_ring.gif');?>');
            } else {
                document.getElementsByClassName('wrap-jackpot')[0].classList.add('show');
                // $('.wrap-jackpot img').attr('src','<?=base_url('../assets/img/jackpot/'.$_SESSION['lang'].'/angpow.gif');?>');
                document.getElementsByClassName('jackpotAmount')[0].innerHTML = '<?=$_ENV['currency'];?> ' + obj.jackpotAmount;
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
    });
}

function runningBigJackpot(timer)
{
    $.get('/user/jackpot/running-big-prize', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code == 1 ) {
            // if( obj.getJackpot==true && obj.type==5 ) {
            //     playSound();
            //     document.getElementsByClassName('wrap-bigJackpot')[0].classList.add('show','d-flex');
            //     $('.wrap-bigJackpot .jackpotAmount').html('<?=$_ENV['currency'];?> ' + obj.jackpotAmount);
            //     $('.wrap-bigJackpot .jackpotPass').html(obj.password);

            //     userUplineContact4BigJackpot(obj.password);

            //     // if( obj.jackpotAmount==2999 ) {
            //     //     $('.wrap-bigJackpot .img-bigjackpot').attr('src','<?//=base_url('../assets/img/jackpot/jackpot_motor.gif');?>');
            //     // } else if( obj.jackpotAmount==1999 ) {
            //     //     $('.wrap-bigJackpot .img-bigjackpot').attr('src','<?//=base_url('../assets/img/jackpot/jackpot_mobile.gif');?>');
            //     // } else if( obj.jackpotAmount==999 ) {
            //     //     $('.wrap-bigJackpot .img-bigjackpot').attr('src','<?//=base_url('../assets/img/jackpot/jackpot_necklace.gif');?>');
            //     // } else {
            //         $('.wrap-bigJackpot .img-bigjackpot').attr('src','<?//=base_url('../assets/img/jackpot/jackpot_default.gif');?>');
            //     // }
            // } else if( obj.getJackpot==true && obj.type!=5 ) {
            //     // let bigJackpotStatus = $(".wrap-bigJackpot").hasClass('show');
            //     // if( bigJackpotStatus==true ) {
            //     //     closeBigJackpot();
            //     //     var sound = document.getElementById("audio");
            //     //     sound.pause();
            //     //     sound.currentTime = 0;
            //     // }
            //     jackportTrigger();
            // }

            if( obj.getJackpot==true )
            {
                jackportTrigger();
            }
        } else if( obj.code==39 ) {
            forceUserLogout();
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
        refreshIncoming(timer);
    })
    .fail(function() {
    });
}

function runningJackpot()
{
    $.get('/user/jackpot/running-count', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code == 1 ) {
            if( obj.type!=5 && obj.getJackpot==true ) {
                jackportTrigger();
            } else if( obj.type==5 && obj.getJackpot==true ) {
                runningBigJackpot(60);
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
    });
}

if( logged )
{
    var schedule;
    function refreshIncoming(timer)
    {
        refresh = timer * 1000;
        schedule = setTimeout(function() {
            runningBigJackpot(timer);
        }, refresh);
    }
    function startRefresh()
    {
        clearTimeout(schedule);
        refreshIncoming(60);
    }
    startRefresh();
}
// End Jackpot

// SMS Tac
function requestSmsTac(dom)
{
    generalLoading();

    const contact = $('.'+dom+' [name=mobile]').val();
    const mobilecode = $('.'+dom+' [name=regionCode]').val();

    if( contact=='' ) {
        swal.fire("Error!", "<?=lang('Validation.mobile',[8,11]);?>", "warning");
        return false;
    } else {
        $('.'+dom+' [name=mobile]').prop('readonly', true);
        var pass = Math.floor(100 + Math.random() * 900000);
        //smsTAC(contact,pass);
        whatsappTAC(contact,pass,mobilecode);
    }
}

// SMS Tac
function requestSmsTac2(dom)
{
    //generalLoading();

    const contact = $('.'+dom+' [name=mobile]').val();
    const mobilecode = $('.'+dom+' [name=regionCode]').val();

    if( contact=='' ) {
        swal.fire("Error!", "<?=lang('Validation.mobile',[8,11]);?>", "warning");
        return false;
    } else {
        $('.'+dom+' [name=mobile]').prop('readonly', true);
        var pass = Math.floor(100 + Math.random() * 900000);

        //Disable Get Tac Button
        $('.btn-tac').prop('disabled', true);

        smsTAC(contact,pass,mobilecode);
        //whatsappTAC(contact,pass,mobilecode);
    }
}

function sendSMS(mobile,pass)
{
    var params = {};
    params['contact'] = mobile;
    params['message'] = '[<?=$_ENV['company'];?>]---' + pass + '---';

    $.post('/sms/send', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.fire("Success!", obj.message, "success");
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error").then(()=>{
        });
    });
}

function whatsappTAC(contact,pass,mobilecode)
{
    //let content = '[<?//=$_ENV['company'];?>]--' + pass + '--';

    var params = {};
    params['contact'] = contact;
    //params['message'] = content;
    params['veritac'] = pass;
    params['mobilecode'] = mobilecode;

    $.post('/whatsapp/send-tac', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.close();
            timer();
        } else if( obj.code==39 ) {
            forceUserLogout();
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    });
}

function smsTAC(contact,pass,mobilecode)
{
    //let content = '[<?=$_ENV['company'];?>]--' + pass + '--';

    var params = {};
    params['mobilecode'] = mobilecode;
    params['contact'] = contact;
    //params['message'] = content;
    params['veritac'] = pass;

    $.post('/sms/send-tac', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            timer();
        } else if( obj.code==39 ) {
            forceUserLogout();
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
            $('.btn-tac').prop('disabled', false);
        }
    });
}

function timer()
{
    //$('.btn-tac').prop('disabled', true);

    var seconds = 120;
    var countdown = setInterval(function() {
        seconds--;
        document.getElementById("timer").textContent = seconds;
        if (seconds <= 0) {
            clearInterval(countdown);
            document.getElementById("timer").textContent = 'Get TAC';
            $('.btn-tac').prop('disabled', false);
            // timer();
        }
    }, 1000);
}
// End SMS Tac

function getProfile()
{
    // $.get('/user-profile', function(data, status) {
    //     const obj = JSON.parse(data);
    //     if( obj.code == 1 ) {
            refreshBalance();
    //         if( obj.data.jackpot==true ) {
    //             jackportTrigger();
    //         }
    //     } else if( obj.code==39 ) {
    //         forceUserLogout();
    //     } else {
    //         swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
    //     }
    // })
    // .done(function() {
    // })
    // .fail(function() {
    // });
}

function announcementList()
{
    var annExist = document.getElementById("annlist");

    $.get('/list/announcement/all', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code == 1 ) {
            if( obj.data!='' ) {
                const msg = obj.data;
                msg.forEach( (item, index) => {
                    var node = document.createElement("span");
                    node.innerHTML = item.content;

                    if( !!annExist ) {
                        document.getElementById("annlist").appendChild(node);
                    }
                });
            } else {
                let str = '<span>Enjoy gaming with <?=$_ENV['company'];?> even more! Asia Most Trusted Platform. Play Safe, Play me!</span>';

                if( !!annExist ) {
                    document.getElementById("annlist").innerHTML = str;
                }
            }
        } else if( obj.code==39 ) {
            forceUserLogout();
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }

        $('.marquee').marquee({
		duration:12000,
		gap:0,
		delayBeforeStart:-5000,
		direction: 'left',
		duplicated: true,
		pauseOnHover:true
	});
    })
    .done(function() {
    })
    .fail(function() {
    });
}

function getBankList(element)
{
    $.get('/list/bank', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            const bank = obj.data;
            bank.forEach(function(item, index) {
                var node = document.createElement("option");
                var textnode = document.createTextNode(item.name);
                node.setAttribute("value", item.bank);
                node.appendChild(textnode);
                document.getElementById(element).appendChild(node);
            });
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

function airdatepicker()
{
    $('[name=start]').datepicker({
        autoClose: true,
        changeMonth: true,
        changeYear: true,
        language: '<?=$_SESSION['lang']=='cn' || $_SESSION['lang']=='zh' ? 'zh' : 'en'?>',
        dateFormat: 'yyyy-mm-dd',
        maxDate: new Date(),
        todayButton: new Date(),
        clearButton: true
    });
    $('[name=end]').datepicker({
        autoClose: true,
        changeMonth: true,
        changeYear: true,
        language: '<?=$_SESSION['lang']=='cn' || $_SESSION['lang']=='zh' ? 'zh' : 'en'?>',
        dateFormat: 'yyyy-mm-dd',
        maxDate: new Date(),
        todayButton: new Date(),
        clearButton: true
    });

    $('[name=dob]').datepicker({
        autoClose: true,
        changeMonth: true,
        changeYear: true,
        language: '<?=$_SESSION['lang']=='cn' || $_SESSION['lang']=='zh' ? 'zh' : 'en'?>',
        dateFormat: 'yyyy-mm-dd',
        clearButton: true
    });
}

function generalLoading()
{
    swal.fire({
        showConfirmButton: false,
        allowOutsideClick: false,
		allowEscapeKey: false,
        imageUrl: '<?=base_url('../assets/img/loading.gif?v='.rand());?>',
        imageAlt: '<?=$_ENV['company'];?>',
        background: 'transparent'
	});
}

function getCompanyCDM(element) {
    generalLoading();

    $.get('/list/bank-account/company', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.data=='' ) {
            document.getElementById(element).innerHTML = '';
        }

        if( obj.code==1 && obj.data!='' ) {
            const bankCard = obj.data;
            var nodeLast = document.createElement("option");
            var textnodeLast = document.createTextNode('<?=lang('Label.selectbank');?>');
            nodeLast.setAttribute("value", '');
            nodeLast.appendChild(textnodeLast);
            document.getElementById(element).appendChild(nodeLast);

            bankCard.forEach(function(item, index) {
                var node = document.createElement("option");
                var textnode = document.createTextNode(item.name);
                node.setAttribute("value", item.bank);
                node.setAttribute("data-html", true);
                node.setAttribute("data-currency", item.currency);
                node.setAttribute("data-cardno", item.cardno);
                node.setAttribute("data-accno", item.accno);
                node.setAttribute("data-holder", item.holder);
                node.setAttribute("data-remark", item.remark);
                node.setAttribute("data-mindep", item.minDeposit);
                node.setAttribute("data-maxdep", item.maxDeposit);
                node.setAttribute("data-qrimg", item.qrCodeUrl);
                node.appendChild(textnode);
                document.getElementById(element).appendChild(node);
            });
        } else {
            // swal.fire("<?//=lang('Label.error');?>!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
        swal.close();
    })
    .fail(function() {
        // swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}
</script>