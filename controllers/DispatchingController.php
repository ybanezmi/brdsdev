<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;;
use kartik\mpdf\Pdf;
use app\models\DispatchModel;
use app\constants\SapConst;
use linslin\yii2\curl;

class DispatchingController extends \yii\web\Controller
{
     public function actionIndex(){
      return $this->render('index');
    }

    public function actionPostDispatch(){
        $dispatch_model_1 = array();
        $dispatch_model_2 = array();
        $dispatch_id = Yii::$app->request->post('document_number');
        //$sap_dispatch = $this->getSapDispatch();

        // print_r($sap_dispatch);
        // exit;
         if (isset($dispatch_id)) {
            //Yii::app()->session['dispatch_id'] = $dispatch_id;

            $full_dispatch_id = '00'.$dispatch_id;
            $dismodel = new DispatchModel;
            $dispatch_model_1 = $dismodel->getDispatchList($full_dispatch_id);
            $dispatch_model_2 = $dismodel->getDispatchItems($full_dispatch_id);

            return $this->render('dispatch-print-form', [
                'dispatch_model_1' => $dispatch_model_1,
                'dispatch_model_2' => $dispatch_model_2
            ]);
        }
        else{
            return $this->render('index');
        }    
    }

    public function actionPrintDispatch(){
        $dispatch_model_1 = array();
        $dispatch_model_2 = array();
        $dispatch_id = Yii::$app->request->post('dispatch_number');

         if (isset($dispatch_id)) {
            $dismodel = new DispatchModel;
            Yii::$app->response->format = 'pdf';
            Yii::$container->set(Yii::$app->response->formatters['pdf']['class'], [
                  'format' => 'A4',
                  'orientation' => 'Portrait', // This value will be ignored if format is a string value.
                  'beforeRender' => function($mpdf, $data) {},
                  ]);
            $this->layout = '//print_dispatch';
            $dispatch_model_2 = $dismodel->getDispatchItems($dispatch_id);
            return $this->render('dispatch-print-preview.php',['dispatch_model_2' => $dispatch_model_2]);

        }
        else{
            return $this->render('index');
        }
    }

    public function getSapDispatch() {
        $params[SapConst::RFC_FUNCTION] = SapConst::READ_TEXT;

        // Post http://127.0.0.1/brdssap/sap/import
        $params[SapConst::PARAMS][SapConst::DIS_CLIENT] = '';
        $params[SapConst::PARAMS][SapConst::DIS_ID] = '';
        $params[SapConst::PARAMS][SapConst::DIS_LANGUAGE] = '';
        $params[SapConst::PARAMS][SapConst::DIS_NAME] = '';
        $params[SapConst::PARAMS][SapConst::DIS_OBJECT] = '';
        $params[SapConst::PARAMS][SapConst::DIS_ARCHIVE_HANDLE] = '';
        $params[SapConst::PARAMS][SapConst::DIS_LOCAL_CAT] = '';


        $response = $this->curl(Yii::$app->params['SAP_API_URL'], false, http_build_query($params), false, true);

        return $response;
    }

    public function actionDispatch(){
        return $this->render('dispatch');
    }

    public function actionPrint(){
          echo Yii::$app->request->post('total_weight');
          exit;
          Yii::$app->response->format = 'pdf';
            //Can you it if needed to rotate the page
            Yii::$container->set(Yii::$app->response->formatters['pdf']['class'], [
                'orientation' => 'Landscape', // This value will be ignored if format is a string value.
                'beforeRender' => function($mpdf, $data) {},
                ]);
            $this->layout = '//print_dispatch';
            return $this->render('print-preview',[]);
    }

    function curl($url, $cookie = false, $post = false, $header = false, $follow_location = false, $referer=false, $proxy=false) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow_location);
        if ($cookie) {
            curl_setopt ($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $response;
    }

}