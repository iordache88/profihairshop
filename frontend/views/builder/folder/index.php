<?php
	use yii\helpers\FileHelper;
	$content = Yii::$app->tools->decodeBody($_bodyContent);
	if(!empty($_id))
	{
		$id = 'id="'.$_id.'"';
	}
?>

<div <?= $id ?> class="module module-folder <?= $_class ?>">

<?php

if(!empty($media)) {

                switch ($type) 
				{
                    case 'pdf_only':

                        echo '<div class="row row-folder-pdf">';

                        foreach ($media as $key => $item) {

                            $src = '/uploads/'. $folder .'/'. $item->url;

                            $src_server = Yii::getAlias('@frontend') . '/web' . $src;

                            $mimeType = FileHelper::getMimeType($src_server);

                            if(strpos($mimeType, 'pdf') !== false) : ?>


                            <div class="col-12 col-md-6 col-lg-4 col-folder-pdf">

                                <div class="folder-item folder-item-pdf">
                                    <div class="item-pdf-image">
                                        <a href="<?= $src ?>" target="_blank">
                                            <img class="img-fluid img-pdf" src="<?= is_readable($src_server . '.jpg') ? $src . '.jpg' : '/uploads/icon/pdf.png' ?>" alt="<?= 'PDF Icon' ?>">
                                        </a>
                                    </div>
                                    <h4><a href="<?= $src ?>" target="_blank"><?= $item->title ?></a></h4>
                                    <p><?= $item->description ?></p>
                                </div>
                            </div>

                            <?php

                            endif;
                        }


                        echo '</div>';


                        break;
                    
                    case 'images_only':

						echo '<div class="row row-folder-images">';

						foreach ($media as $item) {

							$src = '/uploads/'. $folder .'/'. $item->url;

							$mimeType = FileHelper::getMimeType($src);

							if(strpos($mimeType, 'image') !== false) : ?>


							<div class="col-12 col-md-6 col-lg-4 col-folder-image">
								<div class="folder-item folder-item-image">
									<img class="img-fluid" src="<?= $src ?>" alt="<?= $item->alt_title ?>">
								</div>
							</div>

							<?php

							endif;
						}

						echo '</div>';

						break;

					case 'mixed':
					default: 

						echo '<div class="row row-folder-mixed">';

						foreach ($media as $key => $item) {

							echo '<div class="col-12 col-md-6 col-lg-4 col-folder-mixed">';

							$src = '/uploads/'. $folder .'/'. $item->url;
							$mimeType = FileHelper::getMimeType($src);

							$src_server = Yii::getAlias('@frontend') . '/web' . $src;


							if(strpos($mimeType, 'image') !== false) : ?>


							<div class="folder-item folder-item-image">
								<div class="item-logo">
									<img class="img-fluid" src="<?= $src ?>" alt="<?= $item->alt_title ?>">
								</div>
							</div>

							<?php

							elseif(strpos($mimeType, 'pdf') !== false) : ?>

							<div class="folder-item folder-item-pdf text-center">
								<div class="item-pdf-image">
									<a href="<?= $src ?>" target="_blank">
										<img class="img-fluid img-pdf" src="<?= is_readable($src_server . '.jpg') ? $src . '.jpg' : '/uploads/icon/pdf.png' ?>" alt="<?= 'PDF Icon' ?>">
									</a>
								</div>
								<h4><a href="<?= $src ?>" target="_blank"><?= $item->title ?></a></h4>
								<p><?= $item->description ?></p>
							</div>
                            

							<?php

							endif;

							echo '</div>';
							
						}

						echo '</div>';
                        break;
                }
			}
		?>

</div>


