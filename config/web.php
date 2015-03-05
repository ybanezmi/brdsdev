<?php

use kartik\datecontrol\Module;

$params = require(__DIR__ . '/params.php');

// jQuery for IE6
$assetManager = array();

if(preg_match('/(?i)msie [1-6]/',$_SERVER['HTTP_USER_AGENT'])) {
	$assetManager =  [
			            'bundles' => [
			                'yii\web\JqueryAsset' => [
			                    'sourcePath' => null,   // do not publish the bundle
			                    'js' => [
			                        $params['APP_NAME'] . '/web/js/vendor/jquery-1.11.1.min.js',
			                    ]
			                ],
			            ]];
}

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
    	'assetManager' => $assetManager,
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'a751d72e738f8639bf8f67566f73ed12',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\MstAccount',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
		    'enablePrettyUrl' => true,
		    'showScriptName' => false,
		    // ...
		],
		'modelFinder' => [
			'class' => 'app\components\CModelFinder',
		],
		'dateFormatter' => [
			'class' => 'app\components\CDateFormatter',
		],
		'response' => [
            'formatters' => [
                'pdf' => [
                    'class' => 'robregonm\pdf\PdfResponseFormatter',
                    'mode' => '', // Optional
                    'format' => array(101.6, 50.8),  // Optional but recommended. http://mpdf1.com/manual/index.php?tid=184
                    'defaultFontSize' => 0, // Optional
                    'defaultFont' => 'opensans', // Optional
                    'marginLeft' => 0, // Optional
                    'marginRight' => 0, // Optional
                    'marginTop' => 0, // Optional
                    'marginBottom' => 0, // Optional
                    'marginHeader' => 0, // Optional
                    'marginFooter' => 0, // Optional
                    'orientation' => 'Portrait', // optional. This value will be ignored if format is a string value.
                    'options' => [
                        // mPDF Variables
                        'fontdata' => [
						// ... some fonts. http://mpdf1.com/manual/index.php?tid=454
						"dejavusanscondensed" => array(
							'R' => "DejaVuSansCondensed.ttf",
							'B' => "DejaVuSansCondensed-Bold.ttf",
							'I' => "DejaVuSansCondensed-Oblique.ttf",
							'BI' => "DejaVuSansCondensed-BoldOblique.ttf",
							'useOTL' => 0xFF,
							'useKashida' => 75,
						)
                        ]
                    ]
                ],
            ]
        ],
        'DNS1D' => 'Dinesh\Barcode\DNS1D',
		'DNS2D' => 'Dinesh\Barcode\Facades\DNS2DFacade',
    ],
    'aliases' => [	
    				'DNS1D' => 'Dinesh\Barcode\Facades\DNS1DFacade',
        			'DNS2D' => 'Dinesh\Barcode\Facades\DNS2DFacade',
        		 ],
    'params' => $params,
    'modules' => [//add by Scott
        'gridview' => [
	            'class' => '\kartik\grid\Module',
	             // 'downloadAction' => 'gridview/export/download',
	            'downloadAction' => 'export',  //change default download action to your own export action.
            ],
		'datecontrol' =>  [
	        'class' => 'kartik\datecontrol\Module',
	
	        // format settings for displaying each date attribute (ICU format example)
	        'displaySettings' => [
	            Module::FORMAT_DATE => 'MM/dd/yyyy',
	            Module::FORMAT_TIME => 'HH:mm:ss a',
	            Module::FORMAT_DATETIME => 'MM/dd/yyyy HH:mm:ss a', 
	        ],
	
	        // format settings for saving each date attribute (PHP format example)
	        'saveSettings' => [
	            Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
	            Module::FORMAT_TIME => 'php:H:i:s',
	            Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
	        ],
	
	        // set your display timezone
	        'displayTimezone' => 'Asia/Manila',
	
	        // set your timezone for date saved to db
	        'saveTimezone' => 'Asia/Manila',
	
	        // automatically use kartik\widgets for each of the above formats
	        'autoWidget' => true,
	
	        // use ajax conversion for processing dates from display format to save format.
	        'ajaxConversion' => true,
	
	        // default settings for each widget from kartik\widgets used when autoWidget is true
	        'autoWidgetSettings' => [
	            Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
	            Module::FORMAT_DATETIME => [], // setup if needed
	            Module::FORMAT_TIME => [], // setup if needed
	        ],
	
	        // custom widget settings that will be used to render the date input instead of kartik\widgets,
	        // this will be used when autoWidget is set to false at module or widget level.
	        'widgetSettings' => [
	            Module::FORMAT_DATE => [
	                'class' => 'yii\jui\DatePicker', // example
	                'options' => [
	                    'dateFormat' => 'php:M/d/Y',
	                    'options' => ['class'=>'form-control'],
	                ]
	            ]
	        ]
	        // other settings
	    ],
	    /*
	    'barcodegenerator' => [
	    	'class' => 'vendor\barcodegenerator\BarcodeGeneratorController',
	    ]
		 */
	],
	'extensions' => [
		'vendor\barcodegenerator\BarcodeGeneratorController',
	],
    
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}
return $config;
