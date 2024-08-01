<?php 

use yii\helpers\Url;

$user_details = Yii::$app->user->identity->details;

?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 <?= $sidebar_type; ?>" id="sidenav-main" <?= !empty($sidebar_color) ? 'data-color="' . $sidebar_color . '"' : ''; ?>>

	<div class="sidenav-header">
		<i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
		<a class="navbar-brand m-0" href="/" target="_blank">
			<img src="/backend/web/theme/img/p.png" class="navbar-brand-img h-100" alt="main_logo">
			<span class="ms-1 font-weight-bold text-white"><?= Yii::$app->name; ?></span>
		</a>
	</div>


	<hr class="horizontal light mt-0 mb-2">

	<div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
		<ul class="navbar-nav">


			<li class="nav-item mb-2 mt-0">
				<a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?>" aria-controls="ProfileNav" role="button" aria-expanded="false">
					<img src="/backend/web/theme/img/team-3.jpg" class="avatar">
					<span class="nav-link-text ms-2 ps-1"><?= $user_details->first_name; ?> <?= $user_details->last_name; ?></span>
				</a>
				<div class="collapse" id="ProfileNav">
					<ul class="nav ">
						<li class="nav-item">
							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?>" href="#">
								<span class="sidenav-mini-icon"> MP </span>
								<span class="sidenav-normal  ms-3  ps-1"> My account </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="<?= Url::to(['site/logout']); ?>" data-method="post">
								<span class="sidenav-mini-icon"> L </span>
								<span class="sidenav-normal  ms-3  ps-1"> Logout </span>
							</a>
						</li>
					</ul>
				</div>
			</li>

			<hr class="horizontal light mt-0">


			<li class="nav-item">


				<a href="<?= Url::base($schema = true); ?>" class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?>" aria-controls="applicationsExamples" role="button" aria-expanded="false">

					<i class="material-icons-round opacity-10">dashboard</i>

					<span class="nav-link-text ms-2 ps-1">Dashboard</span>
				</a>
			</li>


			<li class="nav-item mt-3">
				<h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?>">SITE</h6>
			</li>

			<li class="nav-item">
				<a data-bs-toggle="collapse" href="#ecommerceExamples" class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-controls="ecommerceExamples" role="button" aria-expanded="false">

					<i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">shopping_basket</i>
					<span class="nav-link-text ms-2 ps-1">Ecommerce</span>
				</a>

				<div class="collapse " id="ecommerceExamples">
					<ul class="nav ">

						<li class="nav-item ">

							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " data-bs-toggle="collapse" aria-expanded="false" href="#productsExample">
								<span class="sidenav-mini-icon"> P </span>
								<span class="sidenav-normal  ms-2  ps-1"> Products <b class="caret"></b></span>
							</a>

							<div class="collapse " id="productsExample">
								<ul class="nav nav-sm flex-column">

									<li class="nav-item">

										<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="./ecommerce/products/new-product.html">
											<span class="sidenav-mini-icon"> V </span>
											<span class="sidenav-normal  ms-2  ps-1"> Products list </span>
										</a>

									</li>

									<li class="nav-item">

										<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="./ecommerce/products/edit-product.html">
											<span class="sidenav-mini-icon"> A </span>
											<span class="sidenav-normal  ms-2  ps-1"> Add product </span>
										</a>
									</li>
								</ul>
							</div>


						</li>



						<li class="nav-item ">

							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " data-bs-toggle="collapse" aria-expanded="false" href="#productsExample">
								<span class="sidenav-mini-icon"> C </span>
								<span class="sidenav-normal  ms-2  ps-1"> Categories <b class="caret"></b></span>
							</a>

							<div class="collapse " id="productsExample">
								<ul class="nav nav-sm flex-column">

									<li class="nav-item">

										<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="<?= Url::to(['category/index', 'target' => 'product']); ?>">
											<span class="sidenav-mini-icon"> V </span>
											<span class="sidenav-normal  ms-2  ps-1"> View all </span>
										</a>

									</li>

									<li class="nav-item">

										<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="<?= Url::to(['category/add', 'target' => 'product']); ?>">
											<span class="sidenav-mini-icon"> A </span>
											<span class="sidenav-normal  ms-2  ps-1"> Add category </span>
										</a>
									</li>
								</ul>
							</div>


						</li>



						<li class="nav-item ">
							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " data-bs-toggle="collapse" aria-expanded="false" href="#ordersExample">
								<span class="sidenav-mini-icon"> C </span>
								<span class="sidenav-normal  ms-2  ps-1"> Orders <b class="caret"></b></span>
							</a>

							<div class="collapse " id="ordersExample">
								<ul class="nav nav-sm flex-column">

									<li class="nav-item">

										<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="./ecommerce/orders/list.html">
											<span class="sidenav-mini-icon"> O </span>
											<span class="sidenav-normal  ms-2  ps-1"> Orders list </span>
										</a>

									</li>
								</ul>
							</div>
						</li>



						<li class="nav-item ">
							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="#">
								<span class="sidenav-mini-icon"> R </span>
								<span class="sidenav-normal  ms-2  ps-1"> Settings </span>
							</a>

							
						</li>


					</ul>
				</div>


			</li>


			<li class="nav-item">


				<a data-bs-toggle="collapse" href="#pagesExamples" class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-controls="pagesExamples" role="button" aria-expanded="false">

					<i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">description</i>

					<span class="nav-link-text ms-2 ps-1">Pages</span>
				</a>

				<div class="collapse " id="pagesExamples">
					<ul class="nav ">

						<li class="nav-item ">
							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-expanded="false" href="<?= Url::to(['page/index']); ?>">
								<span class="sidenav-mini-icon"> P </span>
								<span class="sidenav-normal  ms-2  ps-1"> View all <b class="caret"></b></span>
							</a>
						</li>

						<li class="nav-item ">
							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-expanded="false" href="<?= Url::to(['page/add']); ?>">
								<span class="sidenav-mini-icon"> P </span>
								<span class="sidenav-normal  ms-2  ps-1"> Add page <b class="caret"></b></span>
							</a>
						</li>

						<li class="nav-item ">
							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-expanded="false" href="<?= Url::to(['category/index', 'target' => 'page']); ?>">
								<span class="sidenav-mini-icon"> C </span>
								<span class="sidenav-normal  ms-2  ps-1"> Categories <b class="caret"></b></span>
							</a>
						</li>

					</ul>
				</div>


			</li>


			<?php 
			foreach($page_types as $page_type) {
				?>
				<li class="nav-item">


					<a data-bs-toggle="collapse" href="#<?= $page_type->type; ?>Examples" class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-controls="<?= $page_type->type; ?>Examples" role="button" aria-expanded="false">

						<i class="material-icons-round"><?= $page_type->icon; ?></i>

						<span class="nav-link-text ms-2 ps-1"><?= $page_type->name_plural ;?></span>
					</a>

					<div class="collapse " id="<?= $page_type->type; ?>Examples">
						<ul class="nav ">

							<li class="nav-item ">
								<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-expanded="false" href="<?= Url::to([$page_type->type . '/index']); ?>">
									<span class="sidenav-mini-icon"> P </span>
									<span class="sidenav-normal  ms-2  ps-1"> View all <b class="caret"></b></span>
								</a>
							</li>

							<li class="nav-item ">
								<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-expanded="false" href="<?= Url::to([$page_type->type . '/add']); ?>">
									<span class="sidenav-mini-icon"> P </span>
									<span class="sidenav-normal  ms-2  ps-1"> Add <?= strtolower($page_type->name_singular); ?> <b class="caret"></b></span>
								</a>
							</li>

							<li class="nav-item ">
								<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-expanded="false" href="<?= Url::to(['category/index', 'target' => $page_type->type]); ?>">
									<span class="sidenav-mini-icon"> C </span>
									<span class="sidenav-normal  ms-2  ps-1"> Categories <b class="caret"></b></span>
								</a>
							</li>

						</ul>
					</div>


				</li>
				<?php
			}
			?>



			<li class="nav-item">


				<a href="<?= Url::to(['menu/index', 'Menu' => ['parent_id' => 1]]); ?>" class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-controls="applicationsExamples" role="button" aria-expanded="false">

					<i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">apps</i>

					<span class="nav-link-text ms-2 ps-1">Menu</span>
				</a>
			</li>





			<li class="nav-item">


				<a href="<?= Url::to(['media/index']); ?>" class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-controls="authExamples" role="button" aria-expanded="false">

					<i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">image</i>

					<span class="nav-link-text ms-2 ps-1">Media</span>
				</a>

			</li>


			<li class="nav-item">


				<a data-bs-toggle="collapse" href="#settings" class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-controls="settings" role="button" aria-expanded="false">

					<i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">settings</i>

					<span class="nav-link-text ms-2 ps-1">Settings <b class="caret"></b></span>
				</a>

				<div class="collapse " id="settings">
					<ul class="nav nav-sm flex-column">

						<li class="nav-item">

							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="<?= Url::to(['settings/general']); ?>">
								<span class="sidenav-mini-icon"> G </span>
								<span class="sidenav-normal  ms-2  ps-1"> General </span>
							</a>

						</li>

						<li class="nav-item">

							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="<?= Url::to(['settings/header']) ;?>">
								<span class="sidenav-mini-icon"> H </span>
								<span class="sidenav-normal  ms-2  ps-1"> Header </span>
							</a>

						</li>

						<li class="nav-item">

							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="<?= Url::to(['settings/footer']); ?>">
								<span class="sidenav-mini-icon"> F </span>
								<span class="sidenav-normal  ms-2  ps-1"> Footer </span>
							</a>

						</li>

						<li class="nav-item">

							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="<?= Url::to(['settings/front-page']); ?>">
								<span class="sidenav-mini-icon"> A </span>
								<span class="sidenav-normal  ms-2  ps-1"> Front page </span>
							</a>

						</li>

						<li class="nav-item">

							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="<?= Url::to(['page-type/index']); ?>">
								<span class="sidenav-mini-icon"> T </span>
								<span class="sidenav-normal  ms-2  ps-1"> Page types </span>
							</a>

						</li>

						<li class="nav-item">

							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="<?= Url::to(['global-section/index']); ?>">
								<span class="sidenav-mini-icon"> G </span>
								<span class="sidenav-normal  ms-2  ps-1"> Global sections </span>
							</a>

						</li>

						<li class="nav-item">

							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " href="<?= Url::to(['settings/users']); ?>">
								<span class="sidenav-mini-icon"> U </span>
								<span class="sidenav-normal  ms-2  ps-1"> Users </span>
							</a>

						</li>
					</ul>
				</div>
			</li>



			<li class="nav-item">
				<hr class="horizontal light" />
				<h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?>">INFO</h6>
			</li>

			<li class="nav-item">


				<a data-bs-toggle="collapse" href="#basicExamples" class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-controls="basicExamples" role="button" aria-expanded="false">

					<i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">upcoming</i>

					<span class="nav-link-text ms-2 ps-1">Tutorials</span>
				</a>

				<div class="collapse " id="basicExamples">
					<ul class="nav ">
						<li class="nav-item ">

							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?>" aria-expanded="false" href="#">
								<span class="sidenav-mini-icon"> D </span>
								<span class="sidenav-normal  ms-2  ps-1"> Documentation <b class="caret"></b></span>
							</a>

						</li>

						<li class="nav-item ">
							<a class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?>" aria-expanded="false" href="#">
								<span class="sidenav-mini-icon"> V </span>
								<span class="sidenav-normal  ms-2  ps-1"> Videos <b class="caret"></b></span>
							</a>
						</li>
					</ul>
				</div>


			</li>



			<li class="nav-item">


				<a href="<?= Url::to(['log/index']); ?>" class="nav-link <?= ( $sidebar_type === 'bg-gradient-dark' || ($dark_mode && $sidebar_type !== 'bg-white') ) ? 'text-white' : 'text-dark'; ?> " aria-controls="authExamples" role="button" aria-expanded="false">

					<i class="material-icons-round">event_note</i>

					<span class="nav-link-text ms-2 ps-1">Logs</span>
				</a>

			</li>





		</ul>
	</div>

</aside>