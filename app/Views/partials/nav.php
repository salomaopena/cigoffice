<!-- main menu-->

<!-- sidebar links-->
<p class="menu-group mb-3"><?= session()->user['restaurant_name'] ?></p>
<ul class="list-group-flush">
    <li class="list-group-item"><a href="<?= site_url('products') ?>"><i class="fa-solid fa-burger me-3"></i>Produtos</a></li>
    <li class="list-group-item"><a href="<?= site_url('/stocks') ?>"><i class="fa-solid fa-layer-group me-3"></i>Stocks</a>
    </li>
    <?php if(menu_is_available('admin')): ?>
    <li class="list-group-item"><a href="#"><i class="fa-solid fa-chart-column me-3"></i>Consumos</a></li>
    <li class="list-group-item"><a href="#"><i class="fa-solid fa-chart-line me-3"></i>Vendas</a></li>
    <li class="list-group-item"><a href="#"><i class="fa-solid fa-network-wired me-3"></i>API do Restaurante</a></li>
    <hr>
    <li class="list-group-item"><a href="<?= site_url('/users_management') ?>"><i class="fa-solid fa-user-gear me-3"></i>Gestão de Usuários</a></li>
    <?php endif;?>
    <hr>
    <li class="list-group-item"><a href="<?= site_url('/auth/profile') ?>"><i class="fa-solid fa-user-gear me-3"></i>Perfil do usuário</a></li>
    <li class="list-group-item"><a href="<?= site_url('/auth/logout') ?>"><i class="fa-solid fa-right-from-bracket me-3"></i>Sair</a></li>
</ul>