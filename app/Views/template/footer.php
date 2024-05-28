<footer>
    <div class="footer-top">
        <div class="container-full">
            <div class="footer-logo">
                <img src="../assets/img/logo/logo.png" alt="Logo">
            </div>
            <div class="footer-social">
                <img src="../assets/img/footer/provider/cp.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/pgs.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/fc.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/jkr.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/l4.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/dgs.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/uus.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/avp.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/sg.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/gfg.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/ka.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/peg.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/ac3.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/aaa.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/cq9.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/prg.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/jdb.png" alt="<?=$_ENV['company'];?>">
                <img src="../assets/img/footer/provider/xe8.png" alt="<?=$_ENV['company'];?>">
            </div>
        </div>
    </div>
    <div class="container-h5">
        <div class="footer-partners">
            <img src="../assets/img/footer/18plus.png" alt="18+">
            <img src="../assets/img/footer/curacao.png" alt="Curacao">
            <img src="../assets/img/footer/mga.png" alt="MGA">
            <img src="../assets/img/footer/gambleaware.png" alt="Gambleaware">
            <img src="../assets/img/footer/gamingcommission.png" alt="Gaming Commission">
        </div>
        <div class="footer-bottom">
            <div class="footer-links">
                <a href="<?=base_url('help');?>?show=about"><?=lang('Label.aboutus');?></a>
                <a href="<?=base_url('help');?>?show=terms"><?=lang('Label.tnc');?></a>
                <a href="<?=base_url('help');?>?show=faq"><?=lang('Label.faq');?></a>
                <!-- <a href="<?=base_url('help');?>?show=contact"><?=lang('Label.contactus');?></a> -->
            </div>
            <p class="footer-copyright">Copyright © 2024 <?=$_ENV['company'];?>. All right reserved.</p>
        </div>
    </div>
</footer>
	
<div class="side-right">
    <a onclick="LC_API.open_chat_window();return false;">
        <img src="../assets/img/btn_livechat.svg" alt="Live Chat">
        <span><?=lang('Nav.livechat');?></span>
    </a>
    <a id="toTop" href="javascript:void(0)" onclick="backToTop()" class="side-top">
        <img src="../assets/img/btn_top.svg" alt="Back To Top">
        <span>Back To Top</span>
    </a>
</div>