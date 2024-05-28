<div class="user-sidebar tabNav d-h5-none">
    <div class="user-info">
        <img src="../assets/img/user/avatar.png" alt="Avatar" loading="lazy">
        <p class="text-primary"><?=$_SESSION['username'];?></p>
    </div>
    <hr/>
    <h6><?=strtoupper(lang('Label.banking'));?></h6>
    <div class="user-nav">
        <a data-page="deposit" href="<?=base_url('deposit');?>"><?=lang('Nav.deposit');?></a>
        <a data-page="withdrawal" href="<?=base_url('withdrawal');?>"><?=lang('Nav.withdrawal');?></a>
        <a data-page="history" href="<?=base_url('transaction/history');?>"><?=lang('Nav.history');?></a>
        <a data-page="commission" href="<?=base_url('user-commission');?>"><?=lang('Nav.commlist');?></a>
    </div>
    <hr/>
    <h6><?=strtoupper(lang('Label.uprofile'));?></h6>
    <div class="user-nav">
        <a data-page="password" href="<?=base_url('user-password');?>"><?=lang('Nav.password');?></a>
        <a data-page="bankaccount" href="<?=base_url('user/bank-account');?>"><?=lang('Nav.bankingdetails');?></a>
        <a data-page="message" href="<?=base_url('message');?>"><?=lang('Nav.message');?></a>
    </div>
</div>