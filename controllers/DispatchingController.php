<?php

namespace app\controllers;

class DispatchingController extends \yii\web\Controller
{
    public function actionDispatch()
    {
        return $this->render('dispatch');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPrint()
    {
        return $this->render('print');
    }

}
