<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Countries</h1>
<ul>
<?php foreach ($data as $baoduong): ?>
    <?php
    ?>
    <ul>
        <li style="color: red;"><?= Html::encode("{$baoduong['ThongTinTram']->TEN_TRAM}") ?>----------------------------------</li>
        <?php foreach ($baoduong['DS_DotBaoDuong'] as $dotbaodung): ?>
        	
            <li>
                        <?php 

                        // var_dump($dotbaodung);
                        ?>
                <?= Html::encode("{$dotbaodung['MA_DOTBD']} - {$dotbaodung['NGAY_KT']}") ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>
</ul>
