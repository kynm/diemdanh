<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use DateTime;
use yii\console\Controller;
use app\models\User;
use app\models\Nhanvien;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LenlichController extends Controller
{
    /*
     * Copy email
     * Remove @vnpt.vn after username at user and nhanvien
     */
    public function actionEditEmail()
    {
        $listNhanvien = Nhanvien::find()->all();
        
    }
}
