<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<div class="subcategories-box-level subcategories-box-level-<?= $level; ?>" style="padding-left: <?= $level / 10 * 100; ?>px;">

    <?php

    foreach ($subcategories as $subcategory) {
    ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="category_ids[]" value="<?= $subcategory->id; ?>" data-parent-id="<?= $subcategory->parent->id; ?>" <?= in_array($subcategory->id, ArrayHelper::map($model->categories, 'id', 'id')) ? 'checked' : ''; ?>>
            <label class="custom-control-label"><?= $subcategory->title; ?></label>
        </div>
    <?php

        if (!empty($subcategory->subcategories)) {

            echo $this->render('_subcategories-part', ['model' => $model, 'subcategories' => $subcategory->subcategories, 'level' => $level + 1]);
        }
    }
    ?>
    </ul>