<?= $this->extend('layouts/layout-auth') ?>

<?= $this->section('content') ?>


<div class="login-box">

    <div class="text-center mb-3">
        <img class="img-fluid" src="<?= base_url('assets/images/logo.png') ?>" alt="logo" width="100">
    </div>

    <div class="card p-3 mb-3">
        <p class="mb-0">Bem-vindo, <strong><?= session()->new_user['username'] ?></strong> </p>
        <p class="mb-0">Nome: <strong><?= session()->new_user['first_name'] ?> <?= session()->new_user['last_name'] ?></strong></p>
        <p class="mb-0">Email: <strong><?= session()->new_user['email'] ?></strong></p>
        <p class="my-3 text-center px-3">Neste quadro deverá definar a sua senha para que conlua o registro no <strong><?= session()->new_user['restaurant_name'] ?></strong></p>
        <small>Deve conter entre 8 e 16 caracteres, pelo menos uma maúscula, uma minúscula e um algarismo</small>
    </div>

    <?= form_open('/auth/define_password_submit') ?>
    <h3 class="text-center mb-4">Defina sua senha</h3>

    <div class="mb-3">
        <label for="text_password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="text_password" name="password" required minlength="8" maxlength="16">
        <?= display_error('text_password', $validation_errors) ?>
    </div>
    <div class="mb-3">
        <label for="text_password_confirm" class="form-label">Confirme a Senha</label>
        <input type="password" class="form-control" id="text_password_confirm" name="password_confirm" required minlength="8" maxlength="16">
        <?= display_error('text_password_confirm', $validation_errors) ?>

    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Definir Senha</button>
    </div>
    <?= form_close() ?>

</div>

<?= $this->endSection() ?>