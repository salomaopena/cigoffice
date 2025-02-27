<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col content-box py-3">
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
            <!--stock form-->
            <div class="row">
                <div class="col">

                    <h5>Remover Stock</h5>
                    <?= form_open('/stocks/remove/submit') ?>
                    <input type="hidden" name="id_product" value="<?= Encrypt($product->id) ?>">

                    <div class="row">
                        <div class="col-sm-4 col-12 mb-3">
                            <label for="text_stock" class="form-label">Quantidade</label>
                            <input type="number" class="form-control text-end" id="text_stock" name="text_stock" min="0" value="<?= old('text_stock', 0) ?>">
                            <?= display_error('text_stock', $validation_errors) ?>
                        </div>

                        <div class="col-sm-3 col-4 mb-3 align-self-center text-end">
                            <p class="mb-0">Tipo de movimento</p>
                            <h4>Saída de Stock</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8 col-12 mb-3">
                            <label for="text_reason" class="form-label">Informações adicionais</label>
                            <input class="form-control" id="text_reason" type="text" name="text_reason" value="<?= old('text_reason') ?>"></input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-12 mb-3">
                            <label for="text_date" class="form-label">Data do movimento</label>
                            <input class="form-control" id="text_date" type="date" name="text_date" value="<?= old('text_date') ?>"></input>
                            <?= display_error('text_date', $validation_errors) ?>

                        </div>
                    </div>
                    <?php if (!empty($server_error)): ?>
                        <div class="alert alert-danger mb-3 p-2" role="alert">
                            <?= $server_error ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <a href="<?= site_url('/stocks') ?>" class="btn btn-outline-secondary px-5"><i class="fas fa-ban me-2"></i>Cancelar</a>
                        <button type="submit" class="btn btn-outline-success px-5"><i class="fas fa-check me-2"></i>Registar Saída</button>
                    </div>



                    <?= form_close() ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        flatpickr('#text_date', {
            dateFormat: 'Y-m-d H:i',
            maxDate: 'today',
            enableTime: true,
            time_24hr: true,
            defaultDate: new Date(),
            locale: 'pt',
        })
    });
</script>

<?= $this->endSection() ?>