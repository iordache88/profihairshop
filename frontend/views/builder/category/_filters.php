<?php
    use backend\models\Categories;
    use common\models\Customfield;
    use yii\bootstrap4\ActiveForm;
    use yii\web\View;
    use yii\helpers\ArrayHelper;

    if(!isset($slug))
    {
        $slug = $_GET['slug'];
    }
    $category = Yii::$app->category->showSingle(null, $slug);

    if(!isset($catID))
    {
        $catID = $category->ID;
    }

    $filtersAttr = [
        'accesorii' => [18],
        'baterii' => [18, 22, 26]
    ];

    $showsOn = array_keys($filtersAttr);
?>

<?php if(in_array($slug, $showsOn)) : ?>

<div class="products-filter-box">
    
    <?php ActiveForm::begin([
        'id' => 'form-filter-products',
        'method' => 'get',
        'action' => [
            \yii\helpers\Url::to(['/'.$slug])
        ]

    ]) ?>

    <h5>Filtre: <?= $category->title ?> <a href="/<?= $slug ?>" class="reset-filters">Resetează filtre</a></h5>

    <div class="row row-products-filters">
        <div class="col-md-3 desktop-hide">
            <div class="form-group">
                <label for="">Categorie</label>
                <select class="form-control" data-filter="category" name="filter_category">
                    <option value="">Alege</option>

                    <?php
                        foreach($category->childs as $child)
                        {
                            $selected = null;
                            if($_GET['filter_category'] == $child->ID)
                            {
                                $selected = 'selected=""';
                            }
                            echo '<option value="'.$child->ID.'" '.$selected.'>'.$child->title.'</option>';
                        }
                    ?>

                </select>
            </div>
        </div>
        
        <?php foreach($filtersAttr[$slug] as $attrID) : ?>

            <div class="col-md-3">
                <div class="form-group">
                    <label for=""><?= Yii::$app->fields->showSingle($attrID, 'title') ?></label>
                    <select class="form-control" data-filter="attr" name="filter_attr[<?= $attrID ?>]">
                        <option value="">Alege</option>

                        <?php
                            $fieldData = Yii::$app->runAction('requests/getproductattr', ['category'=>$catID, 'attr'=>$attrID, 'page_IDs'=>json_encode($page_IDs)]);

                            foreach($fieldData as $field)
                            {
                                $selected = null;
                                if($_GET['filter_attr'][$attrID] == $field->ID)
                                {
                                    $selected = 'selected=""';
                                }
                                echo '<option value="'.$field->ID.'" '.$selected.'>'.$field->title.'</option>';
                            }
                        ?>

                    </select>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
    
<?php ActiveForm::end(); ?>
</div>

<?php endif; ?>