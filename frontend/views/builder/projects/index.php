<?php
	$content = Yii::$app->tools->decodeBody($_bodyContent);
	if(!empty($_id))
	{
		$id = 'id="'.$_id.'"';
	}
?>

<div <?= $id ?> class="module module-projects <?= $_class ?>">

    <div class="row row-projects">

        
        <?php 
        
        $projects = $dataProvider->getModels();

        foreach($projects as $project) : 
        
        ?>
        

        <div class="col-12 col-lg-<?= $colsize ?>">
                
            <div class="project-item">

                <div class="project-item-image mb-3">
                    <a href="/<?= $project->slug ?>">
                        <img class="img-fluid" src="<?= Yii::$app->media->showImg($project->featured_image) ?>" alt="">
                    </a>
                </div>
                <div class="project-item-title">
                    <h3><a href="/<?= $project->slug ?>"><?= $project->title ?></a></h3>
                </div>

            </div>

        
        </div>


        <?php endforeach; ?>
    </div>


</div>