<?php

namespace app\controllers;

use Yii;
use app\models\Noidungbaotrinhomtbi;
use app\models\ProfileBaoduongNoidung;
use app\models\ProfileBaoduong;
use app\models\ProfileBaoduongSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileBaoduongController implements the CRUD actions for ProfileBaoduong model.
 */
class ProfileBaoduongController extends Controller
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
     * Lists all ProfileBaoduong models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileBaoduongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProfileBaoduong model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProfileBaoduong model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProfileBaoduong();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionChon()
    {
        $noidungs = Noidungbaotrinhomtbi::findAll(['ID_NHOM' => 13]);
        foreach ($noidungs as $noidung) {
            $model = new ProfileBaoduongNoidung;
            $model->MA_NOIDUNG = $noidung->MA_NOIDUNG;
                    $model->ID_PROFILE = 3;
            // $model->save();
        }

    }

    /**
     * Updates an existing ProfileBaoduong model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProfileBaoduong model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionGanNoiDung($id)
    {
        $query = Yii::$app->db->createCommand("
            SELECT `noidungbaotrinhomtbi`.`ID_NHOM`, `nhomtbi`.`TEN_NHOM`, `noidungbaotrinhomtbi`.`MA_NOIDUNG`, `NOIDUNG`, `pn`.`ID_PROFILE`
            FROM `noidungbaotrinhomtbi` 
            JOIN `nhomtbi` ON `noidungbaotrinhomtbi`.`ID_NHOM` = `nhomtbi`.`ID_NHOM`
            LEFT JOIN (
                SELECT * FROM `profile_baoduong_noidung` 
                WHERE `ID_PROFILE` = :id
            ) AS `pn` 
            ON `noidungbaotrinhomtbi`.MA_NOIDUNG = `pn`.MA_NOIDUNG",
            [':id' => $id]);
        $array = $query->queryAll();

        foreach ($array as $index => $element) {
            $result[$element['ID_NHOM']]['TEN_NHOM'] = $element['TEN_NHOM'];
            $result[$element['ID_NHOM']]['DS_ND'][] = $element;
        }

        return $this->render('gannoidung', [
            'result' => $result,
        ]);
    }

    /**
     * Deletes an existing ProfileBaoduong model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProfileBaoduong model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProfileBaoduong the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProfileBaoduong::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
