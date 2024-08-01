<?php 

use yii\helpers\Url;

?>

<ul class="nav nav-settings flex-column bg-white border-radius-lg p-3">
    <li class="nav-item pt-2 <?= $this->context->action->id === 'general' ? 'active' : ''; ?>">
        <a class="nav-link d-flex" data-scroll="" href="<?= Url::to(['settings/general']) ;?>">
            <i class="material-icons text-lg me-2">settings_applications</i>
            <span class="text-sm">General</span>
        </a>
    </li>

    <li class="nav-item pt-2 <?= $this->context->action->id === 'front-page' ? 'active' : ''; ?>">
        <a class="nav-link d-flex" data-scroll="" href="<?= Url::to(['settings/front-page']) ;?>">
            <i class="material-icons text-lg me-2">receipt_long</i>
            <span class="text-sm">Front page</span>
        </a>
    </li>

    <li class="nav-item pt-2 <?= $this->context->action->id === 'code-scripts' ? 'active' : ''; ?>">
        <a class="nav-link d-flex" data-scroll="" href="<?= Url::to(['settings/code-scripts']) ;?>">
            <i class="material-icons text-lg me-2">code</i>
            <span class="text-sm">Code, Scripts</span>
        </a>
    </li>

    <li class="nav-item pt-2 <?= $this->context->action->id === 'custom-css' ? 'active' : ''; ?>">
        <a class="nav-link d-flex" data-scroll="" href="<?= Url::to(['settings/custom-css']) ;?>">
            <i class="material-icons text-lg me-2">css</i>
            <span class="text-sm">Custom CSS</span>
        </a>
    </li>

    <li class="nav-item pt-2 <?= $this->context->action->id === 'custom-js' ? 'active' : ''; ?>">
        <a class="nav-link d-flex" data-scroll="" href="<?= Url::to(['settings/custom-js']) ;?>">
            <i class="material-icons text-lg me-2">javascript</i>
            <span class="text-sm">Custom JS</span>
        </a>
    </li>

    <li class="nav-item pt-2 <?= $this->context->action->id === 'header' ? 'active' : ''; ?>">
        <a class="nav-link d-flex" href="<?= Url::to(['settings/header']) ;?>">
            <i class="material-icons text-lg me-2">menu</i>
            <span class="text-sm">Header</span>
        </a>
    </li>

    <li class="nav-item pt-2 <?= $this->context->action->id === 'footer' ? 'active' : ''; ?>">
        <a class="nav-link d-flex" href="<?= Url::to(['settings/footer']) ;?>">
            <i class="material-icons text-lg me-2">info</i>
            <span class="text-sm">Footer</span>
        </a>
    </li>

    <li class="nav-item pt-2">
        <a class="nav-link d-flex" href="<?= Url::to(['page-type/index']); ?>">
            <i class="material-icons text-lg me-2">pages</i>
            <span class="text-sm">Page types</span>
        </a>
    </li>

    <li class="nav-item pt-2">
        <a class="nav-link d-flex" data-scroll="" href="#accounts">
            <i class="material-icons text-lg me-2">badge</i>
            <span class="text-sm">Users</span>
        </a>
    </li>

    <li class="nav-item pt-2">
        <a class="nav-link d-flex" data-scroll="" href="#profile">
            <i class="material-icons text-lg me-2">person</i>
            <span class="text-sm">My Profile</span>
        </a>
    </li>
    
    <li class="nav-item pt-2">
        <a class="nav-link d-flex" data-scroll="" href="#password">
            <i class="material-icons text-lg me-2">lock</i>
            <span class="text-sm">Change Password</span>
        </a>
    </li>




</ul>