<?php 

/* @var $field object|null common\models\Customfield */

?>

<?php 

if(is_null($field)) {

    echo "<input placeholder='Select field first' readonly class='form-control'>";
    return;
}

?>


<?php 

$field_type = $field->type;

$value_options = json_decode($data['value_options'], true);


switch ($field_type) {




    case 'text':
    case 'textarea':
        ?>

        <input type="text" name="value_options[]" value="<?= $value_options[0]; ?>" class="form-control">

        <small>Write the value that should match...</small>

        <?php
        break;
    




    case 'selector':
        ?>

        <select name="value_options[]" class="form-control">

            <?php 
            foreach($field->childs as $option) {
                ?>

                <option value="<?= $option->ID;?>" <?= $option->ID == $value_options[0] ? 'selected' : '';?>><?= $option->title; ?></option>

                <?php
            }
             ?>

        </select>
        <?php
        break;




    case 'checkbox':

            
        foreach($field->childs as $field_checkbox) {

            $checked = '';
            if(is_array($value_options)){
                foreach($value_options as $opt_val) {

                    if($opt_val == $field_checkbox->ID) {
                        $checked = 'checked';
                        break;
                    }
                }
            }

            ?>

            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="value_options[]" value="<?= $field_checkbox->ID; ?>" <?= $checked; ?>>
                    <?= $field_checkbox->title; ?>
                    <span class="form-check-sign"></span>
                </label>
            </div>

            <?php
        }
             
        break;

    default:

        echo "<input placeholder='The field has to be text, selector, checkbox or textarea.' readonly class='form-control'>";
        
        break;
}

?>