<?php
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
	<title><?php echo Html::encode($this->title); ?></title>
	<?php $this->head() ?>
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