<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="d-flex content-box">
    <div class="p-3">
        <!-- image -->
        <img src="<?= file_exists('assets/images/products/' . $product->image) ? base_url('assets/images/products/' . $product->image) : base_url('assets/images/products/no_iamge.png') ?>" class="product-image img-fluid" id="product_image" alt="<?= $product->name ?>">
    </div>


    <div class="p-3">

        <h3 class="text-black mb-3"><strong><?= $product->name ?></strong></h3>
        <p class="mb-2 opacity-50">Descrição: <?= $product->description ?></p>
        <p class="mb-2 opacity-50">Criado em: <?php echo date('d/m/Y H:i:s', strtotime($product->created_at)) ?></p>

        <p class="alert alert-danger"><?= $message ?></p>

        <div class="d-flex mb-3">
            <a href="<?= site_url('/products') ?>" class="btn btn-outline-secondary px-5"><i class="fa fa-ban me-2"></i> Cancelar </a>

            <a href="<?= site_url('products/delete/confirm/' . Encrypt($product->id)) ?>" class="btn btn-outline-danger px-5 ms-3"><i class="fa-regular fa-trash-can me-2"></i> Confirmar</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>