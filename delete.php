<?php
require_once 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

try {
    $stmt = $conn->prepare("DELETE FROM contactos WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php?message=Contacto eliminado correctamente&type=success");
    exit();
} catch(PDOException $e) {
    header("Location: index.php?message=Error al eliminar contacto: " . $e->getMessage() . "&type=error");
    exit();
}
?>
