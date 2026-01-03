</div> <!-- Cierre del contenido principal -->
</div> <!-- Cierre del flex -->
</div> <!-- Cierre container-fluid -->

<!-- jQuery PRIMERO -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap JS Bundle DESPUÉS de jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom JS -->
<script src="public/js/app.js"></script>

<!-- SCRIPT GLOBAL PARA EL FUNCIONAMIENTO DE TODO EL SISTEMA -->
<script>
// ============================================
// FUNCIONES GLOBALES PARA EL SISTEMA
// ============================================

// Variable global para el ID del indicador guardado
var idIndicadorGuardadoGlobal = '';

// FUNCIÓN PRINCIPAL QUE ACTUALIZA TODO
function actualizarTodo(elemento, idIndicadorPreseleccionado = null) {
    console.log('🔄 EJECUTANDO actualizarTodo');
    console.log('📌 Elemento recibido:', elemento);
    console.log('🎯 ID Indicador a preseleccionar:', idIndicadorPreseleccionado);
    
    const txtObjetivo = document.getElementById('objetivo_display');
    const selectIndicador = document.getElementById('indicador_select');
    
    if (!txtObjetivo) {
        console.error('❌ NO SE ENCUENTRA objetivo_display');
        return;
    }
    
    if (!selectIndicador) {
        console.error('❌ NO SE ENCUENTRA indicador_select');
        return;
    }
    
    // 1. Si no hay eje seleccionado, limpiar
    if (!elemento || elemento.value === "" || elemento.value === "0") {
        console.log('⚠️ No hay eje seleccionado, limpiando...');
        txtObjetivo.value = "";
        selectIndicador.innerHTML = '<option value="">-- Primero seleccione un eje --</option>';
        return;
    }

    // 2. MOSTRAR OBJETIVO INMEDIATAMENTE
    const opcionSeleccionada = elemento.options[elemento.selectedIndex];
    const objetivo = opcionSeleccionada ? opcionSeleccionada.getAttribute('data-objetivo') : '';
    
    console.log('📋 Objetivo extraído del data-attribute:', objetivo);
    
    if (objetivo && objetivo.trim() !== "") {
        txtObjetivo.value = objetivo;
        console.log('✅ Objetivo establecido en el textarea');
    } else {
        txtObjetivo.value = "No hay objetivo registrado para este eje.";
        console.log('⚠️ No se encontró objetivo en data-attribute');
    }

    // 3. CARGAR INDICADORES VÍA AJAX
    console.log('🌐 Solicitando indicadores para eje ID:', elemento.value);
    selectIndicador.innerHTML = '<option value="">Cargando indicadores...</option>';
    selectIndicador.disabled = true;
    
    fetch('index.php?action=indicadoresPorEje&id_eje=' + elemento.value)
        .then(response => {
            console.log('📡 Respuesta del servidor recibida, status:', response.status);
            if (!response.ok) {
                throw new Error('Error HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Indicadores recibidos:', data);
            
            let opciones = '<option value="">-- Seleccione un Indicador --</option>';
            
            if (data && Array.isArray(data) && data.length > 0) {
                // Usar indicador preseleccionado si existe
                const idParaPreseleccionar = idIndicadorPreseleccionado || idIndicadorGuardadoGlobal;
                console.log('🎯 Buscando indicador ID para preseleccionar:', idParaPreseleccionar);
                
                data.forEach(ind => {
                    const esSeleccionado = (idParaPreseleccionar == ind.id_indicador) ? 'selected' : '';
                    if (esSeleccionado) {
                        console.log('🎯 Indicador preseleccionado encontrado:', ind.codigo);
                    }
                    opciones += `<option value="${ind.id_indicador}" ${esSeleccionado}>${ind.codigo} - ${ind.descripcion}</option>`;
                });
            } else {
                opciones = '<option value="">No hay indicadores para este eje</option>';
                console.log('⚠️ No hay indicadores para este eje');
            }
            
            selectIndicador.innerHTML = opciones;
            selectIndicador.disabled = false;
            console.log('✅ Select de indicadores actualizado');
            
        })
        .catch(error => {
            console.error('❌ Error al cargar indicadores:', error);
            selectIndicador.innerHTML = '<option value="">Error al cargar indicadores</option>';
            selectIndicador.disabled = false;
        });
}

// FUNCIÓN PARA INICIALIZAR EL MODAL AUTOMÁTICAMENTE
function inicializarModalElaboracion() {
    console.log('🚀 INICIALIZANDO MODAL ELABORACIÓN');
    
    const selectorEje = document.getElementById('eje_select');
    const txtObjetivo = document.getElementById('objetivo_display');
    
    if (!selectorEje) {
        console.error('❌ ERROR: No se encuentra el select de eje (eje_select)');
        return;
    }
    
    console.log('✅ Selector de eje encontrado');
    console.log('📌 Valor actual del select:', selectorEje.value);
    console.log('🔢 Número de opciones:', selectorEje.options.length);
    
    // Mostrar información de todas las opciones
    for(let i = 0; i < selectorEje.options.length; i++) {
        const opt = selectorEje.options[i];
        console.log(`Opción ${i}: valor="${opt.value}", texto="${opt.text}", data-objetivo="${opt.getAttribute('data-objetivo')}"`);
    }
    
    // Configurar evento change
    selectorEje.addEventListener('change', function() {
        console.log('🔄 USUARIO CAMBIÓ EL EJE:', this.value);
        
        // Mostrar objetivo inmediatamente
        const opcion = this.options[this.selectedIndex];
        const objetivo = opcion.getAttribute('data-objetivo');
        if (txtObjetivo) {
            if (objetivo && objetivo.trim() !== "") {
                txtObjetivo.value = objetivo;
            } else {
                txtObjetivo.value = "No hay objetivo registrado para este eje.";
            }
        }
        
        // Cargar indicadores
        actualizarTodo(this);
    });
    
    // Si ya hay un eje seleccionado, cargar todo inmediatamente
    if (selectorEje.value && selectorEje.value !== "") {
        console.log('🎯 Eje ya seleccionado, cargando automáticamente...');
        
        // Obtener el indicador guardado desde PHP (si existe)
        let indicadorGuardado = '';
        
        // Intentar obtener del select si ya tiene valor
        const selectIndicador = document.getElementById('indicador_select');
        if (selectIndicador && selectIndicador.value) {
            indicadorGuardado = selectIndicador.value;
        }
        
        // Intentar obtener de un campo hidden
        const hiddenIndicador = document.querySelector('input[name="id_indicador"]');
        if (hiddenIndicador && hiddenIndicador.value) {
            indicadorGuardado = hiddenIndicador.value;
        }
        
        console.log('🔍 Buscando indicador guardado:', indicadorGuardado);
        
        // Mostrar objetivo inmediatamente
        const opcionSeleccionada = selectorEje.options[selectorEje.selectedIndex];
        const objetivo = opcionSeleccionada.getAttribute('data-objetivo');
        if (txtObjetivo) {
            if (objetivo && objetivo.trim() !== "") {
                txtObjetivo.value = objetivo;
                console.log('✅ Objetivo mostrado inmediatamente');
            }
        }
        
        // Cargar indicadores después de un pequeño delay
        setTimeout(() => {
            actualizarTodo(selectorEje, indicadorGuardado);
        }, 300);
    }
}

// ============================================
// INICIALIZACIÓN DE LA PÁGINA
// ============================================

$(document).ready(function() {
    console.log('📄 Documento listo');
    
    // Inicializar DataTables
    if ($.fn.DataTable) {
        $('.table').DataTable({
            "language": {
                "decimal": ",",
                "thousands": ".",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Última",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true
        });
    }
    
    // Confirmación de eliminación
    $(document).on('click', '.btn-eliminar', function(e) {
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
    
    // Escuchar cuando se abre el modal de elaboración
    $('#modalElab').on('shown.bs.modal', function() {
        console.log('🎬 Modal de elaboración completamente visible');
        // Inicializar el contenido del modal
        setTimeout(inicializarModalElaboracion, 200);
    });
});

// ============================================
// FUNCIÓN PARA ABRIR ELABORACIÓN
// ============================================

function abrirElaboracion(id) {
    console.log('🚀 Abriendo elaboración para plan ID:', id);
    
    fetch('index.php?action=modalElaboracion&id_plan=' + id)
        .then(r => {
            if (!r.ok) throw new Error('Error en la respuesta');
            return r.text();
        })
        .then(html => {
            console.log('✅ HTML del modal recibido');
            document.getElementById('contenedorElab').innerHTML = html;
            
            // Mostrar el modal
            const modalEl = new bootstrap.Modal(document.getElementById('modalElab'));
            modalEl.show();
            
            // Inicializar después de que el modal esté visible
            setTimeout(() => {
                console.log('🔧 Inicializando contenido del modal...');
                inicializarModalElaboracion();
            }, 500);
        })
        .catch(error => {
            console.error('❌ Error:', error);
            Swal.fire('Error', 'No se pudo cargar la elaboración', 'error');
        });
}

// ============================================
// FUNCIONES DEL SIDEBAR
// ============================================

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    
    if (window.innerWidth <= 991.98) {
        sidebar.classList.toggle('mobile-show');
        
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
            document.body.style.overflow = 'hidden';
        } else {
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    } else {
        sidebar.classList.toggle('sidebar-hidden');
    }
}

// Inicialización del sidebar
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
    
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        const links = sidebar.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 991.98) {
                    toggleSidebar();
                }
            });
        });
    }
    
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991.98) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebar) sidebar.classList.remove('mobile-show');
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