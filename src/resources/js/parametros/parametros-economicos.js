/**
 * Módulo para manejar los parámetros económicos
 */
const ParametrosEconomicos = {
    apiUrl: '/api/parametros-sistema/parametros-economicos',
    
    init: function() {
        console.log('Inicializando ParametrosEconomicos');
        this.loadParametros();
        this.setupEventListeners();
    },
    
    setupEventListeners: function() {
        // Event delegation para botones de acción
        document.addEventListener('click', (e) => {
            const target = e.target.closest('button');
            if (!target) return;

            const action = target.dataset.action;
            const type = target.dataset.type;
            
            // Manejar botones de parámetros económicos
            if (type === 'parametro') {
                if (action === 'create') {
                    this.openCreateModal();
                } else if (action === 'edit') {
                    const id = target.dataset.id;
                    this.editParametro(id);
                } else if (action === 'delete') {
                    const id = target.dataset.id;
                    this.confirmDelete(id);
                } else if (action === 'toggle') {
                    const id = target.dataset.id;
                    this.toggleStatus(id);
                }
            }
        });
        
        // Botón para guardar parámetro en modal
        const btnGuardar = document.getElementById('btnGuardarParametro');
        if (btnGuardar) {
            btnGuardar.addEventListener('click', () => {
                this.saveParametro();
            });
        }
        
        // Botón para confirmar eliminación en modal
        const btnConfirmDelete = document.getElementById('btnConfirmDelete');
        if (btnConfirmDelete) {
            btnConfirmDelete.addEventListener('click', () => {
                const type = document.getElementById('deleteType').value;
                if (type === 'parametro') {
                    const id = document.getElementById('deleteId').value;
                    this.deleteParametro(id);
                }
            });
        }
    },
    
    loadParametros: function() {
        console.log('Cargando parámetros económicos');
        
        fetch(this.apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar parámetros económicos');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.renderParametros(data.data);
                } else {
                    console.error('Error en la respuesta:', data.message);
                    this.showAlert('error', 'Error al cargar parámetros económicos: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al cargar parámetros económicos:', error);
                this.showAlert('error', 'Error al cargar parámetros económicos: ' + error.message);
            });
    },
    
    renderParametros: function(parametros) {
        const tbody = document.querySelector('#parametrosTable tbody');
        if (!tbody) return;
        
        tbody.innerHTML = '';
        
        if (parametros.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = '<td colspan="6" class="text-center">No hay parámetros económicos registrados</td>';
            tbody.appendChild(row);
            return;
        }
        
        parametros.forEach(parametro => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${parametro.id_parametro_economico}</td>
                <td>${parametro.nombre}</td>
                <td>${parametro.valor}</td>
                <td>${parametro.descripcion || ''}</td>
                <td>
                    <span class="badge badge-${parametro.estado ? 'success' : 'danger'}">
                        ${parametro.estado ? 'Activo' : 'Inactivo'}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-info" data-action="edit" data-type="parametro" data-id="${parametro.id_parametro_economico}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" data-action="delete" data-type="parametro" data-id="${parametro.id_parametro_economico}">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button class="btn btn-sm btn-${parametro.estado ? 'warning' : 'success'}" data-action="toggle" data-type="parametro" data-id="${parametro.id_parametro_economico}">
                        <i class="fas fa-${parametro.estado ? 'ban' : 'check'}"></i>
                    </button>
                </td>
            `;
            
            tbody.appendChild(row);
        });
    },
    
    editParametro: function(id) {
        console.log('Editando parámetro:', id);
        
        fetch(`${this.apiUrl}/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener parámetro');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const parametro = data.data;
                    document.getElementById('parametroId').value = parametro.id_parametro_economico;
                    document.getElementById('parametroNombre').value = parametro.nombre;
                    document.getElementById('parametroValor').value = parametro.valor;
                    document.getElementById('parametroDescripcion').value = parametro.descripcion || '';
                    document.getElementById('parametroEstado').value = parametro.estado ? '1' : '0';
                    
                    document.getElementById('parametroModalLabel').textContent = 'Editar Parámetro Económico';
                    $('#parametroModal').modal('show');
                } else {
                    console.error('Error en la respuesta:', data.message);
                    this.showAlert('error', 'Error al cargar parámetro: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al cargar parámetro:', error);
                this.showAlert('error', 'Error al cargar parámetro: ' + error.message);
            });
    },
    
    saveParametro: function() {
        const id = document.getElementById('parametroId').value;
        const isNew = id === '';
        
        const parametro = {
            nombre: document.getElementById('parametroNombre').value,
            valor: document.getElementById('parametroValor').value,
            descripcion: document.getElementById('parametroDescripcion').value,
            estado: document.getElementById('parametroEstado').value
        };
        
        // Validación básica
        if (!parametro.nombre || !parametro.valor) {
            this.showAlert('error', 'Por favor complete los campos obligatorios');
            return;
        }
        
        const url = isNew ? this.apiUrl : `${this.apiUrl}/${id}`;
        const method = isNew ? 'POST' : 'PUT';
        
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(parametro)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Error al guardar parámetro');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                this.showAlert('success', isNew ? 'Parámetro creado correctamente' : 'Parámetro actualizado correctamente');
                $('#parametroModal').modal('hide');
                this.loadParametros();
            } else {
                console.error('Error en la respuesta:', data.message);
                this.showAlert('error', 'Error al guardar parámetro: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al guardar parámetro:', error);
            this.showAlert('error', 'Error al guardar parámetro: ' + error.message);
        });
    },
    
    deleteParametro: function(id) {
        console.log('Eliminando parámetro:', id);
        
        fetch(`${this.apiUrl}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al eliminar parámetro');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                this.showAlert('success', 'Parámetro eliminado correctamente');
                $('#deleteModal').modal('hide');
                this.loadParametros();
            } else {
                console.error('Error en la respuesta:', data.message);
                this.showAlert('error', 'Error al eliminar parámetro: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al eliminar parámetro:', error);
            this.showAlert('error', 'Error al eliminar parámetro: ' + error.message);
        });
    },
    
    toggleStatus: function(id) {
        console.log('Cambiando estado del parámetro:', id);
        
        fetch(`${this.apiUrl}/${id}/toggle-status`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cambiar estado del parámetro');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                this.showAlert('success', 'Estado actualizado correctamente');
                this.loadParametros();
            } else {
                console.error('Error en la respuesta:', data.message);
                this.showAlert('error', 'Error al cambiar estado: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al cambiar estado:', error);
            this.showAlert('error', 'Error al cambiar estado: ' + error.message);
        });
    },
    
    openCreateModal: function() {
        this.resetForm();
        document.getElementById('parametroModalLabel').textContent = 'Nuevo Parámetro Económico';
        $('#parametroModal').modal('show');
    },

    confirmDelete: function(id, type) {
        document.getElementById('deleteId').value = id;
        document.getElementById('deleteType').value = type;
        $('#deleteModal').modal('show');
    },
    
    resetForm: function() {
        document.getElementById('parametroForm').reset();
        document.getElementById('parametroId').value = '';
    },
    
    showAlert: function(type, message) {
        // Crear alerta Bootstrap
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas ${iconClass} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Agregar alerta al body
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            const alert = document.body.lastElementChild;
            if (alert && alert.classList.contains('alert')) {
                alert.remove();
            }
        }, 5000);
    }
};

export default ParametrosEconomicos;
