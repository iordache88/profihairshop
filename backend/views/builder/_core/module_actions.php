<?php 

use yii\helpers\Url;

?>
<form method="POST" action="<?= Url::to(['builder/actionmodule']); ?>">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
    <input type="hidden" name="action" value="<?= $action ?>">
    <input type="hidden" name="page" value="<?= $page ?>">
    <input type="hidden" name="item" value="<?= $item ?>">
    <input type="hidden" name="column" value="<?= $column ?>">
    <input type="hidden" name="module" value="<?= $module ?>">
    <input type="hidden" name="confirm" value="1">


<?php
	if($action == 'remove')
	{
		$view = 'module';
		$item = '';
		include(Yii::getAlias('@app').'/views/builder/_core/_confirmation.php');
	}
	elseif($action == 'clone')
	{
		$view = 'module';
		$item = '';
		include(Yii::getAlias('@app').'/views/builder/_core/_cloneconfirmation.php');
	}
	
?>

</form>