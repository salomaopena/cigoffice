<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="row mt-5">
    <div class="col-12 text-center">
        <p class="display-6 text-danger">
            ACESSO NEGADO
        </p>
        <p class="opacity-50"><?= $error ?></p>
    </div>
</div>

<?= $this->endSection(); ?>