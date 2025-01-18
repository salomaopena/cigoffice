<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="mb-3">
    <a href="<?= site_url('products/new') ?>" class="btn btn-outline-secondary">
    <i class="fa-solid fa-plus"></i>
        Novo produto
    </a>
</div>

<div class="text-center mt-5">
    <h4 class="opacity-50 mb-3">Não existem produtos cadastrados</h4>
    <span>Clique<a class="link-offset-2 link-underline link-underline-opacity-0 fw-bold" href="<?= site_url('products/new') ?>"> aqui</a> para adicionar um novo produto do restaurante</span>
</div>

<?=$this->endSection()?>