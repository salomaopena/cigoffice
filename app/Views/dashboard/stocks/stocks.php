<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">

            <h3>Produtos</h3>
            <?php if (empty($products)): ?>
                <div class="text-center mt-5">
                    <h4 class="opacity-50 mb-3">Não existem produtos cadastrados</h4>
                    <span>Clique<a class="link-offset-2 link-underline link-underline-opacity-0 fw-bold" href="<?= site_url('products/new') ?>"> aqui</a> para adicionar um novo produto do restaurante</span>
                </div>
            <?php else: ?>

                <?php foreach ($products as $product): ?>
                    <?= view('partials/stocks_view_product',['product'=>$product])?>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>