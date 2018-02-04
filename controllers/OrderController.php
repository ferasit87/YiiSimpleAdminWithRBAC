<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\Order;

class OrderController extends Controller
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
        $data = (array)json_decode(Yii::$app->request->getRawBody());


        $user = User::findIdentityByAccessToken($data['token']);
        if ($user){
            $return = array();
            if($user->isAdmin){
                $orders =  Order::find()->all();
            }else {
                $orders = $user->getOrders();
            }
            foreach ($orders as $order){
                $return['result'][]= $order->fields() ;
            }
            return json_encode($return) ;
        }else{
            return json_encode(array("Error"=> $user->errors));
        }



    }
    public function actionView()
    {
        //code
        $data = (array)json_decode(Yii::$app->request->getRawBody());

        $user = User::findIdentityByAccessToken($data['token']);
        if ($user){
            Yii::$app->user->switchIdentity($user);
            $order = Order::findOne($data['order_id']);
            if ($order){
                if (\Yii::$app->user->can('updateOrder', ['order' => $order])) {
                    return json_encode($order->fields());
                }else{
                    return json_encode(array("Error"=> "400 unauthorized"));
                }
            }
            else  return json_encode(array("Error"=> "Order Not Found"));
        }else{
            return json_encode(array("Error"=> $user->errors));
        }



    }
    public function actionAdd()
    {
        //code
        $data = (array)json_decode(Yii::$app->request->getRawBody());

        $user = User::findIdentityByAccessToken($data['token']);
        if ($user){
            Yii::$app->user->switchIdentity($user);
            if (\Yii::$app->user->can('createOrder')) {
                // create order

                $order = new Order();
                $order->name = $data['name'] ? $data['name'] : '' ;
                $order->sum   = $data['sum'] ? $data['sum']  : 0;
                $order->user_id = $user->id;
                if ($order->save()) return json_encode(array("result" => true));
                else  return json_encode(array("Error"=> $order->errors));
            }else{
             return json_encode(array("Error"=> "400 unauthorized"));
            }
        }else{
            return json_encode(array("Error"=> $user->errors));
        }

    }
    public function actionUpdate()
    {
        //code
        $data = (array)json_decode(Yii::$app->request->getRawBody());

        $user = User::findIdentityByAccessToken($data['token']);
        if ($user){
            Yii::$app->user->switchIdentity($user);
            $order = Order::findOne($data['order_id']);
            if ($order){
                if (\Yii::$app->user->can('updateOrder', ['order' => $order])) {

                    if (isset($data['name'])) $order->name = $data['name'];
                    if (isset($data['sum']))  $order->sum   = $data['sum'];
                    if ($order->save()) return json_encode(array("result" => true));
                    else  return json_encode(array("Error"=> $order->errors));
                }else{
                    return json_encode(array("Error"=> "400 unauthorized"));
                }
            }
            else  return json_encode(array("Error"=> "Order Not Found"));
        }else{
            return json_encode(array("Error"=> $user->errors));
        }

    }

}