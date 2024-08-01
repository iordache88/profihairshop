<?php
	$content = Yii::$app->tools->decodeBody($_bodyContent);
	if(!empty($_id))
	{
		$id = 'id="'.$_id.'"';
	}

		$interval = $delay * 1000;
		$slides = $slider->child;

?>

<div <?= $id ?> class="module module-slider module-slider-slick slick-slider <?= $_class ?>" data-autoplay-speed="<?= $interval ?>" data-autoplay="<?= $autoplay ?>">

	<?php 

		foreach ($slides as $slide)
		{
			$setup = unserialize($slide->setup);
			echo '<div class="slick-slide" style="background-image: url('.Yii::$app->media->showImg($slide->ID_media).')">
					<div class="slick-slide-inner">
						<div class="slide-slick-title"><h4>'.$slide->title.'</h4></div>
						<div class="slide-slick-image"><img width="150" src="'. Yii::$app->media->showImg($slide->ID_image) .'" /></div>
						<div class="slide-slick-content"><p>'.$slide->content.'</p></div>';

					$target = null;
					$style = null;
					if($setup['btnTarget'] != null)
					{
						$target = 'target="'.$setup['btnTarget'].'"';
					}
					if($setup['btnTextColor'] != null)
					{
						$style .= ' color: '.$setup['btnTextColor'].';';
					}
					if($setup['btnBackgroundColor'] != null)
					{
						$style .= ' background-color: '.$setup['btnBackgroundColor'].';';
					}
					echo '<a href="'.$slide->btn_url.'" class="btn slide-btn" style="'.$style.'" '.$target.'>'.$setup['btnText'].'</a>';
			
			echo '</div>';
			echo '</div>';
		}
		
	?>
	
</div>
