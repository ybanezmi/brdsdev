<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?= $this->title ?></title>
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
