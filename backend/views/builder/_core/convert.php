<div class="row">
	<div class="col-md-12 text-center">
		<i class="fa fa-exclamation-triangle text-info fa-5x" aria-hidden="true"></i><br/><br/>
		<h6 class="text-info">The page structure needs to be converted.</h6>
		<form></form>
		<form method="POST" class="form-convert-builder" action="/backend/web/index.php?r=builder/convert">
			<input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
			<input type="hidden" name="idPage" value="<?= $page->ID ?>" />
			<button type="submit" class="btn btn-danger btn-simple"><i class="fa fa-arrow-right" aria-hidden="true"></i> Convert</button>
		</form>
	</div>
</div>