<?php
$host = 'sql111.infinityfree.com';
$dbname = 'if0_38729248_agenda_contactos';
$username = 'if0_38729248'; // Cambiar según tu configuración
$password = 'PDJGSeJeei5OIbT'; // Cambiar según tu configuración

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
