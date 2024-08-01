<?php
if (!empty($_id)) {
	$id = 'id="' . $_id . '"';
} else {
	$id = '';
}

$color_style = '';
if(isset($color)) {
	$color_style = 'color: ' . $color . ';';
}

?>

<div <?= $id ?> class="module module-newsletter <?= $_class ?>" style="<?= $color_style; ?>text-align: <?= $contentalign ?>">

	<form method="POST" id="subscribeNewsletter" action="/newsletter/subscribe">
		<input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

		<h3><?= $title ?></h3>
		<p><?= $subtitle ?></p>

		<div class="form-group">
			<input type="email" name="email" class="form-control" required="" placeholder="adresata@email.com" />
		</div>


		<button type="submit" class="btn" style="background-color: <?= $buttonbgcolor ?>; color: <?= $buttontextcolor ?>"><?= $buttontext ?></button>

	</form>

</div>