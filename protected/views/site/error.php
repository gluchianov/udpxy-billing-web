<div class="error">
    <h2>Error <?php echo $code; ?></h2>
	<?php echo CHtml::encode($message).'<br />';
    echo $file.' #on line '.$line;
    ?>
</div>