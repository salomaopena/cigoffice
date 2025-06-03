<?= $this->extend('layouts/layout-auth') ?>

<?= $this->section('content') ?>


<div class="login-box">

    <div class="text-center mb-3">
        <img class="img-fluid" src="<?= base_url('assets/images/logo.png') ?>" alt="logo" width="100">
    </div>


    <div class="card">
        <div class="card-body">
            <h3 class="text-center mb-4">Redefinição da senha</h3>
            <p class="text-center"><?=$success_message?></p>
            <div class="text-center mt-4">
                <a href="<?= base_url('auth/login') ?>" class="btn-login px-4">Ir para Login</a>
            </div>
        </div>
    </div>

</div>


<?= $this->endSection() ?>