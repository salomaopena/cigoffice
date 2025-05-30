<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="container-fluid mb-5">
    <div class="row">
        <div class="col content-box p-4">
            <?php if (empty($users)): ?>
                <div class="text-center opacity my-3 alert alert-info" role="alert">
                    Nenhum usuário encontrado.
                </div>
            <?php else: ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="table-users">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Funções</th>
                                <th>Estado</th>
                                <th>Último Login</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['full_name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['phone'] ?></td>
                                    <td><?= implode(',', $user['roles']) ?></td>

                                    <td class="text-center">
                                        <?php
                                        $icon = 'fa-regular fa-circle-check';
                                        $color = 'text-success';
                                        $tip = 'Ativo';

                                        if (!$user['has_password']) {
                                            $icon = 'fa-solid fa-triangle-exclamation';
                                            $color = 'text-warning';
                                            $tip = 'Registro incompleto';
                                        } elseif (!$user['is_active']) {
                                            $icon = 'fa-solid fa-user-slash';
                                            $color = 'text-danger';
                                            $tip = 'Inativo';
                                        } elseif (!empty($user['blocked_until'])) {

                                            $blocked_until = strtotime($user['blocked_until']);
                                            $now = strtotime('Y-m-d H:i:s');

                                            if ($blocked_until > $now) {
                                                $icon = 'fa-solid fa-circle-pause';
                                                $color = 'text-danger';
                                                $tip = 'Bloqueado até ' . date('d/m/Y H:i', $blocked_until);
                                            } else {
                                                $icon = 'fa-regular fa-circle-check';
                                                $color = 'text-success';
                                                $tip = 'Ativo';
                                            }
                                        }

                                        if (!empty($user['deleted_at'])) {
                                            $icon = 'fa-solid fa-circle-xmark';
                                            $color = 'text-secondary';
                                            $tip = 'Excluído em ' . date('d/m/Y H:i', strtotime($user['deleted_at']));
                                        }

                                        echo "<i class = \"$icon $color\" title=\"$tip\"> </i>";

                                        ?>
                                    </td>


                                    <td><?= $user['last_login'] ?></td>
                                    <td><?= $user['created_at'] ?></td>
                                    <td><?= 'Acoes' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                </div>

        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        //datatable initialization
        $('#table-users').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                decimal: ",",
                emptyTable: "Nenhum dado disponível na tabela",
                info: "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Nenhum registro encontrado",
                infoFiltered: "(filtrado de _MAX_ registros no total)",
                infoPostFix: "",
                lengthMenu: "Mostrar _MENU_ registros por página",
                loadingRecords: "Carregando...",
                processing: "Processando...",
                search: "Pesquisar:",
                searchPlaceholder: "Pesquisar...",
                thousands: ".",
                zeroRecords: "Nenhum registro encontrado",
                paginate: {
                    first: "Primeiro",
                    last: "Último",
                    next: "Próximo",
                    previous: "Anterior"
                },
                aria: {
                    sortAscending: ": ative para ordenar a coluna em ordem crescente",
                    sortDescending: ": ative para ordenar a coluna em ordem decrescente"
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>