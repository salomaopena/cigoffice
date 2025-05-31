<?= $this->extend('layouts/layout-auth') ?>

<?= $this->section('content') ?>


<div class="login-box">

    <div class="text-center mb-3">
        <img class="img-fluid" src="<?= base_url('assets/images/logo.png') ?>" alt="logo" width="100">
    </div>
    <h1 class="text-center mb-4">Bem-vindo ao Cig Burguer</h1>
    <a href="<?= site_url('/auth/login')?>" class="btn btn-login">login</a>
</div>

<?= $this->endSection() ?>