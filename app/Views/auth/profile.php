<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="container-fluid mb-5">
    <div class="row">
        <div class="col content-box p-4">

            <h5>Editar Perfil - <strong><?= $user->full_name ?></strong></h5>
            <hr class="my-2">

            <div class="d-flex justify-content-between">
                <p class="mb-0">Usuário: <strong><?= $user->username ?></strong></p>
                <p class="mb-0">Perfil: <strong><?= $user->roles ?></strong></p>
                <p class="mb-0">Conta criada em: <strong><?= $user->created_at ?></strong></p>
            </div>

            <hr class="mt-1 mb-3">

            <div class="row">
                <div class="col-sm-6 col-12 my-1">
                    <div class="card p-4">
                        <h5><i class="fa-solid fa-user-pen me-3"></i><strong>Identidade</strong></h5>
                        <hr class="my-2">

                        <?= form_open('/auth/profile_submit', ['novalidate' => true]) ?>


                        <div class=" mb-3">
                            <label for="text_first_name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="text_first_name" name="text_first_name" value="<?= old('text_first_name', $user->first_name) ?>" required>
                            <?= display_error('text_first_name', $validation_errors) ?>
                        </div>

                        <div class="mb-3">
                            <label for="text_last_name" class="form-label">Sobrenome </label>
                            <input type="text" class="form-control" id="text_last_name" name="text_last_name" value="<?= old('text_last_name', $user->last_name) ?>" required>
                            <?= display_error('text_last_name', $validation_errors) ?>
                        </div>



                        <div class="mb-3">
                            <label for="text_email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="text_email" name="text_email" value="<?= old('text_email', $user->email) ?>" required>
                            <?= display_error('text_email', $validation_errors) ?>
                        </div>

                        <div class="mb-3">
                            <label for="text_phone" class="form-label">Telefone </label>
                            <input type="text" class="form-control" id="text_phone" name="text_phone" value="<?= old('text_phone', $user->phone) ?>" required>
                            <?= display_error('text_phone', $validation_errors) ?>
                        </div>

                        <button type="submit" class="btn btn-outline-success px-3">
                            <i class="fa-solid fa-check me-2"></i>
                            Salvar</button>

                        <?= form_close() ?>

                        <?php if (!empty($profile_success)): ?>
                            <div class="alert alert-success mt-3" role="alert">
                                <i class="fa-solid fa-check me-2"></i>
                                <?= $profile_success ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($server_error)): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <i class="fa-solid fa-check me-2"></i>
                                <?= $server_error ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="col-sm-6 col-12 my-1">
                    <div class="card p-4">
                        <h5><i class="fa-solid fa-key me-3"></i><strong>Alterar senha</strong></h5>
                        <hr class="my-2">

                        <?= form_open('/auth/change_password_submit', ['novalidate' => true]) ?>


                        <div class=" mb-3">
                            <label for="text_password" class="form-label">Senha Atual</label>
                            <input type="password" class="form-control" id="text_password" name="text_password" value="<?= old('text_password') ?>" required>
                            <?= display_error('text_password', $validation_errors) ?>
                        </div>

                        <div class="mb-3">
                            <label for="text_new_password" class="form-label">Nova senha </label>
                            <input type="password" class="form-control" id="text_new_password" name="text_new_password" value="<?= old('text_new_password') ?>" required>
                            <?= display_error('text_new_password', $validation_errors) ?>
                        </div>



                        <div class="mb-3">
                            <label for="text_new_password_confirm" class="form-label">Confirmar nova senha</label>
                            <input type="password" class="form-control" id="text_new_password_confirm" name="text_new_password_confirm" value="<?= old('text_new_password_confirm') ?>" required>
                            <?= display_error('text_new_password_confirm', $validation_errors) ?>
                        </div>

                        <button type="submit" class="btn btn-outline-success px-3">
                            <i class="fa-solid fa-check me-2"></i>
                            Alterar</button>

                        <?= form_close() ?>

                        <?php if (!empty($profile_change_password_success)): ?>
                            <div class="alert alert-success mt-3" role="alert">
                                <i class="fa-solid fa-check me-2"></i>
                                <?= $profile_change_password_success ?>
                            </div>
                        <?php endif; ?>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>