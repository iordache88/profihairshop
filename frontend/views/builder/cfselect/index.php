<?php
	$mandatory = null;
	$icon = null;

	if(!empty($_id))
	{
		$id = 'id="'.$_id.'"';
	}
	if($required == 1)
	{
		$mandatory = 'required=""';
	}
	if($multiple == 1)
	{
		$multi = 'multiple';
		$icon = '<span>*</span>';
	}
	$name = 'select'.$_row.$_col.$_idModule;
	$options = json_decode($options, true);
?>

<div class="form-group select item-<?= $_row.$_col.$_idModule ?>">
<label><?= $label ?><?= $icon ?></label>
<select <?= $id ?> class="<?= $_class ?> form-control" name="<?= $name ?>" <?= $multi ?>> 
	<option value=""></option>
	
	<?php foreach($options as $key=>$option) : ?>

		<option value="<?= $option ?>"><?= $option ?></option>

	<?php endforeach; ?>

</select>
</div>