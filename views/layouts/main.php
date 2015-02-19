<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/favicon.ico" type="image/x-icon">
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
<body>
<div class="wrap-page">
<?php $this->beginBody() ?>
    <div class="wrap">
    			<div id="logo">
		<a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>" class="logo-img"></a>
	</div>
			
			<header>
				<?php
					//@TODO Reimplement navigation
					if (isset(Yii::$app->user->identity->account_type)) {
						switch (Yii::$app->user->identity->account_type) {
							case 'admin':
								include 'navigation.php';
								break;
							case 'checker':
								include 'checker-navigation.php';
								break;
							case 'standard':
								include 'standard-navigation.php';
								break;
							default:
								include 'navigation.php';
								break;
						}
					} else {
						include 'navigation.php';
					}
		            
					/*
					NavBar::begin([
															'brandLabel' => '',
															'brandUrl' => '',
															'options' => [
																'class' => 'header',
															],
														]);
														echo Nav::widget([
															'encodeLabels' => false,
															'options' => ['class' => 'header-nav'],
															'items' => [
																['label' => '<i class="fa fa-download"></i> Receiving', 'url' => ['/site/index']],
																['label' => '<i class="fa fa-share-square-o"></i> Dispatching', 'url' => ['/site/about']],
																['label' => '<i class="fa fa-anchor"></i> Weight Capture', 'url' => ['/site/contact']],
																['label' => '<i class="fa fa-cogs"></i> Admin Tools', 'url' => ['/site/contact']],
																Yii::$app->user->isGuest ?
																	['label' => 'Login', 'url' => ['/site/login']] :
																	['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
																		'url' => ['/site/logout'],
																		'linkOptions' => ['data-method' => 'post']],
															],
														]);
														NavBar::end();*/
					
					
		        ?>
			</header>
	        
			
		<section id="greetings">
			<div class="g-body">
				<a onclick="_togglehidden2('dropdownie6')" href="profile.php" class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html"><?php echo Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name ?> @ 
					<?php echo Yii::$app->user->identity->assignment ?></a>
				
				<ul class="dropdown-menu omenu" role="menu" aria-labelledby="dLabel" id="dropdownie6">
					<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/site/change-password"><i class="fa fa-fire"></i> Change password</a></li>
				</ul>
			</div>
		</section>
	
		<section class="blue-line"></section>

        <div class="container" id="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    
    <?php include 'popupbox.php'; ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
