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

            // Título principal
            doc.setFontSize(22);
            doc.setTextColor(26, 35, 126); // Azul oscuro
            doc.text('PLAN OPERATIVO ANUAL 2024', 105, 20, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);
            doc.text('Formulario: Elaboración POA 2024', 105, 28, { align: 'center' });
            doc.text('ISTTP "YAVIRAC"', 105, 33, { align: 'center' });

            // Línea separadora
            doc.setLineWidth(0.5);
            doc.line(15, 40, 195, 40);

            let yPos = 50;

            // Sección 1: Información General
            doc.setFontSize(14);
            doc.setTextColor(0, 0, 128);
            doc.text('1. INFORMACIÓN GENERAL', 15, yPos);
            yPos += 10;

            doc.setFontSize(11);
            doc.setTextColor(0, 0, 0);

            // Tema
            doc.text('TEMA:', 15, yPos);
            doc.text(datos.tema, 40, yPos);
            yPos += 7;

            // Eje Estratégico
            doc.text('EJE ESTRATÉGICO:', 15, yPos);
            doc.text(datos.eje, 50, yPos);
            yPos += 7;

            // Objetivo del Eje
            doc.text('OBJETIVO DEL EJE:', 15, yPos);
            const objetivoLines = doc.splitTextToSize(datos.objetivo || 'No especificado', 160);
            doc.text(objetivoLines, 50, yPos);
            yPos += (objetivoLines.length * 5) + 5;

            // Indicador
            doc.text('INDICADOR:', 15, yPos);
            const indicadorLines = doc.splitTextToSize(datos.indicador || 'No especificado', 160);
            doc.text(indicadorLines, 40, yPos);
            yPos += (indicadorLines.length * 5) + 5;

            // Responsable
            doc.text('RESPONSABLE:', 15, yPos);
            doc.text(datos.responsable, 45, yPos);
            yPos += 10;

            // Sección 2: Información Base
            doc.setFontSize(14);
            doc.setTextColor(0, 0, 128);
            doc.text('2. INFORMACIÓN BASE', 15, yPos);
            yPos += 10;

            doc.setFontSize(11);
            doc.setTextColor(0, 0, 0);

            // Línea Base
            doc.text('LÍNEA BASE:', 15, yPos);
            const lineaBaseLines = doc.splitTextToSize(datos.linea_base || 'No especificado', 160);
            doc.text(lineaBaseLines, 45, yPos);
            yPos += (lineaBaseLines.length * 5) + 5;

            // Políticas
            if (datos.politicas) {
                doc.text('POLÍTICAS:', 15, yPos);
                const politicasLines = doc.splitTextToSize(datos.politicas, 160);
                doc.text(politicasLines, 45, yPos);
                yPos += (politicasLines.length * 5) + 5;
            }

            // Metas
            if (datos.metas) {
                doc.text('METAS:', 15, yPos);
                const metasLines = doc.splitTextToSize(datos.metas, 160);
                doc.text(metasLines, 35, yPos);
                yPos += (metasLines.length * 5) + 5;
            }

            // Verificar si necesitamos nueva página
            if (yPos > 250) {
                doc.addPage();
                yPos = 20;
            }

            // Sección 3: Ejecución
            doc.setFontSize(14);
            doc.setTextColor(0, 0, 128);
            doc.text('3. EJECUCIÓN', 15, yPos);
            yPos += 10;

            doc.setFontSize(11);
            doc.setTextColor(0, 0, 0);

            // Actividades
            doc.text('ACTIVIDADES:', 15, yPos);
            const actividadesLines = doc.splitTextToSize(datos.actividades || 'No especificado', 160);
            doc.text(actividadesLines, 45, yPos);
            yPos += (actividadesLines.length * 5) + 5;

            // Indicador de Resultado
            if (datos.indicador_resultado) {
                doc.text('INDICADOR DE RESULTADO:', 15, yPos);
                const indicadorResultadoLines = doc.splitTextToSize(datos.indicador_resultado, 160);
                doc.text(indicadorResultadoLines, 65, yPos);
                yPos += (indicadorResultadoLines.length * 5) + 5;
            }

            // Verificar si necesitamos nueva página
            if (yPos > 250) {
                doc.addPage();
                yPos = 20;
            }

            // Sección 4: Medios de Verificación
            doc.setFontSize(14);
            doc.setTextColor(0, 0, 128);
            doc.text('4. MEDIOS DE VERIFICACIÓN', 15, yPos);
            yPos += 10;

            doc.setFontSize(11);
            doc.setTextColor(0, 0, 0);

            if (datos.medios.length > 0) {
                datos.medios.forEach((medio, index) => {
                    doc.text(`${index + 1}. ${medio.detalle}`, 20, yPos);
                    doc.text(`Plazo: ${medio.plazo}`, 160, yPos, { align: 'right' });
                    yPos += 8;

                    // Verificar si necesitamos nueva página
                    if (yPos > 270) {
                        doc.addPage();
                        yPos = 20;
                    }
                });
            } else {
                doc.text('No se han definido medios de verificación', 20, yPos);
                yPos += 8;
            }

            // Firma
            yPos += 10;
            doc.setFontSize(12);
            doc.text('ELABORADO POR:', 20, yPos);
            doc.text('REVISADO POR:', 120, yPos);
            yPos += 15;

            // Líneas para firma
            doc.line(20, yPos, 80, yPos);
            doc.line(120, yPos, 180, yPos);
            yPos += 5;

            doc.setFontSize(10);
            doc.text(datos.elaborado_por, 20, yPos);
            doc.text('_________________________', 120, yPos);
            yPos += 5;

            doc.text('Coordinación de Planificación Estratégica', 20, yPos);
            doc.text('Unidad Responsable', 120, yPos);

            // Pie de página
            doc.setFontSize(8);
            doc.setTextColor(100, 100, 100);
            doc.text('Documento generado automáticamente por el Sistema de Planificación - ISTTP "YAVIRAC"', 105, 285, { align: 'center' });

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