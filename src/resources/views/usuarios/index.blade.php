@extends('layouts.app')

@section('title', 'Registro de Usuarios - Sistema de Cobros CETA')

@section('content')
<!-- Menú de navegación -->
<x-navigation-menu />

	<!-- Main Content -->
	<div class="content-container">
		<!-- Page Header -->
		<div class="card mb-4">
			<div class="card-header">
				<div class="header-wrapper">
					<div class="header-content">
						<h1 class="page-title">Registro Usuarios</h1>
					</div>
				</div>
			</div>
		</div>

		<!-- Alerts -->
		@if(session('success'))
			<div class="alert alert-success mb-4 alert-auto-hide">
				<div class="alert-content">
					<i class="fas fa-check-circle mr-2"></i>
					<span>{{ session('success') }}</span>
				</div>
			</div>
		@endif

		@if(session('error'))
			<div class="alert alert-danger mb-4 alert-auto-hide">
				<div class="alert-content">
					<i class="fas fa-exclamation-triangle mr-2"></i>
					<span>{{ session('error') }}</span>
				</div>
			</div>
		@endif

		<!-- Users Table Card -->
		<div class="card">
			<!-- Table Header -->
			<div class="card-header">
				<h3 class="card-title">Lista de Usuarios</h3>
			</div>

			<!-- Controls -->
			<div class="filter-controls">
				<div class="filter-wrapper">
					<div class="filter-group">
						<div class="filter-item">
							<label class="filter-label">Mostrando</label>
							<select id="perPage" class="form-select form-select-sm">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
							</select>
							<span class="filter-text">registros</span>
						</div>
					</div>
					
					<div class="filter-actions">
						<div class="search-box">
							<input 
								type="text" 
								id="searchInput"
								placeholder="Buscar..." 
								class="form-input"
							>
							<i class="fas fa-search search-icon"></i>
						</div>
						<button 
							onclick="openCreateModal()" 
							class="btn-primary"
						>
							<i class="fas fa-plus mr-2"></i>Añadir Usuario
						</button>
					</div>
				</div>
			</div>

			<!-- Table -->
			<div class="table-container">
				<table class="table">
					<thead>
						<tr>
							<th>
								<button class="sort-button">
									Usuario
									<i class="fas fa-sort ml-1"></i>
								</button>
							</th>
							<th>
								<button class="sort-button">
									Nombre
									<i class="fas fa-sort ml-1"></i>
								</button>
							</th>
							<th>
								<button class="sort-button">
									Rol
									<i class="fas fa-sort ml-1"></i>
								</button>
							</th>
                            <th>
								<button class="sort-button">
									Cargo
									<i class="fas fa-sort ml-1"></i>
								</button>
							</th>
							<th class="text-center">
								<button class="sort-button">
									Activo
									<i class="fas fa-sort ml-1"></i>
								</button>
							</th>
							<th class="text-center">
								Editar
							</th>
						</tr>
					</thead>
					<tbody id="usersTableBody">
						@forelse($usuarios as $usuario)
							<tr data-id="{{ $usuario->id_usuario }}">
								<td>
									{{ $usuario->nickname }}
								</td>
								<td>
									<div class="user-name">
										{{ $usuario->nombre }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}
									</div>
								</td>
								<td>
									{{ $usuario->rol->nombre ?? 'Sin rol' }}
								</td>
                                <td>
									{{ $usuario->rol->descripcion ?? 'Sin descripción' }}
								</td>
								<td class="text-center">
									<label class="toggle-switch">
										<input type="checkbox" 
											   class="toggle-input"
											   {{ $usuario->estado ? 'checked' : '' }}
											   onchange="toggleUserStatus({{ $usuario->id_usuario }}, this.checked)">
										<span class="toggle-label {{ $usuario->estado ? 'active' : 'inactive' }}">
											{{ $usuario->estado ? 'Activo' : 'Inactivo' }}
										</span>
									</label>
								</td>
								<td class="actions-cell">
									<button 
										onclick="editUser({{ $usuario->id_usuario }})"
										class="btn-secondary btn-sm"
									>
										<i class="fas fa-edit"></i> Editar
									</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="empty-table">
									No hay usuarios registrados
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>

			<!-- Pagination -->
			<div class="table-footer">
				<div class="table-info">
					<div class="pagination-info">
						Mostrando de 1 al {{ $usuarios->count() }} de {{ $usuarios->count() }} registros
					</div>
					<div class="flex space-x-1">
						<button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100">Primero</button>
						<button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100">Anterior</button>
						<button class="px-3 py-1 text-sm bg-blue-600 text-white border border-blue-600 rounded">1</button>
						<button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100">Siguiente</button>
						<button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100">Último</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal para Crear/Editar Usuario -->
<div id="userModal" class="modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="modalTitle">Crear Usuario</h3>
				<button type="button" onclick="closeModal()" class="close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			
			<div class="modal-body">
				<form id="userForm" method="POST">
					@csrf
					<div id="methodField"></div>
					
					<div class="form-group mb-3">
						<label for="nickname" class="form-label">Usuario</label>
						<input type="text" name="nickname" id="nickname" required class="form-input">
					</div>
					
					<div class="form-group mb-3">
						<label for="nombre" class="form-label">Nombre</label>
						<input type="text" name="nombre" id="nombre" required class="form-input">
					</div>
					
					<div class="form-group mb-3">
						<label for="ap_paterno" class="form-label">Apellido Paterno</label>
						<input type="text" name="ap_paterno" id="ap_paterno" required class="form-input">
					</div>
					
					<div class="form-group mb-3">
						<label for="ap_materno" class="form-label">Apellido Materno</label>
						<input type="text" name="ap_materno" id="ap_materno" class="form-input">
					</div>
					
					<div class="form-group mb-3">
						<label for="ci" class="form-label">CI</label>
						<input type="text" name="ci" id="ci" required class="form-input">
					</div>
					
					<div id="passwordField" class="form-group mb-3">
						<label for="contrasenia" class="form-label">Contraseña</label>
						<input type="password" name="contrasenia" id="contrasenia" class="form-input">
					</div>
					
					<div class="form-group mb-3">
						<label for="id_rol" class="form-label">Rol</label>
						<select name="id_rol" id="id_rol" required class="form-select">
							<option value="">Seleccione un rol</option>
							@foreach($roles as $rol)
								<option value="{{ $rol->id_rol }}">{{ $rol->nombre }}</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group mb-4">
						<div class="form-check">
							<input type="checkbox" name="estado" id="estado" value="1" checked class="form-check-input">
							<label for="estado" class="form-check-label">Usuario Activo</label>
						</div>
					</div>
					
					<div class="modal-footer">
						<button type="button" onclick="closeModal()" class="btn btn-secondary">
							Cancelar
						</button>
						<button type="submit" class="btn btn-primary">
							Guardar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script>
	let isEditing = false;
	let editingUserId = null;

	// Estas funciones ya están definidas en el componente de navegación
	// No es necesario redefinirlas aquí

	function openCreateModal() {
		isEditing = false;
		document.getElementById('modalTitle').textContent = 'Crear Usuario';
		document.getElementById('userForm').action = '{{ route("usuarios.store") }}';
		document.getElementById('methodField').innerHTML = '';
		document.getElementById('passwordField').style.display = 'block';
		document.getElementById('contrasenia').required = true;
		
		// Limpiar formulario
		document.getElementById('userForm').reset();
		document.getElementById('estado').checked = true;
		
		const modal = document.getElementById('userModal');
		modal.classList.add('show');
		modal.style.display = 'block';
	}

	function editUser(userId) {
		isEditing = true;
		editingUserId = userId;
		document.getElementById('modalTitle').textContent = 'Editar Usuario';
		document.getElementById('userForm').action = `/usuarios/${userId}`;
		document.getElementById('methodField').innerHTML = '@method("PUT")';
		document.getElementById('passwordField').style.display = 'none';
		document.getElementById('contrasenia').required = false;
		
		// Cargar los datos del usuario via AJAX
		fetch(`/usuarios/${userId}/edit`)
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					const usuario = data.data;
					document.getElementById('nickname').value = usuario.nickname;
					document.getElementById('nombre').value = usuario.nombre;
					document.getElementById('ap_paterno').value = usuario.ap_paterno;
					document.getElementById('ap_materno').value = usuario.ap_materno || '';
					document.getElementById('ci').value = usuario.ci;
					document.getElementById('id_rol').value = usuario.id_rol;
					document.getElementById('estado').checked = usuario.estado;
					
					const modal = document.getElementById('userModal');
					modal.classList.add('show');
					modal.style.display = 'block';
				} else {
					showNotification('Error al cargar los datos del usuario', 'error');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				showNotification('Error al cargar los datos del usuario', 'error');
			});
	}

	function closeModal() {
		const modal = document.getElementById('userModal');
		modal.classList.remove('show');
		modal.style.display = 'none';
	}

	function toggleUserStatus(userId, status) {
		fetch(`/usuarios/${userId}/estado`, {
			method: 'PATCH',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			},
			body: JSON.stringify({ estado: status })
		})
		.then(response => response.json())
		.then(data => {
			if (!data.success) {
				showNotification('Error al cambiar el estado del usuario', 'error');
				// Revertir checkbox
				event.target.checked = !status;
			} else {
				// Actualizar la etiqueta de estado
				const statusLabel = document.querySelector(`tr[data-id="${userId}"] .toggle-label`);
				if (statusLabel) {
					statusLabel.textContent = status ? 'Activo' : 'Inactivo';
					statusLabel.className = `toggle-label ${status ? 'active' : 'inactive'}`;
				}
				showNotification('Estado actualizado correctamente', 'success');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showNotification('Error al cambiar el estado del usuario', 'error');
			event.target.checked = !status;
		});
	}

	function showNotification(message, type = 'success') {
		const alertDiv = document.createElement('div');
		alertDiv.className = `alert alert-${type} mb-4 alert-auto-hide`;
		
		const alertContent = document.createElement('div');
		alertContent.className = 'alert-content';
		
		const icon = document.createElement('i');
		icon.className = type === 'success' ? 'fas fa-check-circle mr-2' : 'fas fa-exclamation-triangle mr-2';
		
		const span = document.createElement('span');
		span.textContent = message;
		
		alertContent.appendChild(icon);
		alertContent.appendChild(span);
		alertDiv.appendChild(alertContent);
		
		const container = document.querySelector('.content-container');
		container.insertBefore(alertDiv, container.querySelector('.card:nth-child(2)'));
		
		setTimeout(() => {
			alertDiv.remove();
		}, 5000);
	}

	// Inicialización cuando el DOM está listo
	document.addEventListener('DOMContentLoaded', function() {
		// Cerrar modal al hacer clic fuera
		const modal = document.getElementById('userModal');
		window.onclick = function(event) {
			if (event.target == modal) {
				closeModal();
			}
		};
		
		// Asegurar que el modal esté oculto inicialmente
		modal.style.display = 'none';
		
		// Agregar data-id a las filas para facilitar la actualización de estado
		document.querySelectorAll('tbody tr').forEach(tr => {
			if (!tr.hasAttribute('data-id')) {
				const userId = tr.querySelector('button[onclick^="editUser"]');
				if (userId) {
					const match = userId.getAttribute('onclick').match(/editUser\((\d+)\)/);
					if (match && match[1]) {
						tr.setAttribute('data-id', match[1]);
					}
				}
			}
		});
		
		// No es necesario inicializar eventos para cerrar dropdowns
		// Ya están manejados por el componente de navegación
	});
</script>
@endpush
@endsection
