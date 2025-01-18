<!-- to bar-->
<header class="top-bar d-flex justify-content-between align-items-center sidebar-collapse fixed-top">
    <div class="d-flex">
        <div class="btn-main-menu me-3">
            <i class="fa-solid fa-bars"></i>
        </div>
        <a href="<?=site_url('/')?>"><img class="img-fluid" src="<?=base_url('assets/images/logo.png')?>" alt="logo" width="48px"></a>
    </div>
    <div>
        <!-- User | Logout-->
        <i class="fa-solid fa-user me-3"></i><?=session()->user['first_name']?> <?=session()->user['last_name']?>
        <i class="fa-solid fa-ellipsis-vertical mx-3"></i>
        <a href="<?=site_url('auth/logout')?>"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
    </div>
</header>