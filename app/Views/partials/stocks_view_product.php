<div class="col">
    <div class="row content-box">
        <div class="col-lg-9 col-12 align-items-center">
            <div class="d-flex align-items-center">
                <!-- product image-->
                <div class="me-3">
                    <?php if (!file_exists('assets/images/products/' . $product->image)): ?>
                        <img src="<?= base_url('assets/images/products/no_image.png') ?>" class="stock-image img-fluid" alt="Sem Imagem">
                    <?php else: ?>
                        <img src="<?= base_url('assets/images/products/') . $product->image ?>" class="stock-image img-fluid" alt="<?= $product->name ?>">
                    <?php endif; ?>
                </div>
                <div class="ms-4">
                    <h3 class="m-0"><strong><?= $product->name ?></strong></h3>
                    <p class="m-0 opacity-50"><?= $product->description ?></p>
                    <p class="m-0 opacity-50"><strong>R$<?= normalize_price($product->price) ?></strong></p>
                    <?php if (!$product->availability): ?>
                        <span class="badge bg-danger">
                            Produto indisponível
                        </span>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <div class="col-lg-3 col-12 text-end align-self-center">
            <div>
                <h5>Stock Actual</h5>
                <h3 class="<?= $product->stock <= $product->stock_min_limit ? 'text-danger' : '' ?>">
                    <strong>
                        <?= $product->stock ?>
                        <?= $product->stock == 1 ? 'unidade' : 'unidades' ?>
                    </strong>
                </h3>
            </div>
        </div>

        <div class="text-end col-12">
            <a href="<?= site_url('/stocks/add/' . Encrypt($product->id)) ?>" class="btn btn-sm btn-outline-success px-3 m-1"><i
                    class="fa-regular fa-square-plus me-2"></i>Adicionar Stock</a>
            <a href="<?=site_url('/stocks/remove/' . Encrypt($product->id))?>" class="btn btn-sm btn-outline-danger px-3 m-1"><i class="fa-regular fa-square-minus me-2"></i>
                Excluir Stock</a>
            <a href="#" class="btn btn-sm btn-outline-secondary px-3 m-1"><i class="fa-solid fa-right-left me-2"></i>
                Entradas e Saídas</a>
        </div>
    </div>
</div>