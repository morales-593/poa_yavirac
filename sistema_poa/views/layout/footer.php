</div> <!-- Cierre del contenido principal -->
</div> <!-- Cierre del flex -->
</div> <!-- Cierre container-fluid -->

<!-- jQuery PRIMERO -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<!-- Bootstrap JS Bundle DESPUÉS de jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jsPDF para exportar PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Agregar esto después de jsPDF -->
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- FontAwesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
        for (let i = 0; i < selectorEje.options.length; i++) {
            const opt = selectorEje.options[i];
            console.log(`Opción ${i}: valor="${opt.value}", texto="${opt.text}", data-objetivo="${opt.getAttribute('data-objetivo')}"`);
        }

        // Configurar evento change
        selectorEje.addEventListener('change', function () {
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
    // FUNCIONES PARA EL CRUD DE MEDIOS DE VERIFICACIÓN
    // ============================================

    // Función para mostrar mensajes temporales
    function mostrarMensajeCRUD(texto, tipo = 'info') {
        // Eliminar mensaje anterior si existe
        const mensajeAnterior = document.getElementById('mensaje-temporal');
        if (mensajeAnterior) {
            mensajeAnterior.remove();
        }

        // Determinar ícono según tipo
        let icono = 'info-circle';
        switch (tipo) {
            case 'success': icono = 'check-circle'; break;
            case 'warning': icono = 'exclamation-triangle'; break;
            case 'danger': icono = 'times-circle'; break;
            case 'info': icono = 'info-circle'; break;
        }

        // Crear nuevo mensaje
        const mensaje = document.createElement('div');
        mensaje.id = 'mensaje-temporal';
        mensaje.className = `alert alert-${tipo} alert-dismissible fade show shadow`;
        mensaje.style.position = 'fixed';
        mensaje.style.top = '20px';
        mensaje.style.right = '20px';
        mensaje.style.zIndex = '9999';
        mensaje.style.minWidth = '300px';
        mensaje.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${icono} me-2 fs-5"></i>
            <div class="flex-grow-1">${texto}</div>
            <button type="button" class="btn-close btn-close-${tipo}" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;

        document.body.appendChild(mensaje);

        // Auto-eliminar después de 4 segundos
        setTimeout(() => {
            if (mensaje.parentElement) {
                mensaje.style.transition = 'all 0.3s ease';
                mensaje.style.opacity = '0';
                mensaje.style.transform = 'translateX(100%)';

                setTimeout(() => {
                    if (mensaje.parentElement) {
                        mensaje.remove();
                    }
                }, 300);
            }
        }, 4000);
    }

    // Función para validar formulario de elaboración
    function validarFormularioElaboracion() {
        // Validar que haya al menos un medio de verificación
        const filas = document.querySelectorAll('#medios-container tr');
        if (filas.length === 0) {
            mostrarMensajeCRUD('❌ Debe agregar al menos un medio de verificación', 'danger');
            return false;
        }

        // Validar que todos los medios tengan descripción y plazo
        let todosValidos = true;
        let mensajesError = [];

        const inputsDetalle = document.querySelectorAll('input[name="detalle[]"]');
        const selectsPlazo = document.querySelectorAll('select[name="id_plazo[]"]');

        inputsDetalle.forEach((input, index) => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                todosValidos = false;
                mensajesError.push(`La descripción del medio #${index + 1} es requerida`);
            } else {
                input.classList.remove('is-invalid');
            }
        });

        selectsPlazo.forEach((select, index) => {
            if (!select.value) {
                select.classList.add('is-invalid');
                todosValidos = false;
                mensajesError.push(`El plazo del medio #${index + 1} es requerido`);
            } else {
                select.classList.remove('is-invalid');
            }
        });

        if (!todosValidos) {
            mostrarMensajeCRUD(`❌ Errores encontrados:<br>• ${mensajesError.join('<br>• ')}`, 'danger');

            // Hacer scroll al primer error
            const primerError = document.querySelector('.is-invalid');
            if (primerError) {
                primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                primerError.focus();
            }

            return false;
        }

        return true;
    }

    // ============================================
    // INICIALIZACIÓN DE LA PÁGINA
    // ============================================

    $(document).ready(function () {
        console.log('📄 Documento listo');

        // Mostrar mensajes de sesión si existen (con SweetAlert2)
        <?php if (isset($_SESSION['mensaje'])): ?>
            const tipo = '<?= $_SESSION['tipo_mensaje'] ?? 'info' ?>';
            const titulo = tipo === 'success' ? '¡Éxito!' :
                tipo === 'error' ? 'Error' :
                    tipo === 'warning' ? 'Advertencia' : 'Información';

            Swal.fire({
                icon: tipo,
                title: titulo,
                html: '<?= addslashes($_SESSION['mensaje']) ?>',
                showConfirmButton: true,
                confirmButtonText: 'Aceptar',
                timer: tipo === 'success' ? 3000 : null
            });

            <?php
            // Limpiar mensaje después de mostrarlo
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
            ?>
        <?php endif; ?>

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
        $(document).on('click', '.btn-eliminar', function (e) {
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
        $('#modalElab').on('shown.bs.modal', function () {
            console.log('🎬 Modal de elaboración completamente visible');
            // Inicializar el contenido del modal
            setTimeout(inicializarModalElaboracion, 200);
        });

        // Configurar validación para formularios con medios de verificación
        $(document).on('submit', '#formElaboracion', function (e) {
            if (!validarFormularioElaboracion()) {
                e.preventDefault();
                return false;
            }

            // Mostrar mensaje de envío
            const btnSubmit = $(this).find('button[type="submit"]');
            const btnOriginalHTML = btnSubmit.html();
            btnSubmit.html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
            btnSubmit.prop('disabled', true);

            // Permitir el envío normal del formulario
            return true;
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
    // FUNCIONES CRUD PARA MEDIOS DE VERIFICACIÓN
    // ============================================

    // Estas funciones serán usadas desde el modal de elaboración
    window.agregarMedio = function () {
        console.log('➕ Agregando nuevo medio...');
        const tbody = document.getElementById('medios-container');

        if (!tbody) {
            console.error('❌ No se encontró el contenedor de medios');
            return;
        }

        // Contar filas existentes
        const filasExistentes = tbody.querySelectorAll('tr').length;
        const nuevoNumero = filasExistentes + 1;

        const nuevaFila = document.createElement('tr');
        nuevaFila.id = 'fila-' + nuevoNumero;
        nuevaFila.className = 'fila-nueva';

        // Obtener opciones de plazos desde el modal actual
        let opcionesPlazos = '<option value="">-- Seleccione --</option>';
        const primerSelect = tbody.querySelector('select[name="id_plazo[]"]');
        if (primerSelect) {
            const plazosHTML = primerSelect.innerHTML;
            opcionesPlazos = plazosHTML.replace('selected', '');
        }

        nuevaFila.innerHTML = `
        <td class="text-center">${nuevoNumero}</td>
        <td>
            <input type="text" name="detalle[]" class="form-control form-control-sm" 
                   placeholder="Descripción del medio" required>
        </td>
        <td>
            <select name="id_plazo[]" class="form-select form-select-sm" required>
                ${opcionesPlazos}
            </select>
        </td>
        <td class="text-center">
            <div class="crud-buttons">
                <button type="button" class="btn btn-sm btn-danger" onclick="window.eliminarFila(${nuevoNumero})" title="Eliminar">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    `;

        tbody.appendChild(nuevaFila);

        // Animación de entrada
        nuevaFila.style.opacity = '0';
        nuevaFila.style.transform = 'translateY(-20px)';

        setTimeout(() => {
            nuevaFila.style.transition = 'all 0.3s ease';
            nuevaFila.style.opacity = '1';
            nuevaFila.style.transform = 'translateY(0)';
        }, 10);

        // Actualizar contador
        if (typeof window.actualizarContador === 'function') {
            window.actualizarContador();
        }

        // Mostrar mensaje de éxito
        if (typeof mostrarMensajeCRUD === 'function') {
            mostrarMensajeCRUD('✅ Nuevo medio agregado', 'success');
        }

        // Enfocar el primer campo de la nueva fila
        setTimeout(() => {
            const input = nuevaFila.querySelector('input');
            if (input) input.focus();
        }, 100);
    };

    window.eliminarFila = function (numeroFila) {
        console.log('🗑️ Eliminando fila:', numeroFila);
        const fila = document.getElementById('fila-' + numeroFila);

        if (!fila) return;

        // Verificar si es la única fila
        const totalFilas = document.querySelectorAll('#medios-container tr').length;
        if (totalFilas <= 1) {
            if (typeof mostrarMensajeCRUD === 'function') {
                mostrarMensajeCRUD('❌ Debe existir al menos un medio de verificación', 'warning');
            }
            return;
        }

        // Confirmar eliminación
        if (!confirm('¿Está seguro de eliminar este medio de verificación?')) {
            return;
        }

        // Animación de salida
        fila.style.transition = 'all 0.3s ease';
        fila.style.opacity = '0';
        fila.style.transform = 'translateX(100%)';

        setTimeout(() => {
            fila.remove();
            if (typeof window.renumerarFilas === 'function') {
                window.renumerarFilas();
            }
            if (typeof window.actualizarContador === 'function') {
                window.actualizarContador();
            }
            if (typeof mostrarMensajeCRUD === 'function') {
                mostrarMensajeCRUD('🗑️ Medio eliminado', 'warning');
            }
        }, 300);
    };

    window.renumerarFilas = function () {
        console.log('🔢 Renumerando filas...');
        const filas = document.querySelectorAll('#medios-container tr');
        let nuevoContador = 1;

        filas.forEach((fila, index) => {
            // Actualizar número en la primera celda
            const tdNumero = fila.querySelector('td:first-child');
            if (tdNumero) {
                tdNumero.textContent = nuevoContador;
            }

            // Actualizar ID de la fila
            fila.id = 'fila-' + nuevoContador;

            // Actualizar onclick del botón eliminar
            const btnEliminar = fila.querySelector('button.btn-danger');
            if (btnEliminar) {
                btnEliminar.setAttribute('onclick', `window.eliminarFila(${nuevoContador})`);
            }

            nuevoContador++;
        });
    };

    window.actualizarContador = function () {
        const totalFilas = document.querySelectorAll('#medios-container tr').length;
        const contadorElement = document.getElementById('total-medios');
        if (contadorElement) {
            contadorElement.textContent = totalFilas;
        }
    };

    window.limpiarMedios = function () {
        console.log('🧹 Limpiando todos los medios...');
        const totalFilas = document.querySelectorAll('#medios-container tr').length;

        if (totalFilas === 0) {
            if (typeof mostrarMensajeCRUD === 'function') {
                mostrarMensajeCRUD('No hay medios para limpiar', 'info');
            }
            return;
        }

        if (!confirm(`¿Está seguro de limpiar todos los medios de verificación? (${totalFilas} medios)`)) {
            return;
        }

        // Eliminar todas las filas
        const filas = document.querySelectorAll('#medios-container tr');
        filas.forEach(fila => {
            fila.style.transition = 'all 0.3s ease';
            fila.style.opacity = '0';
            fila.style.transform = 'translateX(-100%)';

            setTimeout(() => {
                fila.remove();
            }, 300);
        });

        // Agregar una fila nueva vacía después de limpiar
        setTimeout(() => {
            if (typeof window.agregarMedio === 'function') {
                window.agregarMedio();
            }
            if (typeof mostrarMensajeCRUD === 'function') {
                mostrarMensajeCRUD('🧹 Todos los medios han sido limpiados', 'info');
            }
        }, 350);
    };


    // ============================================
// FUNCIONES PARA EXPORTAR PDF
// ============================================

// Función para exportar PDF desde el modal de elaboración
window.exportarPDF = function () {
    console.log('📄 Iniciando exportación de PDF...');

    // Obtener datos del formulario
    const datos = obtenerDatosPDF();

    if (!datos) {
        mostrarMensajeCRUD('❌ Complete todos los campos requeridos antes de exportar', 'danger');
        return;
    }

    // Crear PDF
    crearPDFconDatos(datos);
}


// Función para obtener datos del formulario para PDF
function obtenerDatosPDF() {
    // Validar campos requeridos
    const camposRequeridos = [
        { selector: 'select[name="id_tema"]', nombre: 'Tema' },
        { selector: '#eje_select', nombre: 'Eje Estratégico' },
        { selector: '#indicador_select', nombre: 'Indicador' },
        { selector: 'select[name="id_responsable"]', nombre: 'Responsable' },
        { selector: 'input[name="linea_base"]', nombre: 'Línea Base' },
        { selector: 'textarea[name="actividades"]', nombre: 'Actividades' }
    ];

    let datos = {};
    let errores = [];

    // Validar y obtener datos
    camposRequeridos.forEach(campo => {
        const elemento = document.querySelector(campo.selector);
        if (!elemento) {
            errores.push(`${campo.nombre} (elemento no encontrado)`);
            return;
        }

        const valor = elemento.value ? elemento.options ? elemento.options[elemento.selectedIndex].text : elemento.value : '';

        if (!valor || valor.includes('-- Seleccione')) {
            elemento.classList.add('is-invalid');
            errores.push(campo.nombre);
        } else {
            elemento.classList.remove('is-invalid');

            // Guardar datos
            if (campo.selector === 'select[name="id_tema"]') {
                datos.tema = valor;
            } else if (campo.selector === '#eje_select') {
                datos.eje = valor;
                // Obtener objetivo del eje
                const opcionEje = elemento.options[elemento.selectedIndex];
                datos.objetivo = opcionEje ? opcionEje.getAttribute('data-objetivo') || '' : '';
            } else if (campo.selector === '#indicador_select') {
                datos.indicador = valor;
            } else if (campo.selector === 'select[name="id_responsable"]') {
                datos.responsable = valor;
            } else if (campo.selector === 'input[name="linea_base"]') {
                datos.linea_base = valor;
            } else if (campo.selector === 'textarea[name="actividades"]') {
                datos.actividades = valor;
            }
        }
    });

    // Validar medios de verificación
    const medios = [];
    const filasMedios = document.querySelectorAll('#medios-container tr');

    if (filasMedios.length === 0) {
        errores.push('Medios de verificación (debe agregar al menos uno)');
    } else {
        filasMedios.forEach((fila, index) => {
            const inputDetalle = fila.querySelector('input[name="detalle[]"]');
            const selectPlazo = fila.querySelector('select[name="id_plazo[]"]');

            const detalle = inputDetalle ? inputDetalle.value.trim() : '';
            const plazo = selectPlazo && selectPlazo.value ?
                selectPlazo.options[selectPlazo.selectedIndex].text : '';

            if (!detalle) {
                if (inputDetalle) inputDetalle.classList.add('is-invalid');
                errores.push(`Descripción del medio ${index + 1}`);
            } else {
                if (inputDetalle) inputDetalle.classList.remove('is-invalid');
            }

            if (!plazo || plazo.includes('-- Seleccione')) {
                if (selectPlazo) selectPlazo.classList.add('is-invalid');
                errores.push(`Plazo del medio ${index + 1}`);
            } else {
                if (selectPlazo) selectPlazo.classList.remove('is-invalid');
            }

            if (detalle && plazo && !plazo.includes('-- Seleccione')) {
                medios.push({ detalle, plazo });
            }
        });
    }

    // Si hay errores, mostrar mensaje
    if (errores.length > 0) {
        mostrarMensajeCRUD(`❌ Complete los campos requeridos:<br>• ${errores.join('<br>• ')}`, 'danger');
        return null;
    }

    // Obtener otros datos opcionales
    datos.politicas = document.querySelector('textarea[name="politicas"]')?.value || '';
    datos.metas = document.querySelector('textarea[name="metas"]')?.value || '';
    datos.indicador_resultado = document.querySelector('textarea[name="indicador_resultado"]')?.value || '';
    datos.medios = medios;
    datos.elaborado_por = document.querySelector('input[name="id_plan"]') ?
        '<?= htmlspecialchars($plan["nombre_elaborado"] ?? "Usuario") ?>' : 'Usuario';

    return datos;
}

// Función para crear PDF con los datos
function crearPDFconDatos(datos) {
    try {
        console.log('🖨️ Creando PDF con datos:', datos);

        // Verificar si jsPDF está disponible
        if (typeof window.jspdf === 'undefined') {
            mostrarMensajeCRUD('❌ Error: La librería jsPDF no está cargada', 'danger');
            return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');

        // Configurar fuente
        doc.setFont('helvetica');

        // Título principal - tamaño reducido
        doc.setFontSize(16); // Más pequeño
        doc.setTextColor(255, 0, 0); // ROJO
        doc.text('PLAN OPERATIVO ANUAL 2025', 105, 10, { align: 'center' }); // Más arriba

        doc.setFontSize(8); // Más pequeño
        doc.setTextColor(0, 0, 0);
        doc.text('Formulario: Elaboración POA 2025 - ISTTP "YAVIRAC"', 105, 16, { align: 'center' }); // Más arriba

        // Línea separadora
        doc.setLineWidth(0.3); // Más delgada
        doc.line(15, 22, 195, 22); // Más arriba

        let yPos = 28; // Más arriba

        // ============================================
        // 1. INFORMACIÓN GENERAL 
        // ============================================
        doc.setFillColor(0, 0, 128); // AZUL
        doc.rect(15, yPos, 180, 5, 'F'); // Más pequeño (5 en lugar de 6)
        doc.setFontSize(10); // Más pequeño
        doc.setTextColor(255, 255, 255); // BLANCO
        doc.setFont('helvetica', 'bold');
        doc.text('1. INFORMACIÓN GENERAL', 105, yPos + 3.5, { align: 'center' }); // Ajustado
        yPos += 6; // Menos espacio

        doc.setFontSize(8); // Más pequeño
        doc.setTextColor(0, 0, 0);

        // Dimensiones de la tabla - más pequeñas
        const anchoTotal = 180;
        const altoFila = 5; // Más pequeño
        const margenIzquierdo = 15;
        const anchoEtiqueta = 20; // Más pequeño
        const anchoContenido = 160; // Ajustado

        // TEMA - Fila 1
        // Dibujar rectángulo exterior
        doc.setDrawColor(0, 0, 0);
        doc.setLineWidth(0.15); // Más delgado
        doc.rect(margenIzquierdo, yPos, anchoTotal, altoFila);
        
        // Línea vertical separadora
        doc.line(margenIzquierdo + anchoEtiqueta, yPos, margenIzquierdo + anchoEtiqueta, yPos + altoFila);
        
        // Contenido
        doc.setFont('helvetica', 'bold');
        doc.text('TEMA', margenIzquierdo + 2, yPos + 3.2); // Ajustado
        doc.setFont('helvetica', 'normal');
        doc.text(datos.tema || 'No especificado', margenIzquierdo + anchoEtiqueta + 2, yPos + 3.2);
        yPos += altoFila;

        // OBJETIVO - Fila 2 (con altura dinámica)
        const objetivoLines = doc.splitTextToSize(datos.objetivo || 'No especificado', anchoContenido - 4);
        const altoObjetivo = Math.max(altoFila, objetivoLines.length * 3.5); // Más pequeño
        
        // Dibujar rectángulo exterior
        doc.rect(margenIzquierdo, yPos, anchoTotal, altoObjetivo);
        
        // Línea vertical separadora
        doc.line(margenIzquierdo + anchoEtiqueta, yPos, margenIzquierdo + anchoEtiqueta, yPos + altoObjetivo);
        
        // Contenido
        doc.setFont('helvetica', 'bold');
        doc.text('OBJETIVO', margenIzquierdo + 2, yPos + 3.2);
        doc.setFont('helvetica', 'normal');
        
        // Texto del objetivo (puede ser multilínea)
        objetivoLines.forEach((linea, idx) => {
            doc.text(linea, margenIzquierdo + anchoEtiqueta + 2, yPos + 3.2 + (idx * 3.5));
        });
        
        yPos += altoObjetivo;

        // EJE - Fila 3
        // Dibujar rectángulo exterior
        doc.rect(margenIzquierdo, yPos, anchoTotal, altoFila);
        
        // Línea vertical separadora
        doc.line(margenIzquierdo + anchoEtiqueta, yPos, margenIzquierdo + anchoEtiqueta, yPos + altoFila);
        
        // Contenido
        doc.setFont('helvetica', 'bold');
        doc.text('EJE', margenIzquierdo + 2, yPos + 3.2);
        doc.setFont('helvetica', 'normal');
        doc.text(datos.eje || 'No especificado', margenIzquierdo + anchoEtiqueta + 2, yPos + 3.2);
        
        yPos += altoFila + 8; // Menos espacio

        // ============================================
        // 2. DETALLES DEL PLAN 
        // ============================================
        doc.setFillColor(0, 0, 128); // AZUL
        doc.rect(15, yPos, 180, 5, 'F'); // Más pequeño
        doc.setFontSize(10); // Más pequeño
        doc.setTextColor(255, 255, 255); // BLANCO
        doc.setFont('helvetica', 'bold');
        doc.text('2. DETALLES DEL PLAN', 105, yPos + 3.5, { align: 'center' });
        yPos += 6; // Menos espacio

        // Tabla ITEM/DESCRIPCIÓN
        const anchoTabla = 180;
        const anchoItem = 25; // Más pequeño
        const anchoDescripcion = 155; // Ajustado
        
        // ENCABEZADO DE TABLA
        doc.setFillColor(0, 0, 128); // AZUL
        doc.rect(margenIzquierdo, yPos, anchoTabla, altoFila, 'F');
        doc.setDrawColor(255, 255, 255); // Líneas blancas
        doc.setLineWidth(0.1); // Más delgado
        
        // Líneas verticales del encabezado
        doc.line(margenIzquierdo, yPos, margenIzquierdo, yPos + altoFila);
        doc.line(margenIzquierdo + anchoItem, yPos, margenIzquierdo + anchoItem, yPos + altoFila);
        doc.line(margenIzquierdo + anchoTabla, yPos, margenIzquierdo + anchoTabla, yPos + altoFila);
        
        // Texto del encabezado - EN BLANCO
        doc.setFontSize(8); // Más pequeño
        doc.setTextColor(255, 255, 255); // BLANCO
        doc.setFont('helvetica', 'bold');
        doc.text('ITEM', margenIzquierdo + (anchoItem/2), yPos + 3.2, { align: 'center' });
        doc.text('DESCRIPCIÓN', margenIzquierdo + anchoItem + (anchoDescripcion/2), yPos + 3.2, { align: 'center' });
        
        // Restaurar color negro para el contenido
        doc.setTextColor(0, 0, 0);
        doc.setDrawColor(0, 0, 0); // Restaurar líneas negras
        
        yPos += altoFila;

        // Función para agregar filas a la tabla
        function agregarFilaTabla(item, descripcion) {
            const descripcionTexto = descripcion || 'No especificado';
            const descripcionLines = doc.splitTextToSize(descripcionTexto, anchoDescripcion - 6);
            const altoFilaActual = Math.max(altoFila, descripcionLines.length * 3.5); // Más pequeño
            
            // Dibujar rectángulo de la fila con borde
            doc.rect(margenIzquierdo, yPos, anchoTabla, altoFilaActual);
            
            // Líneas verticales
            doc.line(margenIzquierdo, yPos, margenIzquierdo, yPos + altoFilaActual);
            doc.line(margenIzquierdo + anchoItem, yPos, margenIzquierdo + anchoItem, yPos + altoFilaActual);
            doc.line(margenIzquierdo + anchoTabla, yPos, margenIzquierdo + anchoTabla, yPos + altoFilaActual);
            
            // Contenido ITEM
            doc.setFont('helvetica', 'bold');
            doc.text(item, margenIzquierdo + 3, yPos + 3.2);
            
            // Contenido DESCRIPCIÓN
            doc.setFont('helvetica', 'normal');
            descripcionLines.forEach((linea, idx) => {
                doc.text(linea, margenIzquierdo + anchoItem + 3, yPos + 3.2 + (idx * 3.5));
            });
            
            yPos += altoFilaActual;
            
            // Verificar si necesitamos nueva página
            if (yPos > 250) {
                doc.addPage();
                yPos = 20;
            }
        }

        // INDICADOR
        agregarFilaTabla('INDICADOR', datos.indicador);
        
        // LÍNEA BASE
        agregarFilaTabla('LÍNEA BASE', datos.linea_base);
        
        // POLÍTICAS (si existe)
        if (datos.politicas && datos.politicas.trim() !== '') {
            agregarFilaTabla('POLÍTICAS', datos.politicas);
        } else {
            agregarFilaTabla('POLÍTICAS', 'No especificado');
        }
        
        // METAS (si existe)
        if (datos.metas && datos.metas.trim() !== '') {
            agregarFilaTabla('METAS', datos.metas);
        } else {
            agregarFilaTabla('METAS', 'No especificado');
        }
        
        // ACTIVIDADES
        agregarFilaTabla('ACTIVIDADES', datos.actividades);
        
        // INDICADOR DE RESULTADO (si existe)
        if (datos.indicador_resultado && datos.indicador_resultado.trim() !== '') {
            agregarFilaTabla('IND. RESULTADO', datos.indicador_resultado);
        } else {
            agregarFilaTabla('IND. RESULTADO', 'No especificado');
        }

        yPos += 6; // Menos espacio

        // Verificar si necesitamos nueva página
        if (yPos > 250) {
            doc.addPage();
            yPos = 20;
        }

        // ============================================
        // 3. MEDIOS DE VERIFICACIÓN
        // ============================================
        doc.setFillColor(0, 0, 128); // AZUL
        doc.rect(15, yPos, 180, 5, 'F'); // Más pequeño
        doc.setFontSize(10); // Más pequeño
        doc.setTextColor(255, 255, 255); // BLANCO
        doc.setFont('helvetica', 'bold');
        doc.text('3. MEDIOS DE VERIFICACIÓN', 105, yPos + 3.5, { align: 'center' });
        yPos += 6; // Menos espacio

        doc.setFontSize(8); // Más pequeño
        doc.setTextColor(0, 0, 0);

        if (datos.medios.length > 0) {
            // Tabla de medios de verificación
            const anchoMedios = 180;
            const anchoNum = 10; // Más pequeño
            const anchoDetalle = 115; // Ajustado
            const anchoPlazo = 55; // Ajustado
            
            // ENCABEZADO DE TABLA
            doc.setFillColor(0, 0, 128); // AZUL
            doc.rect(margenIzquierdo, yPos, anchoMedios, altoFila, 'F');
            doc.setDrawColor(255, 255, 255); // Líneas blancas
            doc.setLineWidth(0.1); // Más delgado
            
            // Líneas verticales del encabezado
            doc.line(margenIzquierdo, yPos, margenIzquierdo, yPos + altoFila);
            doc.line(margenIzquierdo + anchoNum, yPos, margenIzquierdo + anchoNum, yPos + altoFila);
            doc.line(margenIzquierdo + anchoNum + anchoDetalle, yPos, margenIzquierdo + anchoNum + anchoDetalle, yPos + altoFila);
            doc.line(margenIzquierdo + anchoMedios, yPos, margenIzquierdo + anchoMedios, yPos + altoFila);
            
            // Texto del encabezado - EN BLANCO
            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.text('N°', margenIzquierdo + (anchoNum/2), yPos + 3.2, { align: 'center' });
            doc.text('DETALLE', margenIzquierdo + anchoNum + (anchoDetalle/2), yPos + 3.2, { align: 'center' });
            doc.text('PLAZO', margenIzquierdo + anchoNum + anchoDetalle + (anchoPlazo/2), yPos + 3.2, { align: 'center' });
            
            // Restaurar colores
            doc.setTextColor(0, 0, 0);
            doc.setDrawColor(0, 0, 0);
            
            yPos += altoFila;

            // Filas de medios
            datos.medios.forEach((medio, index) => {
                if (yPos > 270) {
                    doc.addPage();
                    yPos = 20;
                }

                const detalleLines = doc.splitTextToSize(medio.detalle || 'No especificado', anchoDetalle - 6);
                const altoFilaMedio = Math.max(altoFila, detalleLines.length * 3.5); // Más pequeño
                
                // Dibujar rectángulo de la fila
                doc.rect(margenIzquierdo, yPos, anchoMedios, altoFilaMedio);
                
                // Líneas verticales
                doc.line(margenIzquierdo, yPos, margenIzquierdo, yPos + altoFilaMedio);
                doc.line(margenIzquierdo + anchoNum, yPos, margenIzquierdo + anchoNum, yPos + altoFilaMedio);
                doc.line(margenIzquierdo + anchoNum + anchoDetalle, yPos, margenIzquierdo + anchoNum + anchoDetalle, yPos + altoFilaMedio);
                doc.line(margenIzquierdo + anchoMedios, yPos, margenIzquierdo + anchoMedios, yPos + altoFilaMedio);
                
                // Contenido
                doc.setFont('helvetica', 'normal');
                doc.text((index + 1).toString(), margenIzquierdo + (anchoNum/2), yPos + 3.2, { align: 'center' });
                
                // Detalle (puede ser multilínea)
                detalleLines.forEach((linea, idx) => {
                    doc.text(linea, margenIzquierdo + anchoNum + 3, yPos + 3.2 + (idx * 3.5));
                });
                
                // Plazo
                doc.text(medio.plazo || 'No especificado', margenIzquierdo + anchoNum + anchoDetalle + (anchoPlazo/2), yPos + 3.2, { align: 'center' });
                
                yPos += altoFilaMedio;
            });
        } else {
            // Mostrar mensaje cuando no hay medios
            doc.rect(margenIzquierdo, yPos, anchoTabla, altoFila);
            doc.text('No se han definido medios de verificación', margenIzquierdo + 8, yPos + 3.2);
            yPos += altoFila;
        }

        // ============================================
        // RESPONSABLE EN CUADRO
        // ============================================
        yPos += 8; // Espacio antes del responsable
        
        // Dibujar cuadro para responsable
        doc.setDrawColor(0, 0, 0);
        doc.setLineWidth(0.2);
        doc.rect(15, yPos, 180, 8); // Cuadro para responsable
        
        // Contenido del responsable
        doc.setFontSize(9);
        doc.setFont('helvetica', 'bold');
        doc.text('RESPONSABLE:', 18, yPos + 5);
        doc.setFont('helvetica', 'normal');
        doc.text(datos.responsable || 'No especificado', 55, yPos + 5);
        
        // Fecha actual
        const fechaActual = new Date();
        const fechaFormateada = fechaActual.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        }).toUpperCase();
        
        doc.text(fechaFormateada, 170, yPos + 5, { align: 'right' });
        
        yPos += 12; // Espacio después del cuadro

        // ============================================
        // FIRMAS 
        // ============================================
        yPos += 15; // Más espacio antes de las firmas
        
        if (yPos > 200) {
            doc.addPage();
            yPos = 30; // Más abajo en nueva página
        }

        doc.setFont('helvetica', 'bold');
        doc.text('ELABORADO POR:', 30, yPos);
        doc.text('REVISADO POR:', 120, yPos);
        yPos += 5; // Menos espacio

        // Nombres
        doc.setFontSize(8); // Más pequeño
        doc.setFont('helvetica', 'normal');
        doc.text(datos.elaborado_por || 'No especificado', 30, yPos);
        
        // Líneas para firmas
        yPos += 6; // Menos espacio
        doc.setDrawColor(0, 0, 0);
        doc.setLineWidth(0.2); // Más delgado
        
        // Línea del elaborado
        doc.line(30, yPos, 100, yPos);
        
        // Línea del revisado
        doc.line(120, yPos, 180, yPos);
        yPos += 3; // Menos espacio

        // Cargos
        doc.setFontSize(7); // Más pequeño
        doc.text('Coordinación de Planificación Estratégica', 30, yPos);
        doc.text('Unidad Responsable', 120, yPos);

        const fecha = new Date().toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        doc.text(`Fecha de generación: ${fecha}`, 105, 290, { align: 'center' });

        // Descargar el PDF
        const nombreArchivo = `POA_${datos.elaborado_por.replace(/[^a-z0-9]/gi, '_')}_${new Date().getTime()}.pdf`;
        doc.save(nombreArchivo);

        // Mostrar mensaje de éxito
        mostrarMensajeCRUD('✅ PDF generado y descargado exitosamente', 'success');

    } catch (error) {
        console.error('❌ Error al crear PDF:', error);
        mostrarMensajeCRUD('❌ Error al generar el PDF: ' + error.message, 'danger');
    }
}

    // ============================================
    // INICIALIZAR FUNCIÓN DE EXPORTAR PDF EN EL MODAL
    // ============================================

    // Función para inicializar el botón de exportar PDF en el modal
    function inicializarExportarPDF() {
        const btnExportarPDF = document.querySelector('[onclick*="exportarPDF"]');

        if (btnExportarPDF) {
            // Remover el onclick anterior si existe
            btnExportarPDF.removeAttribute('onclick');

            // Agregar el nuevo evento
            btnExportarPDF.addEventListener('click', function (e) {
                e.preventDefault();
                window.exportarPDF();
            });

            console.log('✅ Botón de exportar PDF inicializado');
        }
    }

    // Modificar la función de inicialización del modal para incluir exportar PDF
    function inicializarModalElaboracionCompleta() {
        inicializarModalElaboracion();
        inicializarExportarPDF();
    }


    // ============================================
    // FUNCIÓN PARA EXPORTAR PDF DE SEGUIMIENTO
    // ============================================
    window.exportarPDFSeguimiento = function() {
        console.log('📄 Iniciando exportación de PDF de seguimiento...');
        
        try {
            // Verificar si jsPDF está disponible
            if (typeof window.jspdf === 'undefined') {
                alert('Error: La librería jsPDF no está cargada. Por favor recargue la página.');
                return;
            }

            // Buscar el botón dentro del modal actual
            const btnExportar = document.querySelector('#btn-exportar');
            if (!btnExportar) {
                alert('Error: No se encontró el botón de exportar');
                return;
            }

            // Deshabilitar botón temporalmente
            const originalText = btnExportar.innerHTML;
            btnExportar.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Generando...';
            btnExportar.disabled = true;

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');

            // Configurar fuente
            doc.setFont('helvetica');

            // ==============================
            // ENCABEZADO DEL DOCUMENTO
            // ==============================
            let yPos = 10;

            // Título principal
            doc.setFontSize(16);
            doc.setTextColor(0, 0, 128);
            doc.setFont('helvetica', 'bold');
            doc.text('INSTITUTO SUPERIOR TECNOLÓGICO TURÍSTICO Y PATRIMONIAL "YAVIRAC"', 105, yPos, { align: 'center' });
            yPos += 8;

            doc.setFontSize(14);
            doc.text('INFORME DE SEGUIMIENTO - PLAN OPERATIVO ANUAL', 105, yPos, { align: 'center' });
            yPos += 6;

            doc.setFontSize(11);
            doc.setTextColor(0, 0, 0);
            
            // Obtener fecha de seguimiento del modal actual
            const fechaSeguimientoInput = document.querySelector('input[name="fecha_seguimiento"]');
            const fechaSeguimiento = fechaSeguimientoInput ? fechaSeguimientoInput.value : 'No especificada';
            doc.text(`Fecha de Seguimiento: ${fechaSeguimiento}`, 105, yPos, { align: 'center' });
            yPos += 12;

            // Línea separadora
            doc.setDrawColor(0, 0, 128);
            doc.setLineWidth(0.5);
            doc.line(20, yPos, 190, yPos);
            yPos += 15;

            // ==============================
            // INFORMACIÓN GENERAL
            // ==============================
            doc.setFontSize(12);
            doc.setTextColor(0, 0, 128);
            doc.setFont('helvetica', 'bold');
            doc.text('1. INFORMACIÓN GENERAL DEL PLAN', 20, yPos);
            yPos += 8;

            // Función auxiliar para crear secciones
            function crearSeccion(titulo, contenido) {
                if (yPos > 270) {
                    doc.addPage();
                    yPos = 20;
                }
                
                doc.setFontSize(10);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text(titulo + ':', 20, yPos);
                yPos += 5;

                doc.setFontSize(9);
                doc.setTextColor(0, 0, 0);
                doc.setFont('helvetica', 'normal');
                
                let texto = contenido || 'No especificado';
                if (texto === 'No especificado') {
                    doc.setTextColor(120, 120, 120);
                }
                
                const lineas = doc.splitTextToSize(texto, 170);
                lineas.forEach((linea, idx) => {
                    doc.text(linea, 25, yPos + (idx * 4));
                });
                
                yPos += (lineas.length * 4) + 6;
                doc.setTextColor(0, 0, 0);
            }

            // Obtener datos del modal actual
            function obtenerValor(selector) {
                try {
                    const element = document.querySelector(selector);
                    return element && element.value ? element.value.trim() : 'No especificado';
                } catch (e) {
                    return 'No especificado';
                }
            }

            // Obtener los valores
            const tema = obtenerValor('.campo-solo-lectura:nth-of-type(1)');
            const eje = obtenerValor('.campo-solo-lectura:nth-of-type(2)');
            const objetivo = obtenerValor('textarea.campo-solo-lectura:nth-of-type(1)');
            const indicador = obtenerValor('.campo-solo-lectura:nth-of-type(3)') || obtenerValor('.campo-solo-lectura:nth-of-type(4)');
            const lineaBase = obtenerValor('.campo-solo-lectura:nth-of-type(5)') || obtenerValor('.campo-solo-lectura:nth-of-type(4)');
            const politicas = obtenerValor('textarea.campo-solo-lectura:nth-of-type(2)');
            const metas = obtenerValor('textarea.campo-solo-lectura:nth-of-type(3)');
            const actividades = obtenerValor('textarea.campo-solo-lectura:nth-of-type(4)');
            const indicadorResultado = obtenerValor('textarea.campo-solo-lectura:nth-of-type(5)');
            const responsable = obtenerValor('.responsable-input');
            const elaborado = obtenerValor('.elaborado-input');
            const nombreResponsable = obtenerValor('.nombre-responsable-input');
            const observacionGeneral = obtenerValor('.observacion-general');

            // Agregar secciones al PDF
            crearSeccion('Tema', tema);
            crearSeccion('Eje Estratégico', eje);
            crearSeccion('Objetivo', objetivo);
            crearSeccion('Indicador', indicador);
            crearSeccion('Línea Base', lineaBase);
            crearSeccion('Políticas', politicas);
            crearSeccion('Metas', metas);
            crearSeccion('Actividades', actividades);
            crearSeccion('Indicador de Resultado', indicadorResultado);

            // ==============================
            // MEDIOS DE VERIFICACIÓN
            // ==============================
            if (yPos > 200) {
                doc.addPage();
                yPos = 20;
            }

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 128);
            doc.setFont('helvetica', 'bold');
            doc.text('2. EVALUACIÓN DE MEDIOS DE VERIFICACIÓN', 20, yPos);
            yPos += 10;

            // Obtener porcentaje de cumplimiento
            let porcentajeNum = 0;
            let cumplidos = 0;
            let total = 0;
            
            // Intentar obtener del DOM
            const porcentajeElement = document.getElementById('porcentaje-total');
            if (porcentajeElement) {
                const porcentajeText = porcentajeElement.textContent;
                porcentajeNum = parseInt(porcentajeText) || 0;
            }

            // Mostrar porcentaje
            doc.setFontSize(10);
            doc.setFont('helvetica', 'bold');
            doc.text('PORCENTAJE DE CUMPLIMIENTO:', 20, yPos);
            yPos += 7;
            
            // Color según porcentaje
            let porcentajeColor = [0, 0, 0];
            if (porcentajeNum >= 90) {
                porcentajeColor = [0, 128, 0];
            } else if (porcentajeNum >= 70) {
                porcentajeColor = [0, 128, 255];
            } else if (porcentajeNum >= 60) {
                porcentajeColor = [255, 193, 7];
            } else {
                porcentajeColor = [255, 0, 0];
            }
            
            doc.setTextColor(porcentajeColor[0], porcentajeColor[1], porcentajeColor[2]);
            doc.setFontSize(14);
            doc.text(`${porcentajeNum}%`, 20, yPos);
            yPos += 8;
            
            doc.setFontSize(9);
            doc.setTextColor(0, 0, 0);
            doc.text(`${cumplidos} de ${total} medios cumplidos`, 20, yPos);
            yPos += 15;

            // Tabla de medios de verificación
            const filasMedios = document.querySelectorAll('#medios-tbody tr[data-medio-id]');
            
            if (filasMedios.length > 0) {
                // Configurar tabla
                const anchoPagina = 170;
                const anchoNum = 10;
                const anchoDetalle = 100;
                const anchoPlazo = 25;
                const anchoEstado = 35;

                // Cabecera de la tabla
                doc.setFillColor(240, 240, 240);
                doc.rect(20, yPos, anchoPagina, 8, 'F');
                doc.setDrawColor(0, 0, 0);
                doc.setLineWidth(0.2);
                
                // Dibujar líneas verticales
                doc.line(20, yPos, 20, yPos + 8);
                doc.line(20 + anchoNum, yPos, 20 + anchoNum, yPos + 8);
                doc.line(20 + anchoNum + anchoDetalle, yPos, 20 + anchoNum + anchoDetalle, yPos + 8);
                doc.line(20 + anchoNum + anchoDetalle + anchoPlazo, yPos, 20 + anchoNum + anchoDetalle + anchoPlazo, yPos + 8);
                doc.line(20 + anchoPagina, yPos, 20 + anchoPagina, yPos + 8);
                
                // Texto de cabecera
                doc.setFontSize(9);
                doc.setTextColor(0, 0, 0);
                doc.setFont('helvetica', 'bold');
                doc.text('#', 22, yPos + 5.5);
                doc.text('DETALLE', 20 + anchoNum + 2, yPos + 5.5);
                doc.text('PLAZO', 20 + anchoNum + anchoDetalle + 2, yPos + 5.5);
                doc.text('ESTADO', 20 + anchoNum + anchoDetalle + anchoPlazo + 2, yPos + 5.5);
                
                yPos += 8;

                // Filas de datos
                filasMedios.forEach((fila, index) => {
                    if (yPos > 270) {
                        doc.addPage();
                        yPos = 20;
                    }

                    // Obtener datos de la fila
                    let detalle = '';
                    let plazo = '';
                    let estado = '';
                    
                    try {
                        detalle = fila.querySelector('.detalle-medio') ? fila.querySelector('.detalle-medio').value : '';
                        plazo = fila.querySelector('.plazo-medio') ? fila.querySelector('.plazo-medio').value : '';
                        estado = fila.querySelector('.estado-medio') ? fila.querySelector('.estado-medio').value : '';
                    } catch (e) {
                        console.error('Error obteniendo datos de fila:', e);
                    }

                    // Calcular altura de fila
                    doc.setFont('helvetica', 'normal');
                    const detalleLineas = doc.splitTextToSize(detalle || 'No especificado', anchoDetalle - 4);
                    const estadoLineas = doc.splitTextToSize(estado || 'No evaluado', anchoEstado - 4);
                    const alturaFila = Math.max(8, Math.max(detalleLineas.length, estadoLineas.length) * 4 + 4);

                    // Fondo alternado
                    if (index % 2 === 0) {
                        doc.setFillColor(250, 250, 250);
                    } else {
                        doc.setFillColor(245, 245, 245);
                    }
                    doc.rect(20, yPos, anchoPagina, alturaFila, 'F');

                    // Contenido
                    doc.setFontSize(9);
                    doc.setTextColor(0, 0, 0);
                    
                    // Número
                    doc.text((index + 1).toString(), 22, yPos + 5);
                    
                    // Detalle
                    detalleLineas.forEach((linea, idx) => {
                        doc.text(linea, 20 + anchoNum + 2, yPos + 5 + (idx * 4));
                    });
                    
                    // Plazo
                    doc.text(plazo || 'No especificado', 20 + anchoNum + anchoDetalle + 2, yPos + 5);
                    
                    // Estado con color
                    if (estado && estado.includes('CUMPLE')) {
                        doc.setTextColor(0, 128, 0);
                    } else if (estado && estado.includes('NO CUMPLE')) {
                        doc.setTextColor(255, 0, 0);
                    } else {
                        doc.setTextColor(100, 100, 100);
                    }
                    
                    estadoLineas.forEach((linea, idx) => {
                        doc.text(linea, 20 + anchoNum + anchoDetalle + anchoPlazo + 2, yPos + 5 + (idx * 4));
                    });
                    
                    // Restaurar color negro
                    doc.setTextColor(0, 0, 0);
                    
                    yPos += alturaFila;
                });
            } else {
                doc.setFontSize(10);
                doc.setTextColor(120, 120, 120);
                doc.text('No hay medios de verificación definidos', 22, yPos);
                yPos += 10;
            }

            yPos += 10;

            // ==============================
            // OBSERVACIÓN GENERAL
            // ==============================
            if (yPos > 250) {
                doc.addPage();
                yPos = 20;
            }

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 128);
            doc.setFont('helvetica', 'bold');
            doc.text('3. OBSERVACIÓN GENERAL', 20, yPos);
            yPos += 8;

            if (observacionGeneral && observacionGeneral !== 'No especificado') {
                doc.setFontSize(10);
                doc.setTextColor(0, 0, 0);
                doc.setFont('helvetica', 'normal');
                
                const lineas = doc.splitTextToSize(observacionGeneral, 170);
                lineas.forEach((linea, idx) => {
                    doc.text(linea, 20, yPos + (idx * 4.5));
                });
                
                yPos += (lineas.length * 4.5) + 12;
            }

            // ==============================
            // FIRMAS
            // ==============================
            if (yPos > 200) {
                doc.addPage();
                yPos = 20;
            }

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 128);
            doc.setFont('helvetica', 'bold');
            doc.text('4. FIRMAS DE RESPONSABILIDAD', 20, yPos);
            yPos += 15;

            // Dimensiones para firmas
            const anchoFirma = 70;
            const espacioEntreFirmas = 30;
            
            // Elaborado por
            doc.setFontSize(11);
            doc.setFont('helvetica', 'bold');
            doc.text('ELABORADO POR:', 20, yPos);
            
            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            doc.text(elaborado || 'No especificado', 20, yPos + 7);
            
            // Línea de firma
            doc.setDrawColor(0, 0, 0);
            doc.setLineWidth(0.3);
            doc.line(20, yPos + 12, 20 + anchoFirma, yPos + 12);
            
            doc.setFontSize(8);
            doc.setTextColor(100, 100, 100);
            doc.text('Firma y sello', 20, yPos + 18);

            // Revisado por
            doc.setFontSize(11);
            doc.setTextColor(0, 0, 128);
            doc.setFont('helvetica', 'bold');
            doc.text('REVISADO POR:', 20 + anchoFirma + espacioEntreFirmas, yPos);
            
            doc.setFontSize(10);
            doc.setTextColor(0, 0, 0);
            doc.setFont('helvetica', 'normal');
            doc.text(responsable || 'No especificado', 20 + anchoFirma + espacioEntreFirmas, yPos + 7);
            
            // Línea de firma
            doc.line(20 + anchoFirma + espacioEntreFirmas, yPos + 12, 20 + anchoFirma + espacioEntreFirmas + anchoFirma, yPos + 12);
            
            doc.setFontSize(8);
            doc.setTextColor(100, 100, 100);
            doc.text('Firma y sello', 20 + anchoFirma + espacioEntreFirmas, yPos + 18);

            // ==============================
            // PIE DE PÁGINA
            // ==============================
            doc.setFontSize(8);
            doc.setTextColor(100, 100, 100);
            doc.text(`Documento generado el: ${new Date().toLocaleDateString('es-ES')}`, 105, 285, { align: 'center' });
            doc.text('ISTTP "YAVIRAC" - Sistema de Seguimiento POA', 105, 290, { align: 'center' });

            // ==============================
            // GUARDAR PDF
            // ==============================
            const fechaActual = new Date().toISOString().split('T')[0];
            const nombreSeguro = (elaborado || 'Seguimiento').replace(/[^a-z0-9]/gi, '_').substring(0, 30);
            const nombreArchivo = `Seguimiento_POA_${nombreSeguro}_${fechaActual}.pdf`;
            
            console.log('Guardando PDF de seguimiento como:', nombreArchivo);
            
            // Guardar PDF
            doc.save(nombreArchivo);
            
            // Restaurar botón
            btnExportar.innerHTML = originalText;
            btnExportar.disabled = false;
            
            // Mostrar mensaje de éxito
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'PDF generado',
                    text: 'El PDF de seguimiento se ha generado y descargado exitosamente',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert('✅ PDF generado exitosamente');
            }

        } catch (error) {
            console.error('❌ Error al generar PDF de seguimiento:', error);
            
            // Restaurar botón en caso de error
            const btnExportar = document.querySelector('#btn-exportar');
            if (btnExportar) {
                btnExportar.innerHTML = '<i class="fas fa-file-pdf me-1"></i> Exportar PDF';
                btnExportar.disabled = false;
            }
            
            // Mostrar error
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo generar el PDF: ' + error.message
                });
            } else {
                alert('❌ Error al generar el PDF: ' + error.message);
            }
        }
    };



    // ============================================
    // FUNCIÓN MEJORADA PARA ACTUALIZAR TODO
    // ============================================

    function actualizarTodo(elemento, idIndicadorPreseleccionado = null) {
        console.log('🔄 EJECUTANDO actualizarTodo mejorado');

        const txtObjetivo = document.getElementById('objetivo_display');
        const selectIndicador = document.getElementById('indicador_select');

        if (!txtObjetivo || !selectIndicador) {
            console.error('❌ Elementos no encontrados');
            return;
        }

        if (!elemento || elemento.value === "" || elemento.value === "0") {
            txtObjetivo.value = "";
            selectIndicador.innerHTML = '<option value="">-- Primero seleccione un eje --</option>';

            // Ocultar cards de indicadores
            const cardsContainer = document.getElementById('cards-indicadores-container');
            if (cardsContainer) {
                cardsContainer.style.display = 'none';
            }
            return;
        }

        // Mostrar objetivo
        const opcionSeleccionada = elemento.options[elemento.selectedIndex];
        const objetivo = opcionSeleccionada ? opcionSeleccionada.getAttribute('data-objetivo') : '';

        if (objetivo && objetivo.trim() !== "") {
            txtObjetivo.value = objetivo;
        } else {
            txtObjetivo.value = "No hay objetivo registrado para este eje.";
        }

        // Cargar indicadores y mostrar cards
        selectIndicador.innerHTML = '<option value="">Cargando indicadores...</option>';
        selectIndicador.disabled = true;

        fetch('index.php?action=indicadoresPorEje&id_eje=' + elemento.value)
            .then(response => response.json())
            .then(data => {
                console.log('✅ Indicadores para cards:', data);

                // Actualizar select tradicional
                let opciones = '<option value="">-- Seleccione un Indicador --</option>';

                if (data && Array.isArray(data) && data.length > 0) {
                    const idParaPreseleccionar = idIndicadorPreseleccionado || window.idIndicadorGuardadoGlobal;

                    data.forEach(ind => {
                        const esSeleccionado = (idParaPreseleccionar == ind.id_indicador) ? 'selected' : '';
                        opciones += `<option value="${ind.id_indicador}" ${esSeleccionado}>${ind.codigo} - ${ind.descripcion}</option>`;
                    });
                } else {
                    opciones = '<option value="">No hay indicadores para este eje</option>';
                }

                selectIndicador.innerHTML = opciones;
                selectIndicador.disabled = false;

                // Mostrar cards si la función existe
                if (typeof mostrarCardsIndicadores === 'function') {
                    mostrarCardsIndicadores(data);
                }

            })
            .catch(error => {
                console.error('❌ Error:', error);
                selectIndicador.innerHTML = '<option value="">Error al cargar indicadores</option>';
                selectIndicador.disabled = false;
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
    document.addEventListener('DOMContentLoaded', function () {
        const closeBtn = document.getElementById('sidebarCloseMobile');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
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
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 991.98) {
                        toggleSidebar();
                    }
                });
            });
        }

        window.addEventListener('resize', function () {
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