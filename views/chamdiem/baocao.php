<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'BÁO CÁO CHẤM ĐIỂM';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('/lophoc/_detail', ['model' => $lophoc,]) ?>
</div>
<?= $this->render('/partial/_chamdiem', ['model' => $lophoc]) ?>
<div class="box-body table-responsive">
    </h2>
    <div class="col-lg-12 col-12">
        <table class="table table-bordered">
            <tbody>
                <tr class="bg-primary text-center">
                    <th class="text-center">HỌ TÊN</th>
                    <?php foreach ($header as $key => $value):?>
                        <th class="text-center"><?= $value?></th>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($rows as $a => $row):
                ?>
                    <tr class="">
                        <td><?= $row['HO_TEN']?></td>
                        <?php foreach ($header as $b => $h):
                        ?>
                            <td class="text-center"><?= isset($row['DIEM'][$b]['DIEM']) ? $row['DIEM'][$b]['DIEM'] : null?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
