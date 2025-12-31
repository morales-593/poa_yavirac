            </div> <!-- Cierre del contenido principal -->
        </div> <!-- Cierre del flex -->
    </div> <!-- Cierre container-fluid -->

    <!-- Bootstrap JS Bundle le quito de aqui y funciona en todas menos en dasboard y en planes
    
    -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom JS -->
    <script src="public/js/app.js"></script>
    
    <script>
        // Inicializar DataTables
        $(document).ready(function() {
            $('.table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                responsive: true
            });
            
            // Confirmación de eliminación
            $('.btn-eliminar').on('click', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Esta acción no se puede deshacer!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

                    
<!-- sidebar -->

    <script>
// Función toggleSidebar mejorada
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    
    if (window.innerWidth <= 991.98) {
        // MÓVIL
        sidebar.classList.toggle('mobile-show');
        
        // Crear overlay si no existe
        let overlay = document.getElementById('sidebarOverlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'sidebarOverlay';
            overlay.className = 'sidebar-overlay';
            overlay.onclick = toggleSidebar;
            document.body.appendChild(overlay);
        }
        
        if (sidebar.classList.contains('mobile-show')) {
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden'; // Bloquear scroll
        } else {
            overlay.classList.remove('show');
            document.body.style.overflow = ''; // Restaurar scroll
        }
    } else {
        // ESCRITORIO
        sidebar.classList.toggle('sidebar-hidden');
    }
}

// Botón de cerrar para móvil
document.addEventListener('DOMContentLoaded', function() {
    const closeBtn = document.getElementById('sidebarCloseMobile');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.remove('mobile-show');
            
            const overlay = document.getElementById('sidebarOverlay');
            if (overlay) {
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    }
    
    // Cerrar al hacer clic en enlaces (solo móvil)
    const sidebar = document.getElementById('sidebar');
    const links = sidebar.querySelectorAll('a');
    
    links.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 991.98) {
                toggleSidebar();
            }
        });
    });
    
    // Redimensionar ventana
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991.98) {
            // Cambió a escritorio - limpiar móvil
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.remove('mobile-show');
            if (overlay) {
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        }
    });
});
</script>
</body>
</html>