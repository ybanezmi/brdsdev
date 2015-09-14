<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

class WeightCaptureController extends Controller
{
    public function actionIndex()
    {
    	// Get customer list
		$customer_list = ArrayHelper::map(Yii::$app->modelFinder->getCustomerList(), 'code', 'name');

		if (null !== Yii::$app->request->post('print')) {
			Yii::$app->response->format = 'pdf';

	        //Can you it if needed to rotate the page
	        Yii::$container->set(Yii::$app->response->formatters['pdf']['class'], [
	        	'format' => array(101.6, 50.8),
	            'orientation' => 'Landscape', // This value will be ignored if format is a string value.
	            'beforeRender' => function($mpdf, $data) {},
	            ]);
	        $this->layout = '//print';
	        return $this->render('print-preview',[]);
		} else {
			return $this->render('index',[
	        	'customer_list' => $customer_list,
	        ]);
		}
    }

    public function actionPrintTag()
    {
    	// Get customer list
		$customer_list = ArrayHelper::map(Yii::$app->modelFinder->getCustomerList(), 'code', 'name');

		if (null !== Yii::$app->request->post('print')) {
			Yii::$app->response->format = 'pdf';

	        //Can you it if needed to rotate the page
	        Yii::$container->set(Yii::$app->response->formatters['pdf']['class'], [
	        	'format' => array(101.6, 50.8),
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
        	'format' => array(101.6, 50.8),
            'orientation' => 'Landscape', // This value will be ignored if format is a string value.
            'beforeRender' => function($mpdf, $data) {},
            ]);

        $this->layout = '//print';
    }

    public function actionGetMaterial($id, $desc) {
        $material_model = Yii::$app->modelFinder->getMaterialList(null, ['and',['like', 'item_code', $id], ['like', 'description', $desc]]);

        if ($material_model == null || count($material_model) == 0) {
            $material_model = Yii::$app->modelFinder->getMaterialList(null, ['barcode' => $desc]);
        }

        $material_list['item_code'] = ArrayHelper::getColumn($material_model, 'item_code');
        $material_list['description'] = ArrayHelper::getColumn($material_model, 'description');

        echo json_encode($material_list);
    }
}
