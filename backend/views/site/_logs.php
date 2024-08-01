<?php 
use yii\helpers\Url;
 ?>
<div class="card h-100 mt-4 mt-md-0">
    <div class="card-header pb-0 p-3">
        <div class="d-flex align-items-center">
            <h6>Logs</h6>
        </div>
    </div>
    <div class="card-body px-3 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Info</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($logs as $log) {
                    ?>
                        <tr>
                            <td>
                                <p class="text-sm font-weight-normal mb-0"><?= $log->title; ?></p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-normal mb-0"><?= $log->user->name; ?></p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-normal mb-0"><?= ucfirst($log->category); ?></p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-normal mb-0"><?= ucfirst($log->type); ?></p>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td>
                            <p class="text-sm font-weight-normal mb-0"><a href="<?= Url::to(['logs/index']); ?>"> <i class="fas fa-eye"></i> View all</a>
                            <p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>