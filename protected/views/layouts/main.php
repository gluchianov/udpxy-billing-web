<!DOCTYPE html>
<html lang="ru" ng-app="iptvbillApp">
  <head>
    <meta charset="utf-8">
    <title><?php echo CHtml::encode(Yii::app()->name); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" media="screen">
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
    <![endif]-->
  </head>
  <body>

    <div class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="<?php echo Yii::app()->request->baseUrl; ?>/" class="navbar-brand"><?php echo CHtml::encode(Yii::app()->name); ?></a>
		  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
			<?php $this->widget('zii.widgets.CMenu',array(
			  'htmlOptions' => array(
                    'class'=>'nav navbar-nav',
                        ),
			  'items'=>array(
				array('label'=>'Клиенты', 'url'=>array('/clients'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Тарифы', 'url'=>array('/tariffs'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Войти', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
			  ),
			)); ?>

			<?php $this->widget('zii.widgets.CMenu',array(
			  'htmlOptions' => array('class'=>'nav navbar-nav navbar-right'),
			  'items'=>array(
				array('label'=>'Выйти ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			  ),
			)); ?>	

        </div>
      </div>
    </div>
	
    <div class="container">
		<?php echo $content; ?>
    </div>

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
  </body>
</html>