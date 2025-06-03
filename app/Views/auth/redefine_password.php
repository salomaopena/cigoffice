<?= $this->extend('layouts/layout-auth') ?>

<?= $this->section('content') ?>


<div class="login-box">

    <div class="text-center mb-3">
        <img class="img-fluid" src="<?= base_url('assets/images/logo.png') ?>" alt="logo" width="100">
    </div>

    <div class="card p-3 mb-3">
        <h5 class="text-center mb-3">Recuperar senha</h5>
        <p class="text-center">Deve conter entre 8 e 16 caracteres, pelo menos uma miúscula, uma minúscula e um algarismo.</p>
    </div>

    <?= form_open('/auth/reset_password_submit', ['novalidate' => true]) ?>

     <input type="hidden" name="purl_code" value="<?= $pul_code ?>">

    <div class="mb-3">
        <input type="password" class="form-control" name="text_password" id="text_password" placeholder="Senha">
        <?= display_error('text_password', $validation_errors) ?>
    </div>
    <hr>

    <div class="mb-3">
        <input type="password" class="form-control" id="text_password_confirm" name="text_password_confirm" placeholder="Confirmar Senha" required value="<?= old('text_password_confirm') ?>">
        <?= display_error('text_password_confirm', $validation_errors) ?>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn-login px-4">Redefinir senha</button>
    </div>

    <?= display_error('purl_code', $validation_errors) ?>

    <?= form_close() ?>

</div>

<?= $this->endSection() ?>