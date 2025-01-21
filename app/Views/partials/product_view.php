<div class="col-xxl-6 col-12 ">
    <div class="content-box shadow overflow-hidden">
        <div class="d-flex">
            <div>
                <img src="<?= base_url('assets/images/products/' . $product->image) ?>" class="img-fluid" alt="<?= $product->image ?>">
            </div>
            <div class="ms-4 w-100">
                <h3 class="m-0"><strong><?= $product->name ?></strong></h3>
                <p class="m-0"><?= $product->description ?></p>
                <p class="m-0 opacity-50"><?= $product->category ?></p>
                <?php if ($product->promotion == 0) : ?>
                    <h3 class="m-0 text-primary"><strong><?= 'R$' . $product->price ?></strong></h3>
                <?php else : ?>
                    <h3 class="m-0"><?= 'R$' . $product->price ?>/<span class="text-primary"><strong><?= 'R$' . calculate_promotion($product->price, $product->promotion) ?></strong></span></h3>
                    <span class="badge bg-success">(Com promoção de <?= $product->promotion ?> %)</span>
                <?php endif; ?>
                <div class="text-end align-items-bottom">
                    <a href="<?=site_url('products/edit/' .Encrypt($product->id))?>" class="btn btn-sm btn-outline-secondary px-3 m-1"><i class="fa-regular fa-pen-to-square me-2"></i>Editar</a>
                    <a href="<?=site_url('stocks/product/' .Encrypt($product->id))?>" class="btn btn-sm btn-outline-warning px-3 m-1"><i class="fa-solid fa-cubes-stacked me-2"></i>Stock</a>
                    <a href="<?=site_url('products/delete/' .Encrypt($product->id))?>" class="btn btn-sm btn-outline-danger px-3 m-1"><i class="fa-regular fa-trash-can me-2"></i>Excluir</a>
                </div>
            </div>
        </div>
    </div>
</div>