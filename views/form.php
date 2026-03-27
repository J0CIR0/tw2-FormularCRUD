<?php
require_once __DIR__ . '/../models/Usuario.php';

$isEdit = isset($_GET['id']);
$usuario = null;
$error = null;

if ($isEdit) {
    $usuarioModel = new Usuario();
    $usuario = $usuarioModel->getById((int)$_GET['id']);
    if (!$usuario) {
        header('Location: index.php?msg=notfound');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $celular = trim($_POST['celular'] ?? '') ?: null;

    if (empty($nombre) || empty($apellido) || empty($correo)) {
        $error = 'Todos los campos obligatorios deben ser completados.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido.';
    } else {
        $usuarioModel = new Usuario();
        
        if ($isEdit) {
            if ($usuarioModel->emailExists($correo, (int)$_GET['id'])) {
                $error = 'El correo ya está en uso por otro usuario.';
            } else {
                $usuarioModel->update((int)$_GET['id'], $nombre, $apellido, $correo, $celular);
                header('Location: index.php?msg=updated');
                exit;
            }
        } else {
            if ($usuarioModel->emailExists($correo)) {
                $error = 'El correo ya está registrado.';
            } else {
                $usuarioModel->create($nombre, $apellido, $correo, $celular);
                header('Location: index.php?msg=created');
                exit;
            }
        }
    }
}
?>
<?php require_once __DIR__ . '/header.php'; ?>

<div class="view-card p-4">
    <div class="mb-4">
        <h2 class="page-title"><?= $isEdit ? 'Editar Usuario' : 'Nuevo Usuario' ?></h2>
        <p class="subtitle mb-0">Completa los campos para guardar la información del usuario.</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre *</label>
            <input type="text" class="form-control" id="nombre" name="nombre" 
                   value="<?= $usuario ? htmlspecialchars($usuario['nombre']) : '' ?>" required>
        </div>
        <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido *</label>
            <input type="text" class="form-control" id="apellido" name="apellido" 
                   value="<?= $usuario ? htmlspecialchars($usuario['apellido']) : '' ?>" required>
        </div>
        <div class="col-md-6">
            <label for="correo" class="form-label">Correo *</label>
            <input type="email" class="form-control" id="correo" name="correo" 
                   value="<?= $usuario ? htmlspecialchars($usuario['correo']) : '' ?>" required>
        </div>
        <div class="col-md-6">
            <label for="celular" class="form-label">Celular</label>
            <input type="text" class="form-control" id="celular" name="celular" 
                   value="<?= $usuario ? htmlspecialchars($usuario['celular'] ?? '') : '' ?>">
        </div>
        <div class="col-12 d-flex flex-wrap gap-2 mt-2">
            <button type="submit" class="btn btn-success"><?= $isEdit ? 'Actualizar' : 'Crear' ?></button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>