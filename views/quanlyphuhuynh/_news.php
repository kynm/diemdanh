    <?php if (1):?>
<!-- <div class="callout callout-info">
<h4>THÔNG BÁO</h4>
<p>Add the layout-top-nav class to the body tag to get this layout. This feature can also be used with a
sidebar! So use this class if you want to remove the custom dropdown menus from the navbar and use regular
links instead.</p>
</div> -->
<h3>Tin tức</h3>
<?php foreach ($dstintuc as $key => $tintuc):?>
    <div class="callout callout-danger">
        <h4><?= $tintuc->TITLE?></h4>
        <p><?= nl2br($tintuc->CONTENT)?></p>
    </div>
<?php endforeach; ?>
    <?php endif;?>
