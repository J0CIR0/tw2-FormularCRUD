<?php
require_once __DIR__ . '/../models/Usuario.php';  // Corregida la ruta

$usuarioModel = new Usuario();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php?msg=invalid');
    exit;
}

$usuario = $usuarioModel->getById($id);
if (!$usuario) {
    header('Location: index.php?msg=notfound');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($usuarioModel->delete($id)) {
        header('Location: index.php?msg=deleted');
    } else {
        $error = 'Error al eliminar el usuario.';
    }
    exit;
}

require_once __DIR__ . '/header.php';
?>

<div class="view-card p-4">
    <div class="mb-3">
        <h2 class="page-title">Eliminar Usuario</h2>
        <p class="subtitle mb-0">Esta acción no se puede deshacer. Verifica los datos antes de continuar.</p>
    </div>

    <div class="view-card p-3 mb-3">
        <h5 class="mb-3"><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?></h5>
        <p class="mb-0">
            <strong>Correo:</strong> <?= htmlspecialchars($usuario['correo']) ?><br>
            <strong>Celular:</strong> <?= htmlspecialchars($usuario['celular'] ?? 'No especificado') ?>
        </p>
    </div>

    <form method="POST" class="d-flex flex-wrap gap-2">
        <button type="submit" class="btn btn-danger">Sí, eliminar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php
require_once __DIR__ . '/footer.php';
?>
