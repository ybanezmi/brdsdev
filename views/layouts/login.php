<?php
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

	<?php

		header('P3P: CP=”NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM”');

		header('Set-Cookie: SIDNAME=ronty; path=/; secure');

		header('Cache-Control: no-cache');

		header('Pragma: no-cache');

	?>

	<meta charset="<?= Yii::$app->charset ?>"/>
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <?= Html::csrfMetaTags() ?>
	<title><?php echo Html::encode($this->title); ?></title>
	<link rel="shortcut icon" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/favicon.ico" type="image/x-icon">
	<?php $this->head() ?>
	    <!--[if gte IE 9]><link rel="stylesheet" type="text/css" href="Yii::$app->getUrlManager()->getBaseUrl();?>/css/app_ie9.css"><![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/css/app_ie6.css">
	<![endif]-->

	<!--[if IE 6]>
	<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/js/vendor/DD_belatedPNG_0.0.8a.js"></script>
	<script>
	  	DD_belatedPNG.fix('.png_bg');
	</script>
	<![endif]-->
</head>

<body class="login">
	<?php $this->beginBody() ?>
		<div class="login-box">
			<?php echo $content; ?>
		</div>

		<div class="copy-logo">
			Copyright &copy; Manten Kaitou 2014. All rights reserve.
		</div>
		<?php include 'popupbox.php'; ?>
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>