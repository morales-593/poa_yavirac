<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Sistema POA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2>Sistema POA</h2>
                <button class="close-sidebar" id="closeSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li class="<?php echo ($page == 'coordinacion') ? 'active' : ''; ?>">
                        <a href="coordinacion.php"><i class="fas fa-users"></i> Coordinación</a>
                    </li>
                    <li class="<?php echo ($page == 'plan-operativo') ? 'active' : ''; ?>">
                        <a href="plan_operativo.php"><i class="fas fa-clipboard-list"></i> Plan Operativo</a>
                    </li>
                    <li class="<?php echo ($page == 'tema-poa') ? 'active' : ''; ?>">
                        <a href="tema_poa.php"><i class="fas fa-folder"></i> Tema POA</a>
                    </li>
                    <li class="<?php echo ($page == 'eje-objetivo') ? 'active' : ''; ?>">
                        <a href="eje_objetivo.php"><i class="fas fa-bullseye"></i> Eje y Objetivo</a>
                    </li>
                    <li class="<?php echo ($page == 'plazo') ? 'active' : ''; ?>">
                        <a href="plazo.php"><i class="fas fa-calendar-alt"></i> Plazo</a>
                    </li>
                    <li class="<?php echo ($page == 'responsable') ? 'active' : ''; ?>">
                        <a href="responsable.php"><i class="fas fa-user-tie"></i> Responsable de Área</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <div class="header">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title" id="pageTitle"><?php echo $page_title; ?></h1>
                <div class="user-info">
                    <div class="user-avatar" id="userAvatar"><?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?></div>
                    <span id="currentUser"><?php echo $_SESSION['username']; ?></span>
                    <a href="../logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
                    </div>
    </div>

