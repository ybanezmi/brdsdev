		<nav>
			<ul>
				<li class="recieving-nav"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/receiving/index"><i class="fa fa-download"></i> <span>Receiving</span></a></li>
				<li class="dispatching-nav"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/dispatching/index"><i class="fa fa-share-square-o"></i> <span>Dispatching</span></a></li>
				<?php if(!preg_match('/(?i)msie [1-6]/',$_SERVER['HTTP_USER_AGENT'])) { ?> 
				<li class="weight-nav"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/weight-capture/index"><i class="fa fa-anchor"></i> <span>Weight Capture</span></a></li>
				<?php } ?>
				<li class="admin-nav"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/admin-tools/index"><i class="fa fa-cogs"></i> <span>Admin Tools</span></a></li>
				<li class="logout-nav"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/site/logout"><i class="fa fa-sign-out"></i> <span>Log out</span></a></li>
			</ul>	
		</nav>