<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?= $this->title ?></title>
    <link rel="shortcut icon" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/favicon.ico" type="image/x-icon">
    <?php $this->head() ?>
    <style>
		html {
			font-family: 'Open Sans', sans-serif;
			-webkit-font-smoothing: antialiased;
		}
    </style>
</head>
<body>
    <div class="container" id="container">
        <?= $content ?>
    </div>
</body>
</html>
