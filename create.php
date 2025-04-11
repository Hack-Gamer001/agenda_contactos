<?php
require_once 'db.php';

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
        $stmt = $conn->prepare("INSERT INTO contactos (nombres, apaterno, amaterno, genero, fecha_nacimiento, telefono, email, linkedin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombres, $apaterno, $amaterno, $genero, $fecha_nacimiento, $telefono, $email, $linkedin]);

        header("Location: index.php?message=Contacto agregado correctamente&type=success");
        exit();
    } catch(PDOException $e) {
        header("Location: index.php?message=Error al agregar contacto: " . $e->getMessage() . "&type=error");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
