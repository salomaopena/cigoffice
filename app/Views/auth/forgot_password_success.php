<?= $this->extend('layouts/layout-auth') ?>
<?= $this->section('content') ?>

<div class="login-box">

    <div class="text-center mb-3">
        <img class="img-fluid" src="<?= base_url('assets/images/logo.png') ?>" alt="logo" width="100">
    </div>

    <h3 class="text-center">Recuperação de senha</h3>
    <p class="text-center">Se o e-mail informado existir em nosso sistema, você receberá uma mensagem com instruções para redefinir sua senha.</p>

    <div class="text-center">
        <a href="<?= base_url('auth/login') ?>" class="btn-login px-4">Voltar para o login</a>
    </div>
</div>
<?= $this->endSection() ?>