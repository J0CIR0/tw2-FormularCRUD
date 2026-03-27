<?php require_once __DIR__ . '/../models/Usuario.php'; ?>
<?php require_once __DIR__ . '/header.php'; ?>

<div class="view-card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
        <div>
            <h2 class="page-title">Lista de Usuarios</h2>
            <p class="subtitle mb-0">Administra los registros en un solo lugar.</p>
        </div>
        <a href="?action=create" class="btn btn-primary">Nuevo Usuario</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php $msg = htmlspecialchars($_GET['msg']); ?>
        <?php if ($msg === 'created'): ?>
            <div class="alert alert-success">Usuario creado exitosamente.</div>
        <?php elseif ($msg === 'updated'): ?>
            <div class="alert alert-success">Usuario actualizado exitosamente.</div>
        <?php elseif ($msg === 'deleted'): ?>
            <div class="alert alert-success">Usuario eliminado exitosamente.</div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $usuario = new Usuario();
                $usuarios = $usuario->getAll();
                ?>
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="7" class="text-center data-empty py-4">No hay usuarios registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['id']) ?></td>
                            <td><?= htmlspecialchars($u['nombre']) ?></td>
                            <td><?= htmlspecialchars($u['apellido']) ?></td>
                            <td><?= htmlspecialchars($u['correo']) ?></td>
                            <td><?= htmlspecialchars($u['celular'] ?? '-') ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($u['creado_en']))) ?></td>
                            <td class="d-flex flex-wrap gap-2">
                                <a href="?action=edit&id=<?= $u['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="?action=delete&id=<?= $u['id'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>