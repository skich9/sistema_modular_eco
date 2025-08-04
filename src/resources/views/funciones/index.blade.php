@extends('layouts.app')

@section('title', 'Gestión de Funciones')

@section('content')
<!-- Menú de navegación -->
<x-navigation-menu />

<div class="content-container">
	<div class="content-wrapper">
		<!-- Header -->
		<div class="card mb-4">
			<div class="card-header">
				<div class="header-wrapper">
					<div class="header-content">
						<h1 class="page-title">Gestión de Funciones</h1>
						<p class="page-subtitle">Administra las funciones del sistema</p>
					</div>
					<button onclick="openModal('create')" class="btn-primary">
						<i class="fas fa-plus mr-2"></i>
						Nueva Función
					</button>
				</div>
			</div>
		</div>

		<!-- Alerts -->
		@if(session('success'))
			<div class="alert alert-success mb-4">
				{{ session('success') }}
			</div>
		@endif

		@if(session('error'))
			<div class="alert alert-danger mb-4">
				{{ session('error') }}
			</div>
		@endif

		<!-- Tabla de Funciones -->
		<div class="card">
			<div class="table-container">
				<table class="table">
					<thead>
						<tr>
							<th>Nro</th>
							<th>Nombre</th>
							<th>Descripción</th>
							<th>Usuarios</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						@forelse($funciones as $funcion)
							<tr>
								<td>{{ $funcion->id_funcion }}</td>
								<td>
									<div class="font-medium">{{ $funcion->nombre }}</div>
								</td>
								<td>
									{{ $funcion->descripcion ?? 'Sin descripción' }}
								</td>
								<td>
									<span class="badge badge-info">
										{{ $funcion->usuarios_count }} usuarios
									</span>
								</td>
								<td>
									<label class="toggle-switch">
										<input type="checkbox" 
											   class="toggle-input"
											   {{ $funcion->estado ? 'checked' : '' }}
											   onchange="toggleStatus({{ $funcion->id_funcion }}, this.checked, 'funcion')">
										<span class="toggle-label {{ $funcion->estado ? 'active' : 'inactive' }}">
											{{ $funcion->estado ? 'Activo' : 'Inactivo' }}
										</span>
									</label>
								</td>
								<td class="actions-cell">
									<button onclick="editFuncion({{ $funcion->id_funcion }})" class="btn-secondary btn-sm">
										<i class="fas fa-edit"></i> Editar
									</button>
									<button onclick="deleteFuncion({{ $funcion->id_funcion }})" class="btn-danger btn-sm">
										<i class="fas fa-trash"></i> Eliminar
									</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="empty-table">
									No hay funciones registradas
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal para Crear/Editar Función -->
<div id="funcionModal" class="modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="modalTitle">Nueva Función</h3>
				<button type="button" onclick="closeModal()" class="close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			
			<div class="modal-body">
				<form id="funcionForm" method="POST">
					@csrf
					<div id="methodField"></div>
					
					<div class="form-group mb-3">
						<label for="nombre" class="form-label">Nombre *</label>
						<input type="text" id="nombre" name="nombre" required class="form-input">
					</div>
					
					<div class="form-group mb-3">
						<label for="descripcion" class="form-label">Descripción</label>
						<textarea id="descripcion" name="descripcion" rows="3" class="form-textarea"></textarea>
					</div>
					
					<div class="form-group mb-4">
						<div class="form-check">
							<input type="checkbox" id="estado" name="estado" value="1" checked class="form-check-input">
							<label for="estado" class="form-check-label">Activo</label>
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

<script>
function openModal(mode, funcionId = null) {
	const modal = document.getElementById('funcionModal');
	const form = document.getElementById('funcionForm');
	const title = document.getElementById('modalTitle');
	const methodField = document.getElementById('methodField');
	
	if (mode === 'create') {
		title.textContent = 'Nueva Función';
		form.action = '{{ route("funciones.store") }}';
		methodField.innerHTML = '';
		form.reset();
		document.getElementById('estado').checked = true;
	}
	
	modal.classList.add('show');
	modal.style.display = 'block';
}

function closeModal() {
	const modal = document.getElementById('funcionModal');
	modal.classList.remove('show');
	modal.style.display = 'none';
}

function editFuncion(id) {
	fetch(`/funciones/${id}`)
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				const funcion = data.data;
				const modal = document.getElementById('funcionModal');
				const form = document.getElementById('funcionForm');
				const title = document.getElementById('modalTitle');
				const methodField = document.getElementById('methodField');
				
				title.textContent = 'Editar Función';
				form.action = `/funciones/${id}`;
				methodField.innerHTML = '@method("PUT")';
				
				document.getElementById('nombre').value = funcion.nombre;
				document.getElementById('descripcion').value = funcion.descripcion || '';
				document.getElementById('estado').checked = funcion.estado;
				
				modal.classList.add('show');
				modal.style.display = 'block';
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showNotification('Error al cargar los datos', 'error');
		});
}

function deleteFuncion(id) {
	if (confirm('¿Estás seguro de que deseas eliminar esta función?')) {
		const form = document.createElement('form');
		form.method = 'POST';
		form.action = `/funciones/${id}`;
		form.innerHTML = `
			@csrf
			@method('DELETE')
		`;
		document.body.appendChild(form);
		form.submit();
	}
}

function toggleStatus(id, status, type) {
	fetch(`/${type}s/${id}/toggle-status`, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': '{{ csrf_token() }}'
		},
		body: JSON.stringify({ estado: status })
	})
	.then(response => response.json())
	.then(data => {
		if (!data.success) {
			location.reload();
		} else {
			const statusLabel = document.querySelector(`tr[data-id="${id}"] .toggle-label`);
			if (statusLabel) {
				statusLabel.textContent = status ? 'Activo' : 'Inactivo';
				statusLabel.className = `toggle-label ${status ? 'active' : 'inactive'}`;
			}
		}
	})
	.catch(error => {
		console.error('Error:', error);
		showNotification('Error al cambiar el estado', 'error');
	});
}

function showNotification(message, type = 'success') {
	const alertDiv = document.createElement('div');
	alertDiv.className = `alert alert-${type} mb-4`;
	alertDiv.textContent = message;
	
	const container = document.querySelector('.content-wrapper');
	container.insertBefore(alertDiv, container.querySelector('.card:nth-child(2)'));
	
	setTimeout(() => {
		alertDiv.remove();
	}, 5000);
}

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
	// Cerrar modal al hacer clic fuera
	const modal = document.getElementById('funcionModal');
	window.onclick = function(event) {
		if (event.target == modal) {
			closeModal();
		}
	};
	
	// Asegurar que el modal esté oculto inicialmente
	modal.style.display = 'none';
	
	// Agregar data-id a las filas para facilitar la actualización de estado
	document.querySelectorAll('tbody tr').forEach(tr => {
		const id = tr.querySelector('td:first-child').textContent.trim();
		if (id && !isNaN(id)) {
			tr.setAttribute('data-id', id);
		}
	});
});
</script>
@endsection
