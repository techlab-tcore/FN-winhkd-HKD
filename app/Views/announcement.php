<div class="container">
    <div class="notice">
        <i class="icon-sound"></i>
        <div class="marquee-wrap">
        <?php if( isset($_SESSION['logged_in']) ): ?>
            <div class="marquee" id="annlist">
            </div>
        <?php else: ?>
            <div class="marquee">
                <span><?=lang('Sentence.announcement');?></span>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>