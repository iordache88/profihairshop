<?php 
use yii\helpers\Url;
 ?>

<div class="card h-100 mt-4 mt-md-0">
    <div class="card-header pb-0 p-3">
        <div class="d-flex align-items-center">
            <h6>Users</h6>
            <button type="button" class="btn btn-icon-only btn-rounded btn-outline-success mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="All users in this list are active">
                <i class="material-icons text-sm">done</i>
            </button>
        </div>
    </div>
    <div class="card-body px-3 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {
                    ?>
                        <tr>
                            <td>
                                <p class="text-sm font-weight-normal mb-0"><?= $user->name; ?></p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-normal mb-0"><?= $user->email; ?></p>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td>
                            <p class="text-sm font-weight-normal mb-0">
                                <a href="<?= Url::to(['logs/index']); ?>"><i class="fas fa-plus"></i> Add user</a>
                            <p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>