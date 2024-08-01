<?php

    use yii\widgets\LinkPager;

    if(isset($subcategories))
    {
        include('view_subcategories.php');
    }
    elseif(isset($pages))
    {
        include('view_'.$type.'.php');
    }

    if(isset($paginate))
    {
        $ajaxClass = null;

        if($ajaxload == 1)
        {
            $ajaxClass = ' pagination-ajax';
        }

        echo LinkPager::widget([
            'pagination' => $paginate,
            'options' => [
                'class' => 'pagination pagination-' . $type . $ajaxClass
            ],
            'linkOptions' => [
                'data-items' => json_encode($page_IDs),
                'data-target' => $type,
                'data-limit' => $paginate->limit
            ]
        ]);
    }

?>
