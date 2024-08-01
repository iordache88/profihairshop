<?php 

use yii\helpers\Url;
use yii\helpers\Html;


?>
<ul class="subcategories-list-level subcategories-list-level-<?= $level; ?>">
    
    <?php 

    foreach ($subcategories as $model) {
        ?>
        <li>
            <a href="<?= Url::to(['category/edit', 'id' => $model->id]);?>"><i class="fas fa-edit"></i>&nbsp;<?= $model->title; ?></a>
            <?=
            Html::a('<i class="material-icons text-danger position-relative text-lg">delete</i></i>', ['category/delete', 'id' => $model->id], [
                'title' => "Delete",
                'class' => 'btn_delete_category',
                'data' => [
                    'method' => 'post',
                    'confirm' => 'Are you sure?',
                    'pjax' => 0,
                ],
            ]);
            ?>
        </li>
        <?php

        if(!empty($model->subcategories)) {

            echo $this->render('_subcategories-part', ['subcategories' => $model->subcategories, 'level' => $level + 1]);
        }
    }
    ?>
</ul>