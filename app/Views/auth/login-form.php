<<?= $this->extend('layouts/layout-auth') ?>

    <?= $this->section('content') ?>


    <div class="login-box">

    <div class="text-center mb-3">
        <img class="img-fluid" src="<?= base_url('assets/images/logo.png')?>" alt="logo" width="100">
    </div>


    <form>
        <div class="mb-3">
            <select name="restaurante" id="restaurante" class="form-control">
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="guest">Guest</option>
            </select>
        </div>
        <div class="mb-3">
            <input name="txt-email" type="email" class="form-control" id="email" placeholder="Email address">
        </div>
        <div class="mb-3">
            <input name="txt-password" type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary btn-block btn-login">Login</button>
        </div>
    </form>
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