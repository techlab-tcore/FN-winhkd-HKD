<header>
    <div class="d-h5-none">
        <div class="header-top fixed-top">
            <div class="container-full">
                <div class="header-time"><span id="timeShow"></span></div>
                <?php if( !isset($_SESSION['logged_in']) ): ?>
                <div class="header-login">
                    <a href="<?=base_url('forgot-password');?>" class="text-link"><?=lang('Nav.forgotpass');?>?</a>
                    <?=form_open('', ['class'=>'form-validation loginForm','novalidate'=>'novalidate']);?>
                        <input type="text" pattern="^[a-zA-Z0-9]{6,12}$" name="username" id="username" placeholder="<?=lang('Input.username');?>">
                        <input type="password" pattern="^[a-zA-Z0-9]{6,}$" name="password" id="password" placeholder="<?=lang('Input.password');?>">
                        <input type="checkbox" value="isRememberMe" id="rememberMe">
                        <label for="rememberMe"><?=lang('Label.rememberme');?></label>
                        <input type="submit" value="<?=strtoupper(lang('Nav.login'));?>" class="btn-outline" onclick="isRememberMe();">
                        <a href="<?=base_url('create-account');?>" class="btn"><?=strtoupper(lang('Nav.join'));?></a>
                    <?=form_close();?>
                </div>
                <?php endif; ?>
                <?php if( isset($_SESSION['logged_in']) ): ?>
                <div class="header-login logged-in">
                    <p><?=$_ENV['currencyCode'];?> </p><p class="text-primary userBalance"></p>
                    <a onclick="refreshAndWithdrawGame();"><i class="icon-refresh"></i></a>
                    <div class="header-quicklink">
                        <div class="header-username" id="quicklinkBtn"><?=$_SESSION['username'];?><i class="icon-chevron-down"></i></div>
                        <div id="quicklinkDropdown" class="quicklink-dropdown">
                            <a href="<?=base_url('deposit');?>"><?=lang('Nav.deposit');?></a>
                            <a href="<?=base_url('withdrawal');?>"><?=lang('Nav.withdrawal');?></a>
                            <a href="<?=base_url('transaction/history');?>"><?=lang('Nav.history');?></a>
                            <a href="<?=base_url('user-commission');?>"><?=lang('Nav.commlist');?></a>
                            <a href="<?=base_url('user-password');?>"><?=lang('Nav.password');?></a>
                            <a href="<?=base_url('user/bank-account');?>"><?=lang('Nav.bankingdetails');?></a>
                            <a href="<?=base_url('message');?>"><?=lang('Nav.message');?></a>
                        </div>
                    </div>		
                    <a href="<?=base_url('deposit');?>" class="btn"><?=strtoupper(lang('Nav.deposit'));?></a>
                    <a href="<?=base_url('user/logout');?>" class="btn-outline"><?=strtoupper(lang('Nav.logout'));?></a>
                </div>
                <?php endif; ?>
                <div class="header-lang">
                    <div class="lang-cur langSwitcher">
                        <img src="../assets/img/lang/<?=$_SESSION['lang'];?>.png" alt="<?=$_SESSION['lang'];?>">
                        <span><?=strtoupper($_SESSION['lang']);?></span>
                        <i class="icon-chevron-down"></i>
                    </div>
                    <div class="lang-dropdown langDropdown">
                        <div>
                            <img src="../assets/img/lang/<?=$_SESSION['lang'];?>.png" alt="<?=$_SESSION['lang'];?>">
                            <div class="lang-selection">
                                <a onclick="translation('zh')">繁体中文</a>
                                <a onclick="translation('cn')">简体中文</a>
                                <a onclick="translation('en')">ENGLISH</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="header-h5 d-lg-none">
        <div class="header-top container flex-title">
            <div class="flex-left">
                <i id="hamburger" class="ico-hamburger"></i>
            </div>
            <div class="flex-center h5-logo">
                <a href="<?=base_url('/');?>">
                    <img src="../assets/img/logo/logo.png" alt="Logo">
                </a>
            </div>
            <div class="flex-right">
                <div class="header-lang">
                    <div class="lang-cur langSwitcher">
                        <img src="../assets/img/lang/<?=$_SESSION['lang'];?>.png" alt="<?=$_SESSION['lang'];?>">
                    </div>
                    <div class="lang-dropdown langDropdown">
                        <a onclick="translation('zh')">
                            <img src="../assets/img/lang/zh.png" alt="繁体中文">
                        </a>
                        <a onclick="translation('cn')">
                            <img src="../assets/img/lang/cn.png" alt="简体中文">
                        </a>
                        <a onclick="translation('en')">
                            <img src="../assets/img/lang/en.png" alt="ENGLISH">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php if( !isset($_SESSION['logged_in']) ): ?>
        <div class="header-bottom container">
            <div class="btn-wrap">
                <a class="btn-outline" data-bs-toggle="modal" data-bs-target="#loginModal"><?=strtoupper(lang('Nav.login'));?></a>
                <a href="<?=base_url('create-account');?>" class="btn"><?=strtoupper(lang('Nav.join'));?></a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</header>
<div class="header-sticky d-h5-none">
    <div class="container-full flex-title">
        <div class="logo">
            <a href="<?=base_url('/');?>">
                <img src="../assets/img/logo/logo.png" alt="Logo">
            </a>
        </div>
        <nav class="flex-center">
            <ul class="header-nav">
                <li data-page="home">
                    <a href="<?=base_url('/');?>">
                        <i class="icon-home"></i>
                        <span><?=strtoupper(lang('Nav.home'));?></span>
                    </a>
                </li>
                <li data-page="slot">
                    <a href="<?=base_url('slot');?>">
                        <i class="icon-slot"></i>
                        <span><?=strtoupper(lang('Nav.slot'));?></span>
                    </a>
                    <div class="dropdown-content">
                        <div class="container clearfix">
                            <div id="grid-slot-menu" class="slick-slider">
                            </div>
                        </div>
                    </div>
                </li>
                <li data-page="casino">
                    <a href="<?=base_url('casino');?>">
                        <i class="icon-poker"></i>
                        <span><?=strtoupper(lang('Nav.casino'));?></span>
                    </a>
                    <div class="dropdown-content">
                        <div class="container clearfix">
                            <div id="grid-casino-menu" class="slick-slider">
                            </div>
                        </div>
                    </div>
                </li>
                <li data-page="sport">
                    <a href="<?=base_url('sport');?>">
                        <i class="icon-ball"></i>
                        <span><?=strtoupper(lang('Nav.sport'));?></span>
                    </a>
                    <div class="dropdown-content">
                        <div class="container clearfix">
                            <div id="grid-sport-menu" class="slick-slider">
                            </div>
                        </div>
                    </div>
                </li>
                <li data-page="fishing">
                    <a href="<?=base_url('fishing');?>">
                        <i class="icon-fish-solid"></i>
                        <span><?=strtoupper(lang('Nav.fishing'));?></span>
                    </a>
                    <div class="dropdown-content">
                        <div class="container clearfix">
                            <div id="grid-fishing-menu" class="slick-slider">
                            </div>
                        </div>
                    </div>
                </li>
                <!-- <li data-page="lottery">
                    <a href="<?=base_url('lottery');?>">
                        <i class="icon-lottery"></i>
                        <span><?=strtoupper(lang('Nav.lottery'));?></span>
                    </a>
                    <div class="dropdown-content">
                        <div class="container clearfix">
                            <div id="grid-lottery-menu" class="slick-slider">
                            </div>
                        </div>
                    </div>
                </li> -->
                <li data-page="promo">
                    <a href="<?=base_url('promotions');?>">
                        <i class="icon-promo"></i>
                        <span><?=strtoupper(lang('Nav.promo'));?></span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="flex-right">
        </div>
    </div>
</div>
<div id="offcanvas" class="offcanvas-wrap">
    <a href="<?=base_url('/');?>"><?=strtoupper(lang('Nav.home'));?></a>
    <a href="<?=base_url('promotions');?>"><?=strtoupper(lang('Nav.promo'));?></a>
    <?php if( isset($_SESSION['logged_in']) ): ?>
    <a href="<?=base_url('deposit');?>"><?=strtoupper(lang('Nav.deposit'));?></a>
    <a href="<?=base_url('withdrawal');?>"><?=strtoupper(lang('Nav.withdrawal'));?></a>
    <a href="<?=base_url('transaction/history');?>"><?=strtoupper(lang('Nav.history'));?></a>
    <a href="<?=base_url('user-commission');?>"><?=strtoupper(lang('Nav.commlist'));?></a>
    <a href="<?=base_url('user-password');?>"><?=strtoupper(lang('Nav.password'));?></a>
    <a href="<?=base_url('user/bank-account');?>"><?=strtoupper(lang('Nav.bankacc'));?></a>
    <a class="border-bottom" href="<?=base_url('message');?>"><?=strtoupper(lang('Nav.message'));?></a>
    <?php endif; ?>
    <a href="<?=base_url('sport');?>"><?=strtoupper(lang('Nav.sport'));?></a>
    <a href="<?=base_url('casino');?>"><?=strtoupper(lang('Nav.casino'));?></a>
    <a href="<?=base_url('slot');?>"><?=strtoupper(lang('Nav.slot'));?></a>
    <!-- <a href="<?=base_url('lottery');?>"><?=strtoupper(lang('Nav.lottery'));?></a> -->
    <?php if( isset($_SESSION['logged_in']) ): ?>
    <a href="<?=base_url('user/logout');?>" class="border-top border-bottom"><?=strtoupper(lang('Nav.logout'));?></a>
    <?php endif; ?>
</div>
<div class="h5-tabbar d-lg-none">
    <a data-page="games" href="<?=base_url('');?>"><i class="icon-games"></i><span><?=lang('Nav.games');?></span></a>
    <?php if( isset($_SESSION['logged_in']) ): ?>
        <a data-page="funds" href="<?=base_url('deposit');?>"><i class="icon-funds"></i><span><?=lang('Nav.fund');?></span></a>
        <a data-page="account" href="<?=base_url('user/bank-account');?>"><i class="icon-account"></i><span><?=lang('Nav.account');?></span></a>
    <?php else: ?>
        <a data-page="funds" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="icon-funds"></i><span><?=lang('Nav.fund');?></span></a>
        <a data-page="account" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="icon-account"></i><span><?=lang('Nav.account');?></span></a>
    <?php endif; ?>
    <a data-page="promo" href="<?=base_url('promotions');?>"><i class="icon-promo"></i><span><?=lang('Nav.promo');?></span></a>
    <a data-page="livechat" onclick="LC_API.open_chat_window();return false;"><i class="icon-livechat"></i><span><?=lang('Nav.livechat');?></span></a>
</div>	
<div class="modal fade modal-login" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?=lang('Nav.login');?></h3>
                <a class="modal-close icon-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <?=form_open('', ['class'=>'form-validation loginForm','novalidate'=>'novalidate']);?>
                    <div class="form-div">
                        <label class="form-label"><?=lang('Input.username');?></label>
                        <input class="form-control" type="text" pattern="^[a-zA-Z0-9]{6,12}$" name="username" id="username" placeholder="<?=lang('Sentence.enterusername');?>">
                        <p class="input-desc"><?=lang('Validation.username');?></p>
                    </div>
                    <div class="form-div">
                        <label class="form-label"><?=lang('Input.password');?></label>
                        <input class="form-control error" type="password" pattern="^[a-zA-Z0-9]{6,}$" name="password" id="password" placeholder="<?=lang('Sentence.enterpassword');?>">
                        <p class="input-desc error"><?=lang('Validation.password');?></p>
                    </div>
                    <div class="form-div-checkbox">
                        <input type="checkbox" class="form-check-input">
                        <span><?=lang('Label.rememberme');?></span>
                    </div>
                    <input type="submit" class="btn w-100" value="<?=lang('Nav.login');?>">
                <?=form_close();?>
                <p><a class="text-link" href="<?=base_url('forgot-password');?>"><?=lang('Nav.forgotpass');?>?</a></p>
                <br/>
                <p><?=lang('Sentence.donthvacc');?> <a class="text-link" href="<?=base_url('create-account');?>"><?=lang('Sentence.createacc');?></a></p>
                <hr/>
                <p><?=lang('Sentence.encloginissue');?></p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.loginForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.loginForm [type=submit]').prop('disabled', true);

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });

            $.post('/user/login', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    window.location.replace("<?=base_url();?>");
                    // checkIfEmptyBankAccount(1);
                } else {
                    swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                }
            })
            .done(function() {
                $('.loginForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                $('.loginForm [type=submit]').prop('disabled', false);
                swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
            });
        }
    });
});

const rmCheck = document.getElementById("rememberMe"),
usernameInput = document.getElementById("username");

if (localStorage.checkbox && localStorage.checkbox !== "") {
    rmCheck.setAttribute("checked", "checked");
    usernameInput.value = localStorage.username;
} else {
    if (rmCheck)
    {
        rmCheck.removeAttribute("checked");
    }
    
    if (usernameInput)
    {
        usernameInput.value = "";
    }
}

function isRememberMe()
{
    if (rmCheck.checked && usernameInput.value !== "") {
        localStorage.username = usernameInput.value;
        localStorage.checkbox = rmCheck.value;
    } else {
        localStorage.username = "";
        localStorage.checkbox = "";
    }
}
</script>
