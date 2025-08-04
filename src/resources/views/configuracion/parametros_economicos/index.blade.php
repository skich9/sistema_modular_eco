@extends('layouts.app')

@section('content')
<!-- Menú de navegación -->
<x-navigation-menu />

<div class="container mx-auto px-4 py-6">
	<div class="flex justify-between items-center mb-6">
		<h1 class="text-2xl font-bold">Parámetros Económicos</h1>
		<button type="button" onclick="openCreateModal()" class="btn-primary">
			<i class="fas fa-plus mr-2"></i> Nuevo Parámetro
		</button>
	</div>

	<!-- Alerta de éxito -->
	@if(session('success'))
	<div id="success-alert" class="alert alert-success" role="alert">
		<p>{{ session('success') }}</p>
		<button onclick="document.getElementById('success-alert').remove()" class="absolute top-0 right-0 mt-2 mr-2">
			<i class="fas fa-times"></i>
		</button>
	</div>
	@endif

	<!-- Alerta de error -->
	@if(session('error'))
	<div id="error-alert" class="alert alert-danger" role="alert">
		<p>{{ session('error') }}</p>
		<button onclick="document.getElementById('error-alert').remove()" class="absolute top-0 right-0 mt-2 mr-2">
			<i class="fas fa-times"></i>
		</button>
	</div>
	@endif

	<!-- Tabla de parámetros económicos -->
	<div class="card">
		<div class="table-container">
			<table class="table">
				<thead>
					<tr>
						<th>Nro</th>
						<th>Nombre</th>
						<th>Valor</th>
						<th>Descripción</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
				@forelse($parametros as $parametro)
				<tr>
					<td>{{ $parametro->id_parametro_economico }}</td>
					<td>{{ $parametro->nombre }}</td>
					<td>{{ number_format($parametro->valor, 2) }}</td>
					<td>{{ $parametro->descripcion }}</td>
					<td>
						<span class="badge {{ $parametro->estado ? 'badge-success' : 'badge-danger' }}">
							{{ $parametro->estado ? 'Activo' : 'Inactivo' }}
						</span>
					</td>
					<td>
						<div class="action-buttons">
							<button type="button" onclick="toggleStatus({{ $parametro->id_parametro_economico }})" class="btn-icon btn-info" title="{{ $parametro->estado ? 'Desactivar' : 'Activar' }}">
								<i class="fas {{ $parametro->estado ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
							</button>
							<button type="button" onclick="openEditModal({{ $parametro->id_parametro_economico }})" class="btn-icon btn-warning" title="Editar">
								<i class="fas fa-edit"></i>
							</button>
							<button type="button" onclick="confirmDelete({{ $parametro->id_parametro_economico }})" class="btn-icon btn-danger" title="Eliminar">
								<i class="fas fa-trash-alt"></i>
							</button>
						</div>
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="6" class="text-center">No hay parámetros económicos registrados</td>
				</tr>
				@endforelse
			</tbody>
		</table>
		</div>
	</div>

	<!-- Modal para crear/editar parámetro económico -->
	<div id="paramModal" class="modal-backdrop hidden">
		<div class="modal">
			<div class="modal-header">
				<h3 id="modal-title" class="text-xl"></h3>
				<button type="button" onclick="closeModal()" class="text-gray-500">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form id="paramForm">
					<input type="hidden" id="param_id" name="param_id">
					<div class="form-group">
						<label for="nombre" class="form-label">Nombre</label>
						<input type="text" id="nombre" name="nombre" class="form-input" required>
					</div>
					<div class="form-group">
						<label for="valor" class="form-label">Valor</label>
						<input type="number" id="valor" name="valor" step="0.01" min="0" class="form-input" required>
					</div>
					<div class="form-group">
						<label for="descripcion" class="form-label">Descripción</label>
						<input type="text" id="descripcion" name="descripcion" class="form-input" required>
					</div>
					<div class="form-group">
						<label for="estado" class="form-label">Estado</label>
						<select id="estado" name="estado" class="form-input">
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
					<div class="modal-footer">
						<button type="button" onclick="closeModal()" class="btn-secondary">
							Cancelar
						</button>
						<button type="submit" class="btn-primary">
							Guardar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal de confirmación para eliminar -->
	<div id="deleteModal" class="modal-backdrop hidden">
		<div class="modal">
			<div class="modal-header">
				<h3 class="text-xl">Confirmar Eliminación</h3>
				<button type="button" onclick="closeDeleteModal()" class="text-gray-500">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<p>¿Está seguro que desea eliminar este parámetro económico? Esta acción no se puede deshacer.</p>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="closeDeleteModal()" class="btn-secondary">
					Cancelar
				</button>
				<button type="button" id="confirmDeleteBtn" class="btn-danger">
					Eliminar
				</button>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script>
	let deleteId = null;

	function openCreateModal() {
		document.getElementById('modal-title').textContent = 'Crear Parámetro Económico';
		document.getElementById('paramForm').reset();
		document.getElementById('param_id').value = '';
		document.getElementById('paramModal').classList.remove('hidden');
	}

	function openEditModal(id) {
		document.getElementById('modal-title').textContent = 'Editar Parámetro Económico';
		document.getElementById('paramForm').reset();
		document.getElementById('param_id').value = id;
		
		// Obtener datos del parámetro
		fetch(`/configuracion/parametros-economicos/${id}/show`)
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					const parametro = data.data;
					document.getElementById('nombre').value = parametro.nombre;
					document.getElementById('valor').value = parametro.valor;
					document.getElementById('descripcion').value = parametro.descripcion;
					document.getElementById('estado').value = parametro.estado ? '1' : '0';
					document.getElementById('paramModal').classList.remove('hidden');
				} else {
					alert('Error al cargar los datos del parámetro económico');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error al cargar los datos del parámetro económico');
			});
	}

	function closeModal() {
		document.getElementById('paramModal').classList.add('hidden');
	}

	function confirmDelete(id) {
		deleteId = id;
		document.getElementById('deleteModal').classList.remove('hidden');
	}

	function closeDeleteModal() {
		document.getElementById('deleteModal').classList.add('hidden');
		deleteId = null;
	}

	function toggleStatus(id) {
		// Verificar que el token CSRF esté disponible
		const token = document.querySelector('meta[name="csrf-token"]');
		if (!token) {
			console.error('CSRF token not found');
			alert('Error: CSRF token not found');
			return;
		}

		fetch(`/configuracion/parametros-economicos/${id}/toggle-status`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': token.getAttribute('content')
			}
		})
		.then(response => {
			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}
			return response.json();
		})
		.then(data => {
			if (data.success) {
				window.location.reload();
			} else {
				alert('Error al cambiar el estado del parámetro económico: ' + (data.message || 'Error desconocido'));
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error al cambiar el estado del parámetro económico: ' + error.message);
		});
	}

	document.getElementById('paramForm').addEventListener('submit', function(e) {
		e.preventDefault();
		
		// Verificar que el token CSRF esté disponible
		const token = document.querySelector('meta[name="csrf-token"]');
		if (!token) {
			console.error('CSRF token not found');
			alert('Error: CSRF token not found');
			return;
		}
		
		const id = document.getElementById('param_id').value;
		const formData = {
			nombre: document.getElementById('nombre').value,
			valor: document.getElementById('valor').value,
			descripcion: document.getElementById('descripcion').value,
			estado: document.getElementById('estado').value === '1'
		};
		
		const url = id ? `/configuracion/parametros-economicos/${id}` : '/configuracion/parametros-economicos';
		const method = id ? 'PUT' : 'POST';
		
		fetch(url, {
			method: method,
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': token.getAttribute('content')
			},
			body: JSON.stringify(formData)
		})
		.then(response => {
			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}
			return response.json();
		})
		.then(data => {
			if (data.success) {
				window.location.reload();
			} else if (data.errors) {
				const errorMessages = Object.values(data.errors).flat().join('\n');
				alert(`Error: ${errorMessages}`);
			} else {
				alert(`Error: ${data.message || 'Error desconocido'}`);
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error al guardar el parámetro económico: ' + error.message);
		});
	});

	document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
		if (deleteId) {
			// Verificar que el token CSRF esté disponible
			const token = document.querySelector('meta[name="csrf-token"]');
			if (!token) {
				console.error('CSRF token not found');
				alert('Error: CSRF token not found');
				return;
			}
			
			fetch(`/configuracion/parametros-economicos/${deleteId}`, {
				method: 'DELETE',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': token.getAttribute('content')
				}
			})
			.then(response => {
				if (!response.ok) {
					throw new Error(`HTTP error! status: ${response.status}`);
				}
				return response.json();
			})
			.then(data => {
				if (data.success) {
					window.location.reload();
				} else {
					alert(`Error: ${data.message || 'Error desconocido'}`);
					closeDeleteModal();
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error al eliminar el parámetro económico: ' + error.message);
				closeDeleteModal();
			});
		}
	});
</script>
@endsection
