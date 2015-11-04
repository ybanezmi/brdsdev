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
        if (null !== Yii::$app->request->post('cancel')) {
            $this->redirect('/receiving/index');
		} else if (null !== Yii::$app->request->post('print')) {
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
		$material_list = $this->formatMaterialList($material_model);
		echo json_encode($material_list);
	}

	public function formatMaterialList($material_model)
	{
		$material_list = ArrayHelper::map($material_model, 'item_code', 'description');

		$description_max_length = 40;
		$space_char = '&nbsp;';
		foreach ($material_list as $key => $value)
		{
			$value_length = strlen($value);
			
			if($description_max_length < $value_length)
			{
				$value = substr($value, 0, $description_max_length);
			}
			else
			{
				$space_padding = $description_max_length - $value_length;
				$value = $value . str_repeat($space_char, $space_padding);
			}
			
			$material_list[$key] = html_entity_decode("{$value}{$space_char}{$space_char}-{$space_char}{$space_char}{$key}");
		}
		
		return $material_list;
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
        $material_model = Yii::$app->modelFinder->getMaterialList(null, ['and',['like', 'item_code', $id], ['like', 'description', "{$desc}%", false]]);

        if ($material_model == null || count($material_model) == 0) {
            $material_model = Yii::$app->modelFinder->getMaterialList(null, ['barcode' => $desc]);
        }
		
		$material_list = $this->formatMaterialList($material_model);

        echo json_encode($material_list);
    }
}
