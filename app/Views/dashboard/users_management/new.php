<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="container-fluid mb-5">
    <div class="row">
        <div class="col content-box p-4">

            <div class="row">

                <?= form_open('/users_management/submit', ['novalidate' => true]) ?>

                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <p>Restaurant: <strong><?= session()->user['restaurant_name'] ?></strong> </p>
                            <hr>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="text_first_name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="first_name" name="text_first_name" required value="<?= old('text_first_name') ?>">
                            <?= display_error('text_first_name', $validation_errors) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="text_last_name" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" required id="last_name" name="text_last_name" value="<?= old('text_last_name') ?>">
                            <?= display_error('text_last_name', $validation_errors) ?>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="text_email" class="form-label">Email</label>
                            <input type="email" class="form-control" required id="email" name="text_email" value="<?= old('text_email') ?>">
                            <?= display_error('text_email', $validation_errors) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="text_phone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="phone" required name="text_phone" value="<?= old('text_phone') ?>">
                            <?= display_error('text_phone', $validation_errors) ?>
                        </div>

                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="text_username" class="form-label">Usuário</label>
                            <input type="text" class="form-control" id="text_username" required name="text_username" value="<?= old('text_username') ?>">
                            <?= display_error('text_username', $validation_errors) ?>
                        </div>

                    </div>


                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="text_perfil" class="form-label">Perfil</label>
                            <select class="form-control" id="select_role" name="select_role" required>
                                <option value="user" <?= old('select_role') == 'user' ? 'selected' : '' ?>>Usuário</option>
                                <option value="admin" <?= old('select_role') == 'admin' ? 'selected' : '' ?>>Administrador</option>
                            </select>

                            <?= display_error('select_role', $validation_errors) ?>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <a href="<?= site_url('/users_management') ?>" class="btn btn-outline-secondary px-5"><i class="fas fa-ban me-2"></i>Cancelar</a>
                        <button type="submit" class="btn btn-outline-success px-5"><i class="fas fa-check me-2"></i>Criar usuário</button>
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
        </div>
    </div>

    <?= $this->endSection() ?>