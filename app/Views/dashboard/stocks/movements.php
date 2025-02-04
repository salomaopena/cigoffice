<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="content-fluid">
    <div class="row">
        <div class="content-box p-5">
            <div class="d-flex align-items-center">

                <!--image-->
                <div class="me-3">
                    <?php if (!file_exists('assets/images/products/' . $product->image)): ?>
                        <img src="<?= base_url('assets/images/products/no_image.png') ?>" class="product-image img-fluid" alt="Sem Imagem">
                    <?php else: ?>
                        <img src="<?= base_url('assets/images/products/') . $product->image ?>" class="product-image img-fluid" alt="<?= $product->name ?>">
                    <?php endif; ?>
                </div>

                <!-- name and description-->
                <div class="flex-fill me-3">
                    <h4 class="mb-0"><strong><?= $product->name ?></strong></h4>
                    <p class="mb-0"><?= $product->description ?></p>
                    <?php if (!$product->availability): ?>
                        <span class="badge bg-danger">
                            Indisponível
                        </span>
                    <?php else: ?>
                    <?php endif; ?>
                </div>
                <!--Actual Stock-->
                <div class="text-end">
                    <h5>Stock Atual</h5>
                    <h3 class="mb-0 <?= $product->stock <= $product->stock_min_limit ? 'text-danger' : 'text-success' ?>"><strong><?= $product->stock ?></strong></h3>
                </div>
            </div>

            <hr>
        </div>
    </div>
</div>

<?= $this->endSection() ?>