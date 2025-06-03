<?= $this->extend('layouts/layout-auth') ?>

<?= $this->section('content') ?>


<div class="login-box">

    <div class="text-center mb-3">
        <img class="img-fluid" src="<?= base_url('assets/images/logo.png') ?>" alt="logo" width="100">
    </div>

    <?= form_open('/auth/forgot_password_submit', ['novalidate'=> true]) ?>

    <div class="mb-3">
        <p class="mb-2">Restaurante</p>
        <select name="select_restaurant" id="select_restaurant" class="form-select">
            <option value="">--Selecione o restaurante--</option>
            <?php foreach ($restaurants as $restaurant): ?>

                <?php
                // Check if the restaurant is the one selected by the user
                $selected = '';
                if (!empty($selected_restaurant) && $selected_restaurant == $restaurant->id) {
                    $selected = 'selected';
                }
                ?>

                <option value="<?= Encrypt($restaurant->id) ?>" <?= $selected ?>><?= $restaurant->name ?></option>
            <?php endforeach; ?>
        </select>
        <?= display_error('select_restaurant', $validation_errors) ?>
    </div>
    <hr>

    <div class="mb-3">
        <label for="text_email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="text_email" name="text_email" placeholder="Digite seu e-mail" required value="<?= old('text_email') ?>">
        <?= display_error('text_email', $validation_errors) ?>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn-login px-4">Recuperar senha</button>
    </div>

    <div class="my-3">
        <p class="text-center">
            Sabe a senha? <a href="<?= base_url('auth/login') ?>">Voltar para o login</a>
        </p>
    </div>



    <?= form_close() ?>

</div>

<?= $this->endSection() ?>