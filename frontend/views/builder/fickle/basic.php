<?php

	use common\models\Media;

	/* @vars:

	'_id'                  => $_id,
	'_class'               => $_class,
	'title_html_tag'       => $title_html_tag,
	'title_text'           => $title_text,
	'subtitle_html_tag'    => $subtitle_html_tag,
	'subtitle_text'        => $subtitle_text,
	'text_content'         => $text_content,
	'additional_html_code' => $additional_html_code,
	'view_type'            => $view_type,
	'image_id'             => $image,
	'background_image_id'  => $background_image,
	'icon'                 => $icon,
	'link'                 => $link,
	'link_target'          => $link_target,
	*/

	$image            = Media::showImg($image_id);
	$image_alt_title  = Media::showInfo($image_id, 'alt_title');
	$background_image = Media::showImg($background_image_id);

	$add_target = $link_target == "_self" ? '' : "target='$link_target'";


	foreach($this->context->actionParams as $key => $param){

		if(!in_array($key, ['_id', '_class', 'title_html_tag', 'subtitle_html_tag', 'link_target', 'view_type']) && !empty($param)){

			$_class .= " fickle-has-" . str_replace('_', '-', $key);

		}
	}

?>


<div <?= empty($_id) ? '' : "id='$_id'" ?> class="module module-fickle module-fickle-basic <?= $_class ?>" <?= empty($background_image) ? '' : "style='background-image: url($background_image)'" ?>>

	<?php if(!empty($title_text) || !empty($subtitle_text)) { ?>

	<div class="fickle-header">

	<?php } ?>

		<?php 

		if(!empty($title_text)) {

		?>

			<div class="fickle-item fickle-title">
				
				<?php 
					if(empty($link)) {
						echo "<{$title_html_tag} class='fickle-title'>{$title_text}</{$title_html_tag}>";
					} else {
						echo "<{$title_html_tag} class='fickle-title'><a href='{$link}' {$add_target}>{$title_text}</a></{$title_html_tag}>";
					}
				?>

			</div>

		<?php
		}

		if(!empty($subtitle_text)) {

		?>

			<div class="fickle-item fickle-subtitle">
				<?php

				if(empty($link)) {
					echo "<{$subtitle_html_tag} class='fickle-title'>{$subtitle_text}</{$subtitle_html_tag}>";
				} else {
					echo "<{$subtitle_html_tag} class='fickle-title'><a href='{$link}' {$add_target}>{$subtitle_text}</a></{$subtitle_html_tag}>";
				}
				
				?>
			</div>

		<?php

		}
		?>


	<?php
	if(!empty($title_text) || !empty($subtitle_text)) { ?>

	</div>
		
	<?php }

		if(!empty($image)) {
			
		?>

			<div class="fickle-item fickle-image">

				<?php
				
				if(empty($link)) {
					echo "<img src='{$image}' alt='{$image_alt_title}' class='img-fluid'>";
				} else {
					echo "<a href='{$link}' {$add_target}><img src='{$image}' alt='{$image_alt_title}'  class='img-fluid' /></a>";
				}

				?>			
				
			</div>
			
		<?php
		}

		if(!empty($icon) && $icon != "no") {
			
		?>

			<div class="fickle-item fickle-icon">

				<?php
				
				if(empty($link)) {
					echo "<i class='fa {$icon}' aria-hidden='true'></i>";
				} else {
					echo "<a href='{$link}' {$add_target}><i class='fa {$icon}' aria-hidden='true'></i></a>";
				}
				?>			
				
			</div>
			
			<?php
		}
		?>
	

	<?php if(!empty($title_text) || !empty($subtitle_text)) { ?>

	<div class="fickle-content">

	<?php } ?>

		<?php 
		if(!empty($text_content)) {		
		?>

		<div class="fickle-item fickle-text-content">

			<?= $text_content ?>			
			
		</div>
		
		<?php
		}
		?>



		<?php 
		if(!empty($additional_html_code)) {		
		?>

		<div class="fickle-item fickle-additional-html-code">

			<?= $additional_html_code ?>			
			
		</div>
		
		<?php
		}
		?>



	<?php if(!empty($title_text) || !empty($subtitle_text)) { ?>
		</div>
	<?php } ?>

</div>