<<?= $this->extend('layouts/layout-auth') ?>

    <?= $this->section('content') ?>


    <div class="login-box">

    <div class="text-center mb-3">
        <img class="img-fluid" src="<?= base_url('assets/images/logo.png') ?>" alt="logo" width="100">
    </div>


    <?= form_open('auth/login-submit', ['novalidate' => true]) ?>
    <div class="mb-3">
        <select name="restaurant_selected" id="restaurant_selected" class="form-control">
            <option value=""></option>
            <?php foreach ($restaurants as $restaurant) : ?>
                <?php
                $selected = '';
                if (!empty($restaurant_selected) && $restaurant_selected == $restaurant->id) {
                    $selected = 'selected';
                } ?>
                <option value="<?=Encrypt($restaurant->id)?>"<?=$selected?>><?= $restaurant->name ?></option>
            <?php endforeach ?>
        </select>
        <?= display_error('restaurant_selected', $validation_errors) ?>
    </div>
    <div class="mb-3">
        <input name="email" type="email" value="<?= old('email') ?>" class="form-control" id="email" placeholder="Email">
        <?= display_error('email', $validation_errors) ?>
    </div>
    <div class="mb-3">
        <input name="password" type="password" value="<?= old('password') ?>" class="form-control" id="password" placeholder="Password">
        <?= display_error('password', $validation_errors) ?>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary btn-block btn-login">Login</button>
    </div>
    <?= form_close() ?>
    <div class="text-center mt-1 login-link">
        <p class="text-muted">Esqueceu a senha? <a href="#">Recuperar</a></p>
    </div> <!-- fim-->
    <!-- criar conta-->
    <div class="text-center mt-1 login-link">
        <p class="text-muted">Não possui conta? <a href="login.html">Registar-se</a></p>

        <!-- script for password strength indicator-->
        <script src="password-strength-indicator.js"></script>
    </div> <!-- fim-->

    <div class="text-center mt-2 login-link">
        <p class="text-center text-muted mt-2">Ao continuar, você concoda com os nossos <a href="#">Termos
                de
                Uso</a> e <a href="#">Política de Privacidade</a></p>
    </div>
    </div>

    <?= $this->endSection() ?>