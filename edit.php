<?php
require_once 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Obtener el contacto a editar
$stmt = $conn->prepare("SELECT * FROM contactos WHERE id = ?");
$stmt->execute([$id]);
$contacto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contacto) {
    header("Location: index.php?message=Contacto no encontrado&type=error");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = $_POST['nombres'];
    $apaterno = $_POST['apaterno'];
    $amaterno = $_POST['amaterno'] ?? null;
    $genero = $_POST['genero'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $linkedin = $_POST['linkedin'] ?? null;

    try {
        $stmt = $conn->prepare("UPDATE contactos SET nombres = ?, apaterno = ?, amaterno = ?, genero = ?, fecha_nacimiento = ?, telefono = ?, email = ?, linkedin = ? WHERE id = ?");
        $stmt->execute([$nombres, $apaterno, $amaterno, $genero, $fecha_nacimiento, $telefono, $email, $linkedin, $id]);

        header("Location: index.php?message=Contacto actualizado correctamente&type=success");
        exit();
    } catch(PDOException $e) {
        header("Location: edit.php?id=$id&message=Error al actualizar contacto: " . $e->getMessage() . "&type=error");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contacto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Contacto</h1>

        <?php if (isset($_GET['message'])): ?>
            <p class="message <?php echo $_GET['type']; ?>"><?php echo $_GET['message']; ?></p>
        <?php endif; ?>

        <div class="form-container">
            <form action="edit.php?id=<?php echo $id; ?>" method="post">
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo htmlspecialchars($contacto['nombres']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="apaterno">Apellido Paterno:</label>
                    <input type="text" id="apaterno" name="apaterno" class="form-control" value="<?php echo htmlspecialchars($contacto['apaterno']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="amaterno">Apellido Materno:</label>
                    <input type="text" id="amaterno" name="amaterno" class="form-control" value="<?php echo htmlspecialchars($contacto['amaterno']); ?>">
                </div>
                <div class="form-group">
                    <label for="genero">Género:</label>
                    <select id="genero" name="genero" class="form-control" required>
                        <option value="Masculino" <?php echo $contacto['genero'] === 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Femenino" <?php echo $contacto['genero'] === 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                        <option value="Otro" <?php echo $contacto['genero'] === 'Otro' ? 'selected' : ''; ?>>Otro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="<?php echo $contacto['fecha_nacimiento']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($contacto['telefono']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($contacto['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="linkedin">LinkedIn (solo perfil):</label>
                    <input type="text" id="linkedin" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($contacto['linkedin']); ?>" placeholder="linkedin.com/in/tuperfil">
                </div>
                <button type="submit" class="btn">Actualizar Contacto</button>
            </form>
        </div>

        <p><a href="index.php">Volver a la lista</a></p>
    </div>
</body>
</html>
