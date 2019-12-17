<?php

namespace app\controllers;

use Yii;
use app\models\ProfileBaoduongNoidung;
use app\models\ProfileBaoduongNoidungSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileBaoduongNoidungController implements the CRUD actions for ProfileBaoduongNoidung model.
 */
class ProfileBaoduongNoidungController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProfileBaoduongNoidung models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileBaoduongNoidungSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ProfileBaoduongNoidung model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAssign($id)
    {
        if (Yii::$app->getRequest()->post()) {
            $items = Yii::$app->getRequest()->post('items', []);
            foreach ($items as $item) {
                $model = new ProfileBaoduongNoidung($id);
                $model->MA_NOIDUNG = $item;
                $model->save();    
            }
        }
        return true;
    }

    /**
     * Deletes an existing ProfileBaoduongNoidung model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID_PROFILE
     * @param string $MA_NOIDUNG
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID_PROFILE, $MA_NOIDUNG)
    {
        $this->findModel($ID_PROFILE, $MA_NOIDUNG)->delete();

        return true;
    }

    /**
     * Finds the ProfileBaoduongNoidung model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_PROFILE
     * @param string $MA_NOIDUNG
     * @return ProfileBaoduongNoidung the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_PROFILE, $MA_NOIDUNG)
    {
        if (($model = ProfileBaoduongNoidung::findOne(['ID_PROFILE' => $ID_PROFILE, 'MA_NOIDUNG' => $MA_NOIDUNG])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
