<?php 

use yii\helpers\Url;
?>

<div class="fixed-plugin" data-url="<?= Url::to(['site/update-theme-settings']); ?>">
	<a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
		<i class="material-icons py-2">settings</i>
	</a>
	<div class="card shadow-lg">
		<div class="card-header pb-0 pt-3">
			<div class="float-start">
				<h5 class="mt-3 mb-0">ADMIN Settings</h5>
				<p>Change theme options.</p>
			</div>
			<div class="float-end mt-4">
				<button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
					<i class="material-icons">clear</i>
				</button>
			</div>
			<!-- End Toggle Button -->
		</div>
		<hr class="horizontal dark my-1">
		<div class="card-body pt-sm-3 pt-0">
			<!-- Sidebar Backgrounds -->
			<div>
				<h6 class="mb-0">Sidebar colors</h6>
			</div>
			<a href="javascript:void(0)" class="switch-trigger background-color">
				<div class="badge-colors my-2 text-start">
					<span class="badge filter bg-gradient-primary <?= $sidebar_color == 'primary' ? 'active' : ''; ?>" data-color="primary" onclick="sidebarColor(this)"></span>
					<span class="badge filter bg-gradient-dark <?= $sidebar_color == 'dark' ? 'active' : ''; ?>" data-color="dark" onclick="sidebarColor(this)"></span>
					<span class="badge filter bg-gradient-info <?= $sidebar_color == 'info' ? 'active' : ''; ?>" data-color="info" onclick="sidebarColor(this)"></span>
					<span class="badge filter bg-gradient-success <?= $sidebar_color == 'success' ? 'active' : ''; ?>" data-color="success" onclick="sidebarColor(this)"></span>
					<span class="badge filter bg-gradient-warning <?= $sidebar_color == 'warning' ? 'active' : ''; ?>" data-color="warning" onclick="sidebarColor(this)"></span>
					<span class="badge filter bg-gradient-danger <?= $sidebar_color == 'danger' ? 'active' : ''; ?>" data-color="danger" onclick="sidebarColor(this)"></span>
				</div>
			</a>

			<!-- Sidenav Type -->

			<div class="mt-3">
				<h6 class="mb-0">Sidebar look</h6>
				<p class="text-sm">Choose sitebar look.</p>
			</div>

			<div class="d-flex">
				<button class="btn bg-gradient-dark px-3 mb-2 btn_sidebar_type <?= $sidebar_type == 'bg-gradient-dark' ? 'active' : ''; ?>" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
				<button class="btn bg-gradient-dark px-3 mb-2 ms-2 btn_sidebar_type <?= $sidebar_type == 'bg-transparent' ? 'active' : ''; ?>" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
				<button class="btn bg-gradient-dark px-3 mb-2 ms-2 btn_sidebar_type  <?= $sidebar_type == 'bg-white' ? 'active' : ''; ?>" data-class="bg-white" onclick="sidebarType(this)">Alb</button>
			</div>

			<p class="text-sm d-xl-none d-block mt-2">You can change it only in desktop mode.</p>


			<!-- Navbar Fixed -->

			<div class="mt-3 d-flex">
				<h6 class="mb-0">Navbar Fix</h6>
				<div class="form-check form-switch ps-0 ms-auto my-auto">
					<input class="form-check-input mt-1 ms-auto" <?= $navbar_fixed == 1 ? 'checked="true"' : ''; ?> type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
				</div>
			</div>



			<hr class="horizontal dark my-3">
			<div class="mt-2 d-flex">
				<h6 class="mb-0">Sidebar mini</h6>
				<div class="form-check form-switch ps-0 ms-auto my-auto">
					<input class="form-check-input mt-1 ms-auto" <?= $navbar_minimize == 1 ? 'checked="true"' : ''; ?> type="checkbox" id="navbarMinimize" onclick="navbarMinimize(this)">
				</div>
			</div>


			<hr class="horizontal dark my-3">
			<div class="mt-2 d-flex">
				<h6 class="mb-0">Light / Dark</h6>
				<div class="form-check form-switch ps-0 ms-auto my-auto">
					<input class="form-check-input mt-1 ms-auto" <?= $dark_mode == 1 ? 'checked="true"' : ''; ?>  type="checkbox" id="dark-version" onclick="darkMode(this)">
				</div>
			</div>
			<hr class="horizontal dark my-sm-4">


			<a class="btn bg-gradient-primary w-100" href="<?= Url::to(['user/settings']); ?>">Profile settings</a>

			<a class="btn btn-outline-dark w-100" href="#">Tutorials</a>

			<div class="w-100 text-center">

				<a href="/" class="btn btn-dark mb-0 me-2 w-100" target="_blank">
					View site
				</a>

			</div>
		</div>
	</div>
</div>