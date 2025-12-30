<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema POA - Yavirac</title>
    
    <!-- Bootstrap 5   Aqui le deje y funciona-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/styles.css">
    
    
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Top Bar CON BOTÓN HAMBURGUESA -->
        <nav class="navbar navbar-dark bg-primary navbar-expand-lg py-2 px-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center w-100">
                <!-- Logo y título CON HAMBURGUESA -->
                <div class="d-flex align-items-center">
                    <!-- Botón hamburguesa SIMPLE -->
                    <button class="btn btn-outline-light me-3" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <!-- Logo y título -->
                    <div class="d-flex align-items-center">
                        <i class="fas fa-chart-bar fa-xl text-light me-3"></i>
                        <span class="navbar-brand mb-0 h5 fw-bold text-light">SISTEMA POA</span>
                    </div>
                </div>
                
                <!-- Usuario -->
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center" type="button" id="dropdownUsuario" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>
                            <?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? 'Usuario') ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Mi Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="index.php?action=logout"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        
            <!-- Incluir Sidebar -->
            <?php require_once 'views/layout/sidebar.php'; ?>
            <!-- Contenido Principal -->
            <div class="flex-grow-1 main-content" style="background-color: #f8f9fa; min-height: calc(100vh - 56px);">
                <div class="p-4" >


