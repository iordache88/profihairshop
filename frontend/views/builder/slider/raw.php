<?php
	$content = Yii::$app->tools->decodeBody($_bodyContent);
	if(!empty($_id))
	{
		$id = 'id="'.$_id.'"';
	}
?>

<div <?= $id ?> class="module module-slider module-slider-raw <?= $_class ?>">
	

	<?php 

		$slides = $slider->child;

		foreach ($slides as $slide) {
			
			echo 	'<div class="slide-raw">
						<div class="slide-raw-title">'.$slide->title.'</div>
						<div class="slide-raw-conttent">'.$slide->content.'</div>
					</div>';

		}
		
	?>
	

</div>