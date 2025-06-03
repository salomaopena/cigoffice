<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>

<div class="content">
    <div class="row my-4">
        <div class="col text-center">
            <img class="img-fluid" src="<?= base_url('assets/images/logo.png') ?>" alt="logo" width="100">
        </div>
    </div>

    <div class="row">

        <div class="col-12 p-3">
            <div class="border border-1 border-secondary rounded-3 p-4 text-center">
                <h5 class="text-secondary">Bem-vindo ao sistema de gestão de restaurantes!</h5>
                <p class="text-secondary">Aqui você pode gerenciar seus produtos, estoques e usuários de forma eficiente.</p>
                <p class="text-secondary">Use o menu lateral para navegar pelas diferentes seções do sistema.</p>
            </div>
        </div>

        <div class="col-12 p-3">
            <div class="border border-1 border-secondary rounded-3 p-4 text-center">
                <h5 class="text-secondary">Restaurante: <strong><?= $restaurant->name ?></strong></h5>
            </div>
        </div>
        <div class="col-12 p-3">
            <div class="border border-1 border-secondary rounded-3 p-4 text-center">
                <a href="tel:+55<?= $restaurant->phone ?>" class="home-link">
                    <h5 class="text-secondary"><strong><i class="fa-solid fa-mobile-screen me-2"></i><?= $restaurant->phone ?></strong></h5>
                </a>
                <a href="mailto:<?= $restaurant->email ?>" class="home-link">
                    <h5 class="text-secondary"><strong> <i class="fa-solid fa-envelope-open-text me-2"></i> <?= $restaurant->email ?></strong></h5>
                </a>
            </div>
        </div>

        <div class="col-12 p-3">
            <div class="border border-1 border-secondary rounded-3 p-4 text-center">
                <p><strong><?= $restaurant->address ?></strong></p>
                <p>Criado em: <strong><?= $restaurant->created_at ?></strong></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>