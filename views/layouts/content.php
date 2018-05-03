<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <span class="pull-right" ><b>Phiên bản</b> 0.1</span>
    </div>
    <strong><a>VNPT QUẢNG NAM, TRUNG TÂM CNTT</a> &copy; <?= date('Y', time()); ?></strong>
    <br>
    Địa chỉ: 02A, Phan Bội Châu, p. Tân Thạnh, tp. Tam Kỳ, Quảng Nam 
    <br>
    Điện thoại hỗ trợ : <a href='tel:02353812119'  style='color:#444;'><i class='fa fa-phone-square'></i> 0235.3 812 119</a>
</footer>