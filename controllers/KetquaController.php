<?php

namespace app\controllers;

use Yii;
use app\models\Dotbaoduong;
use app\models\Ketqua;
use app\models\KetquaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * KetquaController implements the CRUD actions for Ketqua model.
 */
class KetquaController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Ketqua models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KetquaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ketqua model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Updates an existing Ketqua model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCreate($id)
    {
        $dotbd = Dotbaoduong::findOne($id);
        $model = new Ketqua();


        if ($model->load(Yii::$app->request->post())) {
            $model->ID_DOTBD = $id;

            //get instances, upload files to host
            $model->files = UploadedFile::getInstances($model, 'files');
            $i=1;
            foreach ($model->files as $file) {
                $filePath = 'uploads/' . $dotbd->MA_DOTBD. '_'. $i . '.' . $file->extension;
                $file->saveAs($filePath);
                //save file path to database
                switch ($i) {
                    case '1':
                        $model->ANH1 = $filePath;
                        break;
                    case '2':
                        $model->ANH2 = $filePath;
                        break;
                    case '3':
                        $model->ANH3 = $filePath;
                        break;
                    
                    default:
                        break;
                }
                $i++;
            }

            $model->save(false);
            return $this->redirect(['view', 'id' => $model->ID_DOTBD]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'dotbd' => $dotbd,
            ]);
        }
    }

    /**
     * Deletes an existing Ketqua model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ketqua model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ketqua the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ketqua::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
