<?php

namespace backend\controllers;

use app\models\Transactions;
use app\models\UserProfile;
use app\models\Users;
use app\models\UserSettings;
use backend\models\UsersSearch;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Users models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Users();
        $userProfileModel = new UserProfile();
        $userSettingsModel = new UserSettings();


        if ($this->request->isPost) {
            $model->load($this->request->post());
            $userProfileModel->load($this->request->post());
            $userSettingsModel->load($this->request->post());
            $valid= $model->validate();
            $valid= $userProfileModel->validate() && $valid;
            $valid= $userSettingsModel->validate() && $valid;
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!empty($model->hash_password)) {
                        $model->setPassword($model->password);
                    }
                    $model->generateAuthKey();
                    $model->status = 1;
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->updated_at = date('Y-m-d H:i:s');
                    if (!$model->save(false)) {
                        var_dump($model->getErrors());
                        die();                    }
                    if (isset($model->id))
                    {
                        $userProfileModel->user_id = $model->id;
                        if (!$userProfileModel->save(false)) {
                            var_dump($userProfileModel->getErrors());
                            die();
                        }
                        $userSettingsModel->user_id = $model->id;

                        if (!$userSettingsModel->save(false)) {
                            var_dump($userSettingsModel->getErrors());
                            die();
                        }
                    }else{
                        var_dump($model->getErrors());
                        die();
                    }


                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);


                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;

                }
            }else{
                Yii::$app->session->setFlash('error', 'Something went wrong while creating user.' );
                return $this->render('create', [
                    'model' => $model,
                    'userProfileModel' => $userProfileModel,
                    'userSettingsModel' => $userSettingsModel,
                ]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'userProfileModel' => $userProfileModel,
            'userSettingsModel' => $userSettingsModel,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (isset($model))
        {
            $userProfileModel = $model->userProfile ?? new UserProfile();
            $userSettingsModel = $model->userSettings ?? new UserSettings();
        }

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $userProfileModel->load($this->request->post());
            $userSettingsModel->load($this->request->post());
            $valid= $model->validate();
            $valid= $userProfileModel->validate() && $valid;
            $valid= $userSettingsModel->validate() && $valid;
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!empty($model->hash_password)) {
                        $model->setPassword($model->password);
                    }
                    if (!$model->save(false)) {
                        var_dump($model->getErrors());
                        die();
                    }
                    if (isset($model->id))
                    {
                        $userProfileModel->user_id = $model->id;
                        if (!$userProfileModel->save(false)) {
                            var_dump($userProfileModel->getErrors());
                            die();
                        }
                        $userSettingsModel->user_id = $model->id;
                        if (!$userSettingsModel->save(false)) {
                            var_dump($userSettingsModel->getErrors());
                            die();
                        }

                    }
                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }


                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                Yii::$app->session->setFlash('error', 'Something went wrong while creating user.' );
                return $this->render('update', [
                    'model' => $model,
                    'userProfileModel' => $userProfileModel,
                    'userSettingsModel' => $userSettingsModel,
                ]);
            }

        }

        return $this->render('update', [
            'model' => $model,
            'userProfileModel' => $userProfileModel,
            'userSettingsModel' => $userSettingsModel,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

    }
}
