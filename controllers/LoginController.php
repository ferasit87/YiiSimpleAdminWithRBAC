<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;

class LoginController extends Controller
{

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        //code
        $model = new LoginForm();
        $data = (array)json_decode(Yii::$app->request->getRawBody());
        $data['LoginForm'] = (array)$data['LoginForm'];
        if ($model->load($data) && $model->login()) {
            return json_encode($model->getUser()->fields() );
        }
        return json_encode(array("Error"=> $model->errors));

    }

}