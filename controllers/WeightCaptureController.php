<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

class WeightCaptureController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPrintTag()
    {
    	// Get customer list
		$customer_list = ArrayHelper::map(Yii::$app->modelFinder->getCustomerList(), 'code', 'name');
		
		if (null !== Yii::$app->request->post('print')) {
			Yii::$app->response->format = 'pdf';

	        //Can you it if needed to rotate the page
	        Yii::$container->set(Yii::$app->response->formatters['pdf']['class'], [
	            'orientation' => 'Landscape', // This value will be ignored if format is a string value.
	            'beforeRender' => function($mpdf, $data) {},
	            ]);
	        $this->layout = '//print';
	        return $this->render('print-preview',[]);
		} else {
			return $this->render('print-tag',[
	        	'customer_list' => $customer_list,
	        ]);
		}
    }
	
	public function actionPrintPreview()
	{
		$this->layout = '//print';
		return iconv("UTF-8","UTF-8//IGNORE",$this->render('print-preview',[]));
	}
	
    public function actionWeighing()
    {
        return $this->render('weighing');
    }
	
	public function actionGetMaterialList($item_code)
	{
		$material_model = Yii::$app->modelFinder->getMaterialList(null, ['like', 'item_code', $item_code]);
			
		$material_list = ArrayHelper::toArray($material_model);
		
		echo json_encode($material_list);
	}


	public function actionPdf(){
        Yii::$app->response->format = 'pdf';

        //Can you it if needed to rotate the page
        Yii::$container->set(Yii::$app->response->formatters['pdf']['class'], [
            'orientation' => 'Landscape', // This value will be ignored if format is a string value.
            'beforeRender' => function($mpdf, $data) {},
            ]);

        $this->layout = '//print';
    }
}
