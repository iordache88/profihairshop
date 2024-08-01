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
	$name = 'input'.$_row.$_col.$_idModule;

	if(isset($placeholder))
	{
		$placeholder = 'placeholder="' . $placeholder . '"';
	}
?>

<div class="form-group item-<?= $_row.$_col.$_idModule ?>">
<label><?= $label ?><?= $icon ?></label>
<input <?= $id ?> type="text" class="<?= $_class ?> form-control" name="<?= $name ?>" <?= $max ?> <?= $placeholder ?>  />
</div>