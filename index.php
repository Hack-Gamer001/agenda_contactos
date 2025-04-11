<?php
require_once 'db.php';

// Obtener todos los contactos
$stmt = $conn->query("SELECT * FROM contactos ORDER BY apaterno, amaterno, nombres");
$contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contactos</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1><i class="fas fa-address-book"></i> Agenda de Contactos</h1>
        </div>
    </header>
    
    <main class="container">
        <?php if (isset($_GET['message'])): ?>
            <div class="message <?php echo $_GET['type']; ?>">
                <?php echo $_GET['message']; ?>
            </div>
        <?php endif; ?>
        
        <section class="table-container">
            <h2><i class="fas fa-list"></i> Lista de Contactos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Género</th>
                        <th>Edad</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>LinkedIn</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contactos as $contacto): 
                        $fechaNac = new DateTime($contacto['fecha_nacimiento']);
                        $hoy = new DateTime();
                        $edad = $hoy->diff($fechaNac)->y;
                    ?>
                    <tr>
                        <td><?php echo $contacto['id']; ?></td>
                        <td><?php echo htmlspecialchars($contacto['nombres']); ?></td>
                        <td><?php echo htmlspecialchars($contacto['apaterno'] . ' ' . htmlspecialchars($contacto['amaterno'])); ?></td>
                        <td>
                            <?php if ($contacto['genero'] == 'Masculino'): ?>
                                <i class="fas fa-mars" style="color: #166088;"></i>
                            <?php elseif ($contacto['genero'] == 'Femenino'): ?>
                                <i class="fas fa-venus" style="color: #d81b60;"></i>
                            <?php else: ?>
                                <i class="fas fa-genderless" style="color: #6c757d;"></i>
                            <?php endif; ?>
                            <?php echo $contacto['genero']; ?>
                        </td>
                        <td><?php echo $edad; ?> años</td>
                        <td><a href="tel:<?php echo $contacto['telefono']; ?>"><?php echo $contacto['telefono']; ?></a></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($contacto['email']); ?>"><?php echo htmlspecialchars($contacto['email']); ?></a></td>
                        <td>
                            <?php if ($contacto['linkedin']): ?>
                                <a href="https://<?php echo htmlspecialchars($contacto['linkedin']); ?>" target="_blank" class="linkedin-link">
                                    <i class="fab fa-linkedin"></i> Ver perfil
                                </a>
                            <?php else: ?>
                                <span class="text-muted">No disponible</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="edit.php?id=<?php echo $contacto['id']; ?>" title="Editar"><i class="fas fa-edit"></i></a>
                            <a href="delete.php?id=<?php echo $contacto['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este contacto?')" title="Eliminar"><i class="fas fa-trash-alt" style="color: var(--danger-color);"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        
        <section class="form-container">
            <h2><i class="fas fa-user-plus"></i> Agregar Nuevo Contacto</h2>
            <form action="create.php" method="post">
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" class="form-control" required>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="apaterno">Apellido Paterno:</label>
                        <input type="text" id="apaterno" name="apaterno" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="amaterno">Apellido Materno:</label>
                        <input type="text" id="amaterno" name="amaterno" class="form-control">
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="genero">Género:</label>
                        <select id="genero" name="genero" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="linkedin">LinkedIn (solo perfil):</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">linkedin.com/in/</span>
                        </div>
                        <input type="text" id="linkedin" name="linkedin" class="form-control" placeholder="tuperfil">
                    </div>
                </div>
                
                <button type="submit" class="btn"><i class="fas fa-save"></i> Guardar Contacto</button>
            </form>
        </section>
    </main>
    
    <footer style="text-align: center; padding: 20px; margin-top: 40px; background-color: var(--dark-color); color: white;">
        <p>Sistema de Agenda de Contactos &copy; <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>