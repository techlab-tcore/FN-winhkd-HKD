<div class="user-account">
    <div class="account-top">
        <div>
            <p><?=lang('Label.regdate');?></p>
            <p class="registerDate"></p>
        </div>
        <div>
            <!-- <p><?=lang('Label.perdepositlimit');?></p>
            <p><?=$_ENV['currencyCode'];?> 1,000,000.00</p> -->
            <!-- <p><?=lang('Nav.downline');?></p>
            <p class="affiliateDirect"></p> -->
        </div>
        <div>
            <!-- <p><?=lang('Label.dailywithdrawallimit');?></p>
            <p><?=$_ENV['currencyCode'];?> 1,000,000.00</p> -->
            <!-- <p><?=lang('Nav.affdownline');?></p>
            <p class="affiliateDownline"></p> -->
        </div>
        <div>
            <a class="btn btn-copylink allowed"><?=lang('Nav.letshare');?></a>
        </div>
    </div>
    <div class="account-bottom">
        <div>
            <p><?=lang('Label.chipbalance');?></p>
            <p class="text-primary userChip">0</p>
        </div>
        <div>
            <!-- <p><?=lang('Label.vaultbalance');?></p>
            <p class="text-primary vaultBalance">0</p> -->
        </div>
        <div>
            <!-- <p><?=lang('Label.perdepositlimit');?></p>
            <p class="text-primary"><?=$_ENV['currencyCode'];?> 1,000,000.00</p> -->
        </div>
        <div>
            <a href="javascript:void(0);" onclick="refreshAndWithdrawGame();" class="btn"><?=lang('Nav.restore');?></a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    copyAffLink();
    //affiliateProfile();
});
</script>