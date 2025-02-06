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

            <div class="my-3">

                <div class="row">
                    <div class="col-auto">
                        <a href="<?= site_url('/stocks/add/' . Encrypt($product->id)) ?>" class="btn btn-sm btn-outline-success px-3 m-1"><i
                                class="fa-regular fa-square-plus me-2"></i>Adicionar Stock</a>
                        <a href="<?= site_url('/stocks/remove/' . Encrypt($product->id)) ?>" class="btn btn-sm btn-outline-danger px-3 m-1"><i class="fa-regular fa-square-minus me-2"></i>
                            Excluir Stock</a>
                        <a href="<?= base_url('/products/edit/' . Encrypt($product->id)) ?>" class="btn btn-sm btn-outline-warning px-3 m-1"><i class="fa-regular fa-pen-to-square me-2"></i>
                            Editar Produto</a>
                    </div>

                    <div class="col-auto d-flex align-items-center">
                        <i class="fa-solid fa-filter me-2"></i>
                        <select name="fiter_select" id="filter_select" class="form-select">
                            <option value="<?= Encrypt('') ?>" <?=stock_movements_selecte_filter($filter,'')?>>Todos os movimentos</option>
                            <option value="<?= Encrypt('IN') ?>" <?=stock_movements_selecte_filter($filter,'IN')?>>Entradas</option>
                            <option value="<?= Encrypt('OUT') ?>" <?=stock_movements_selecte_filter($filter,'OUT')?>>Saídas</option>
                            <optgroup label="Fornecedores">
                                <?php foreach ($stock_suppliers as $supplier) : ?>
                                    <option value="<?= Encrypt('stksup_' . $supplier->stock_supplier) ?>" <?=stock_movements_selecte_filter($filter,'stksup_'.$supplier->stock_supplier)?>><?= $supplier->stock_supplier ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                </div>

            </div>

            <table class="table table-striped table-bordered" id="datatable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Data do movimento</th>
                        <th class="text-center">Quantidade</th>
                        <th class="text-center">Operação</th>
                        <th class="text-center">Fornecedor</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        //datatable
        $('#datatable').DataTable({
            processing: true,
            //serverSide: true,
            responsive: true,
            deferRender: true,
            //scrollX: true,
            scrollCollapse: true,
            //scrollY: '50vh',
            data: <?= json_encode($movements) ?>,
            columns: [{
                    data: 'moviment_date',
                    className: 'text-center'
                },
                {
                    data: 'stock_quantity',
                    className: 'text-center'
                },
                {
                    data: 'stock_in_out',
                    className: 'text-center'
                },
                {
                    data: 'stock_supplier',
                    className: 'text-center'
                },
                {
                    data: 'reason'
                },
            ],
            order: [
                [0, 'desc'] // sort by movements date in descending order
            ],
            language: {
                decimal: "",
                emptyTable: "Sem dados disponíveis na tabela.",
                info: "Mostrando _START_ até _END_ de _TOTAL_ registos",
                infoEmpty: "Mostrando 0 até 0 de 0 registos",
                infoFiltered: "(Filtrando _MAX_ total de registos)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrando _MENU_ registos por página.",
                loadingRecords: "Carregando...",
                processing: "Processando...",
                search: "Filtrar:",
                zeroRecords: "Nenhum registro encontrado.",
                paginate: {
                    first: "Primeira",
                    last: "Última",
                    next: "Seguinte",
                    previous: "Anterior"
                },
                aria: {
                    sortAscending: ": ative para classificar a coluna em ordem crescente.",
                    sortDescending: ": ative para classificar a coluna em ordem decrescente."
                }
            }

        });

        // filter by movement type
        document.querySelector("#filter_select").addEventListener('change', () => {
            let filter = document.querySelector("#filter_select").value;
            window.location.href = '<?= base_url('/stocks/moviments/' . Encrypt($product->id)) ?>' + '/' + filter;
        });
    });
</script>

<?= $this->endSection() ?>