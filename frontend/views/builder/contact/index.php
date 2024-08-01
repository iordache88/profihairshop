<form method="POST" action="" data-formid="<?= $form->ID ?>" class="c-form c-form-init c-form<?= $form->ID ?>" enctype="multipart/form-data">
	<input type="hidden" name="action" value="contactform" />
	<input type="hidden" name="formID" value="<?= $form->ID ?>" />
	<input type="hidden" name="language" value="<?php echo Yii::$app->language; ?>" />
	<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<?php

	$data = json_decode($form->data, false);
	echo Yii::$app->tools->renderBuilder($data);

?>
	
	<div class="form-group agreement-radio item-acceptance" style="margin-top: 0">
		<span class="acceptance e-checkbox">
			<label>
				<input type="checkbox" name="acceptance"
					aria-invalid="false">
				<span
					class="checkbox-text"><?= urldecode($form->acceptance) ?>*</span>
				<span class="e-check"></span>
			</label>
		</span>
	</div>
	
	<?php
	
	if(NULL != Yii::$app->tools->settings('api_key_recaptcha_site') && NULL != Yii::$app->tools->settings('api_key_recaptcha_secret')) 
	{
		echo  '<div class="col-12 pl-0  mb-3">
				<div class="g-recaptcha" data-sitekey="'.Yii::$app->tools->settings('api_key_recaptcha_site').'"></div>
			   </div>';	
	}
	
	?>
	<div class="form-group btn-section row">
		<div class="col-12">

			<?php
				$btnText = 'Send';
				if($form->submit != null)
				{
					$btnText = urldecode($form->submit);
				}
			?>
			<?php
				echo \yii\captcha\Captcha::widget([
					'name' => 'verifyCode',
					'template' => '<div class="row">
									<div class="col-lg-6">{input}</div>
								<div class="col-lg-6" id="#verifyCode-image">{image}</div>
								<div class="col-lg-12"><p class="danger"><i>*Click pe imagine pentru resetare!</i></p></div>
							</div>',
				]);
			?>

			<div id="review-form-response"></div>


			<button type="submit" class="btn btn-primary"><?= $btnText ?></button>
		</div>
	</div>

</form>