<?= $this->extend('layouts/layout-auth') ?>

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
                <option value="<?= Encrypt($restaurant->id) ?>" <?= $selected ?>><?= $restaurant->name ?></option>
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

    <?php if (!empty($login_error)): ?>
        <div class="alert alert-danger text-center p-1" role="alert">
            <?= $login_error ?>
        </div>
    <?php endif ?>

    <div class="text-center mt-1 login-link">
        <p class="text-muted">Esqueceu a senha? <a href="#">Recuperar</a></p>
    </div> <!-- fim-->
    <!-- criar conta-->
    <div class="text-center mt-1 login-link">
        <p class="text-muted">Não possui conta? <a href="login.html">Registar-se</a></p>
    </div> <!-- fim-->

    <div class="text-center mt-2 login-link">
        <p class="text-center text-muted mt-2">Ao continuar, você concoda com os nossos <a href="#">Termos
                de
                Uso</a> e <a href="#">Política de Privacidade</a></p>
    </div>
</div>


<!-- Bootstrap JS -->
<script>
    let wrapper = document.querySelector('.login-box');
    let loginData = [
        {
            email: 'admin1@email.com',
            password: 'admin1',
            restaurant: 1,
        },
        {
            email: 'user1@email.com',
            password: 'user1',
            restaurant: 1,
        },
        {
            email: 'admin2@email.com',
            password: 'admin2',
            restaurant: 2,
        },
        {
            email: 'user2@email.com',
            password: 'user2',
            restaurant: 2,
        },
        {
            email: 'admin3@email.com',
            password: 'admin3',
            restaurant: 3,
        },
        {
            email: 'user3@email.com',
            password: 'user3',
            restaurant: 3,
        }
        
    ];
    const select = document.createElement('select');
    select.appendChild(document.createElement('option'))
    select.setAttribute('name','select_login');
    loginData.forEach((item, index)=>{
        let option = document.createElement('option');
        option.setAttribute('value',index);
        option.innerHTML = `Restaurante ${item.restaurant} -> ${item.email}`
        select.appendChild(option);
    });
    wrapper.appendChild(select);
    select.addEventListener('change', function(e){
        const index = e.target.value;
        if (index=='') return;
        const restaurant = loginData[index].restaurant;
        const email = loginData[index].email;
        const password = loginData[index].password;

        document.querySelector('#restaurant_selected').selectedIndex = restaurant
        document.querySelector('#email').value = email
        document.querySelector('#password').value = password
    });
</script>

<?= $this->endSection() ?>