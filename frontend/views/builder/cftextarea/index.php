<?php
	$mandatory = null;
	$icon = null;

	if(!empty($_id))
	{
		$id = 'id="'.$_id.'"';
	}
	if(!empty($maxlength))
	{
		$max = 'maxlength="'.$maxlength.'"';
	}
	if($required == 1)
	{
		$mandatory = 'required=""';
		$icon = '<span>*</span>';
	}
	$name = 'textarea'.$_row.$_col.$_idModule;
?>

<div class="form-group item-<?= $_row.$_col.$_idModule ?>">
<label><?= $label ?><?= $icon ?></label>
<textarea <?= $id ?> class="<?= $_class ?> form-control" name="<?= $name ?>" <?= $max ?>></textarea>
</div>