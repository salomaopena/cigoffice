<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="container-fluid mb-5">
    <div class="row">
        <div class="col content-box p-4">

            <div class="row">

                <div class="col-sm-8 col-12">

                    <?= form_open('/users_management/edit_submit', ['novalidate' => true], ['hidden_id' => Encrypt($user->id)]) ?>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <p>Restaurant: <strong><?= session()->user['restaurant_name'] ?></strong> </p>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <dv class="col-sm-6 col-12">
                            <p>Usuário</p>
                            <p><strong><?= $user->username ?></strong></p>
                        </dv>
                        <div class="col-sm-6 col-12">
                            <p>Nome do usuário</p>
                            <p><strong><?= $user->full_name ?></strong></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <dv class="col-sm-6 col-12">
                            <p>Email</p>
                            <p><strong><?= $user->email ?></strong></p>
                        </dv>
                        <div class="col-sm-6 col-12">
                            <p>Telefone</p>
                            <p><strong><?= $user->phone ?></strong></p>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="text_perfil" class="form-label">Perfil</label>
                                <select class="form-control" id="select_role" name="select_role" required>
                                    <option value="user" <?= $user->roles == 'user' ? 'selected' : '' ?>>Colaborador</option>
                                    <option value="admin" <?= $user->roles == 'admin' ? 'selected' : '' ?>>Administrador</option>
                                </select>

                                <?= display_error('select_role', $validation_errors) ?>

                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="me-3">Usuário:</p>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <input type="radio" class="form-check-input me-2" name="radio_active" id="radio_active" value="1" <?= $user->is_active ? 'checked' : '' ?>>
                                        <label for="radio_active" class="form-check-label">Ativo</label>
                                    </div>

                                    <div class="me-3">
                                        <input type="radio" class="form-check-input me-2" name="inative_radio_active" id="inative_radio_active" value="0" <?= !$user->is_active ? 'checked' : '' ?>>
                                        <label for="inative_radio_active" class="form-check-label">Inativo</label>
                                    </div>
                                </div>
                                <?= display_error('inative_radio_active', $validation_errors) ?>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="blocked_until" class="form-label">Bloquear até:</label>
                            <input type="date" class="form-control" name="blocked_until" id="blocked_until" value="<?= $user->blocked_until ?>">

                            <?= display_error('blocked_until', $validation_errors) ?>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col">
                            <a href="<?= site_url('/users_management') ?>" class="btn btn-outline-secondary px-5"><i class="fas fa-ban me-2"></i>Cancelar</a>
                            <button type="submit" class="btn btn-outline-success px-5"><i class="fas fa-check me-2"></i>Editar usuário</button>
                        </div>
                    </div>

                    <?= form_close() ?>

                    <?php if (!empty($server_error)): ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= $server_error ?>
                        </div>
                    <?php endif; ?>

                </div>


                <div class="col-sm-4 col-12 text-center mt-3">

                    <?php if (!empty($user->deleted_at)): ?>
                        <div class="card p-3 d-block">
                            <p class="text-center">Este usuário foi removido em <br> <strong><?= $user->deleted_at ?></strong></p>
                            <button type="button" class="btn btn-outline-success px-5" data-bs-toggle="modal" data-bs-target="#modal_recover">
                                <i class="fa-solid fa-trash-can-arrow-up me-2"></i>Recuperar usuário
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="card p-3 d-block">
                            <p class="text-danger text-center">Clique no botão a baixo para eliminar este usuário.<br>
                                <small>Esta acção é reversível</small>
                            </p>
                            <button type="button" class="btn btn-outline-danger px-5" data-bs-toggle="modal" data-bs-target="#modal_delete">
                                <i class="fas fa-trash me-2"></i>Eliminar usuário
                            </button>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>

    </div>
</div>


<!-- Modal for delete confirmation -->
<div class="modal fade" id="modal_delete" tabindex="-1" aria-labelledby="modal_delete_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal_delete_label">Eliminar usuário</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem a certeza que deseja eliminar este usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="<?= site_url('/users_management/delete_user/' . Encrypt($user->id)) ?>" class="btn btn-outline-danger"><i class="fas fa-trash me-2"></i>Eliminar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for recover confirmation -->
<div class="modal fade" id="modal_recover" tabindex="-1" aria-labelledby="modal_recover_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal_recover_label">Recuperar usuário</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem a certeza que deseja recuperar este usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="<?= site_url('/users_management/recover_user/' . Encrypt($user->id)) ?>" class="btn btn-outline-success"><i class="fas fa-trash-can-arrow-up me-2"></i>Recuperar</a>
            </div>
        </div>
    </div>





<script>
    window.addEventListener('DOMContentLoaded', function() {
        // Initialize the date input with today's date
        const blockedUntilInput = document.getElementById('blocked_until');
        const today = new Date().toISOString().split('T')[0];
        blockedUntilInput.setAttribute('min', today);
    });

    window.addEventListener('DOMContentLoaded', function() {
        flatpicker('.blocked_until', {
            dateFormat: 'Y-m-d',
            minDate: 'today',
            allowInput: true,
            locale: {
                firstDayOfWeek: 1 // Start week on Monday
            }
        });
    });
</script>

<?= $this->endSection() ?>