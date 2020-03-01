<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Countries</h1>
<ul>
<?php foreach ($data as $baoduong): ?>
    <ul>
        <li style="color: red;"><?= Html::encode("{$baoduong['ThongTinTram']->TEN_TRAM}") ?>----------------------------------</li>
        <?php foreach ($baoduong['DS_DotBaoDuong'] as $dotbaodung): ?>
        	
            <li>
                <?= Html::encode("{$dotbaodung->MA_DOTBD} ({$dotbaodung->ID_NHANVIEN})") ?>
                <ul>
                <?php foreach ($dotbaodung['noidungcongviecs'] as $congviec): ?>
                	<li>
                		<?php var_dump($congviec);?>
                	<?= Html::encode("{$congviec->ID_DOTBD} ({$congviec->ID_THIETBI})") ?>: <?= Html::encode("{$congviec->MA_NOIDUNG} ({$congviec->GHICHU})") ?>
                	</li>
                <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>
</ul>
