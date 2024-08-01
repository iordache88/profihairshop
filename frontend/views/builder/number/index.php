<?php
	$content = Yii::$app->tools->decodeBody($_bodyContent);
	if(!empty($_id))
	{
		$id = 'id="'.$_id.'"';
	}
?>

<div <?= $id ?> class="module module-number<?= $count == '1' ? ' module-number-count' : '' ?> <?= $_class ?>">
	
	<?php 
    
        $percentChar = $percent == '1' ? '%' : '';
    
    ?>

    <div class="number-wrapper">
        <span class="number-element"><?= $number . $percentChar ?></span>
    </div>


</div>