<div class="col-xxl-6 col-12 ">
    <div class="content-box shadow overflow-hidden">
        <div class="d-flex">

            <!-- image -->

            <?php if (!file_exists('assets/images/products/' . $product->image)): ?>
                <div class="me-3">
                    <img src="<?= base_url('assets/images/products/no_image.png') ?>" class="product-image img-fluid" alt="Sem Imagem">
                </div><?php else: ?>
                <div class="me-3">
                    <img src="<?= base_url('assets/images/products/') . $product->image ?>" class="product-image img-fluid" alt="<?= $product->name ?>">
                <?php endif; ?>
                </div>
                <div class="ms-4 w-100">
                    <h3 class="m-0"><strong><?= $product->name ?></strong></h3>
                    <p class="m-0"><?= $product->description ?></p>
                    <p class="m-0 opacity-50"><?= $product->category ?></p>
                    <?php if ($product->promotion == 0) : ?>
                        <h3 class="m-0 text-primary"><strong><?= 'R$' . normalize_price($product->price) ?></strong></h3>
                    <?php else : ?>
                        <h3 class="m-0"><?= 'R$' . normalize_price($product->price) ?>/<span class="text-primary"><strong><?= 'R$' . normalize_price(calculate_promotion($product->price, $product->promotion)) ?></strong></span></h3>
                    <?php endif; ?>

                    <!-- promotion badge -->
                    <div class="my-2">
                        <?php if ($product->promotion > 0) : ?>

                            <span class="badge bg-success">(Com promoção de <?= intval($product->promotion) ?>%)</span>
                        <?php endif; ?>
                        <!-- stock badge -->
                        <span class="badge bg-dark">
                            <?= $product->stock ?>
                            <?= $product->stock == 1 ? 'unidade' : 'unidades' ?>
                        </span>

                        <!-- minimum stock badge -->
                        <?php if ($product->stock <= $product->stock_min_limit) : ?>
                            <span class="badge bg-danger">Limitado</span>
                        <?php endif; ?>

                        <!-- availability badge -->
                        <?php if (!$product->availability) : ?>
                            <span class="badge bg-warning text-dark">Indisponível</span>
                        <?php endif; ?>
                    </div>

                    <div class="text-end align-items-bottom">
                        <a href="<?= site_url('products/edit/' . Encrypt($product->id)) ?>" class="btn btn-sm btn-outline-secondary px-3 m-1"><i class="fa-regular fa-pen-to-square me-2"></i>Editar</a>
                        <a href="<?= site_url('stocks/product/' . Encrypt($product->id)) ?>" class="btn btn-sm btn-outline-warning px-3 m-1"><i class="fa-solid fa-cubes-stacked me-2"></i>Stock</a>
                        <a href="<?= site_url('products/delete/' . Encrypt($product->id)) ?>" class="btn btn-sm btn-outline-danger px-3 m-1"><i class="fa-regular fa-trash-can me-2"></i>Excluir</a>
                    </div>
                </div>
        </div>
    </div>
</div>