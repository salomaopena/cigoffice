<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="content-box">
    <?= form_open_multipart('products/edit/submit', ['novalidate' => true]) ?>

    <input type="hidden" name="id_product" value="<?= Encrypt($product->id) ?>">
    
    <div class="row">

        <div class="col-lg-4 col-12 px-5 pt-5">

            <!-- image -->
            <div class="text-center">
                <img src="<?=base_url('assets/images/products/' .$product->image)?>" class="product-image img-fluid" id="product_image">
            </div>

            <!-- file upload -->
            <div class="mt-3 text-start">
                <label for="file_image" class="form-label">Imagem do produto</label>
                <input type="file" name="file_image" id="file_image" class="form-control" accept="image/png">
                <?= display_error('file_image', $validation_errors) ?>
            </div>

        </div>

        <div class="col-lg-6 col-12 p-5">

            <!-- name -->
            <div class="mb-3">
                <label for="name" class="form-label">Nome do produto</label>
                <input type="text" name="text_name" id="text_name" value="<?= old('text_name', $product->name) ?>" class="form-control" placeholder="Nome do produto">
                <?= display_error('text_name', $validation_errors) ?>

            </div>

            <!-- description -->
            <div class="mb-3">
                <label for="description" class="form-label">Descrição do produto</label>
                <input type="text" name="text_description" id="text_description" value="<?= old('text_description',$product->description) ?>" class="form-control" placeholder="Descrição do produto">
                <?= display_error('text_description', $validation_errors) ?>
            </div>

            <!-- category and price -->
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="mb-3">
                        <label for="text_category" class="form-label">Categoria</label>
                        <input list="list_categories" name="text_category" id="text_category" class="form-control" value="<?= old('text_category', $product->category) ?>" placeholder="Categoria">
                        <?= display_error('text_category', $validation_errors) ?>
                        <datalist id="list_categories">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->category ?>"></option>
                            <?php endforeach ?>
                        </datalist>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="mb-3">
                        <label for="price" class="form-label">Preço</label>
                        <input type="text" name="text_price" id="text_price" value="<?= old('text_price',$product->price) ?>" class="form-control" placeholder="Preço">
                        <?= display_error('text_price', $validation_errors) ?>
                    </div>
                </div>
            </div>

            <!-- available and promotion -->
            <div class="row">
                <div class="col-lg-6 col-12 align-self-center mb-3">
                    <input type="checkbox" name="check_available" id="check_available" <?= $product->availability ? 'checked': ''?>>
                    <label for="check_available" class="form-label">Produto disponível.</label>
                </div>
                <div class="col-lg-6 col-12 mb-3">
                    <label for="promotion" class="form-label">Promoção</label>
                    <input type="text" name="text_promotion" id="text_promotion" value="<?= old('text_promotion',$product->promotion) ?>" class="form-control" placeholder="Promoção">
                    <?= display_error('text_promotion', $validation_errors) ?>
                </div>
            </div>

            <!-- initial stock and stock minimum limit -->
            <div class="row">

                <div class="col-lg-6 col-12 mb-3">
                    <label for="stock_minimum_limit" class="form-label">Limite mínimo de estoque</label>
                    <input type="text" name="text_stock_minimum_limit" id="text_stock_minimum_limit" class="form-control" value="<?= old('text_stock_minimum_limit',$product->stock_min_limit) ?>" placeholder="Limite mínimo de estoque">
                    <?= display_error('text_stock_minimum_limit', $validation_errors) ?>
                </div>

            </div>

        </div>

        <!-- submit -->
        <div class="row">
            <div class="col px-5 pb-5">
                <a href="<?= site_url('products') ?>" class="btn btn-outline-secondary px-5"><i class="fas fa-ban me-2"></i>Cancelar</a>
                <button type="submit" class="btn btn-outline-success px-5"><i class="fas fa-pencil me-2"></i>Editar produto</button>
            </div>
        </div>

        <?= form_close() ?>
    </div>

</div>

<script>
    // Preview image
    /*const fileInput = document.getElementById('file_image');
    const previewImage = document.getElementById('product_image');

    fileInput.addEventListener('change', function() {
        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.addEventListener('load', function() {
            previewImage.src = reader.result;
        });

        reader.readAsDataURL(file);
    });*/

    //Other way to preview image
    document.querySelector('#file_image').addEventListener('change', function() {
        const product_image = document.querySelector('#product_image');
        const file = this.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            product_image.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            product_image.removeAttribute('src');
        }
    });

    // Format price



    // Add categories dynamically
    //const categories = ['Category 1', 'Category 2', 'Category 3'];
    //categories.forEach(category => {
    //    const option = document.createElement('option');
    //    option.value = category;
    //   document.getElementById('list_categories').appendChild(option);
    //});
</script>



<?= $this->endSection() ?>