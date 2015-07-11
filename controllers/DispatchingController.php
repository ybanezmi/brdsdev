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

class DispatchingController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $dispatch_model_1 = array();
        $dispatch_model_2 = array();

        if(null !== Yii::$app->request->post('cancel')) {
            $this->redirect(['index']);

        } else {
          

            if (null !== Yii::$app->request->post('submit-document')) {

                if (null !== Yii::$app->request->post('submit-document')) {
                    $document_num = '00'.Yii::$app->request->post('document_number');
                    $dismodel = new DispatchModel;

                    $dispatch_model_1 = $dismodel->getDispatchList($document_num);
                    $dispatch_model_2 = $dismodel->getDispatchItems($document_num);
                    
                    return $this->render('index', [
                        'dispatch_model_1' => $dispatch_model_1,
                        'dispatch_model_2' => $dispatch_model_2
                    ]);
                } 
            }

            else if (null !== Yii::$app->request->post('print-document')) {

               // $items = Yii::$app->request->post();

               // echo "<pre>"; print_r($items);

               // foreach($items as $row => $value){
               //      //echo $value->total_weight;
               // }

               // exit;

               // foreach ($items as $items_key => $items_key_info) {
               //    foreach($items_key_info->material_name as $material_name_key => $material_name_key_info){
               //          echo $material_name_key_info
               //    }
               //  }

               //  foreach($resultArray as $row => $value){
               //      foreach($value as $row2 => $value2)
               //          echo $value2 . "<br/>";
               //  }

               //  exit;
              $dismodel = new DispatchModel;

                Yii::$app->response->format = 'pdf';
                 $dn = Yii::$app->request->post('dispatch_number');
                
               
                Yii::$container->set(Yii::$app->response->formatters['pdf']['class'], [
                    'format' => 'A4',
                    'orientation' => 'Portrait', // This value will be ignored if format is a string value.
                    'beforeRender' => function($mpdf, $data) {},
                    ]);
                $this->layout = '//print';
                $dispatch_model_2 = $dismodel->getDispatchItems($dn);
                return $this->render('dispatch-print-preview.php',['dispatch_model_2' => $dispatch_model_2]);
            }
           
            else {
                 return $this->render('index', [
                    'dispatch_model_1' => $dispatch_model_1,
                    'dispatch_model_2' => $dispatch_model_2
                ]);
            }




        }
    }

    public function actionDispatch()
    {
        return $this->render('dispatch');
    }

    public function actionPrint()
    {
          echo Yii::$app->request->post('total_weight');
          exit;
          Yii::$app->response->format = 'pdf';
            //Can you it if needed to rotate the page
            Yii::$container->set(Yii::$app->response->formatters['pdf']['class'], [
                'orientation' => 'Landscape', // This value will be ignored if format is a string value.
                'beforeRender' => function($mpdf, $data) {},
                ]);
            $this->layout = '//print';
            return $this->render('print-preview',[]);
    }

}