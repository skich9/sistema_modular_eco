@extends('layouts.app')

@section('title', 'Gestión de Roles')

@section('content')
<!-- Menú de navegación -->
<x-navigation-menu />

<div class="min-h-screen bg-gray-50 py-8">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Header -->
		<div class="bg-white shadow rounded-lg mb-6">
			<div class="px-6 py-4 border-b border-gray-200">
				<div class="flex justify-between items-center">
					<div>
						<h1 class="text-2xl font-bold text-gray-900">Gestión de Roles</h1>
						<p class="text-sm text-gray-600 mt-1">Administra los roles del sistema</p>
					</div>
					<button onclick="openModal('create')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
						<i class="fas fa-plus mr-2"></i>
						Nuevo Rol
					</button>
				</div>
			</div>
		</div>

		<!-- Alerts -->
		@if(session('success'))
			<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
				{{ session('success') }}
			</div>
		@endif

		@if(session('error'))
			<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
				{{ session('error') }}
			</div>
		@endif

		<!-- Tabla de Roles -->
		<div class="bg-white shadow rounded-lg overflow-hidden">
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nro</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuarios</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-200">
						@forelse($roles as $rol)
							<tr class="hover:bg-gray-50">
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $rol->id_rol }}</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm font-medium text-gray-900">{{ $rol->nombre }}</div>
								</td>
								<td class="px-6 py-4 text-sm text-gray-500">
									{{ $rol->descripcion ?? 'Sin descripción' }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
									<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
										{{ $rol->usuarios_count }} usuarios
									</span>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<label class="inline-flex items-center">
										<input type="checkbox" 
											   class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300"
											   {{ $rol->estado ? 'checked' : '' }}
											   onchange="toggleStatus({{ $rol->id_rol }}, this.checked, 'rol')">
										<span class="ml-2 text-sm {{ $rol->estado ? 'text-green-600' : 'text-red-600' }}">
											{{ $rol->estado ? 'Activo' : 'Inactivo' }}
										</span>
									</label>
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
									<button onclick="editRol({{ $rol->id_rol }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
										<i class="fas fa-edit"></i> Editar
									</button>
									<button onclick="deleteRol({{ $rol->id_rol }})" class="text-red-600 hover:text-red-900">
										<i class="fas fa-trash"></i> Eliminar
									</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="px-6 py-4 text-center text-gray-500">
									No hay roles registrados
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal para Crear/Editar Rol -->
<div id="rolModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
	<div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
		<div class="mt-3">
			<div class="flex items-center justify-between mb-4">
				<h3 class="text-lg font-medium text-gray-900" id="modalTitle">Nuevo Rol</h3>
				<button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
					<i class="fas fa-times"></i>
				</button>
			</div>
			
			<form id="rolForm" method="POST">
				@csrf
				<div id="methodField"></div>
				
				<div class="mb-4">
					<label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
					<input type="text" id="nombre" name="nombre" required
						   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
				</div>
				
				<div class="mb-4">
					<label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
					<textarea id="descripcion" name="descripcion" rows="3"
							  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
				</div>
				
				<div class="mb-6">
					<label class="flex items-center">
						<input type="checkbox" id="estado" name="estado" value="1" checked
							   class="form-checkbox h-4 w-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
						<span class="ml-2 text-sm text-gray-700">Activo</span>
					</label>
				</div>
				
				<div class="flex justify-end space-x-3">
					<button type="button" onclick="closeModal()" 
							class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
						Cancelar
					</button>
					<button type="submit" 
							class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
						Guardar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
function openModal(mode, rolId = null) {
	const modal = document.getElementById('rolModal');
	const form = document.getElementById('rolForm');
	const title = document.getElementById('modalTitle');
	const methodField = document.getElementById('methodField');
	
	if (mode === 'create') {
		title.textContent = 'Nuevo Rol';
		form.action = '{{ route("roles.store") }}';
		methodField.innerHTML = '';
		form.reset();
		document.getElementById('estado').checked = true;
	}
	
	modal.classList.remove('hidden');
}

function closeModal() {
	document.getElementById('rolModal').classList.add('hidden');
}

function editRol(id) {
	fetch(`/roles/${id}`)
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				const rol = data.data;
				const modal = document.getElementById('rolModal');
				const form = document.getElementById('rolForm');
				const title = document.getElementById('modalTitle');
				const methodField = document.getElementById('methodField');
				
				title.textContent = 'Editar Rol';
				form.action = `/roles/${id}`;
				methodField.innerHTML = '@method("PUT")';
				
				document.getElementById('nombre').value = rol.nombre;
				document.getElementById('descripcion').value = rol.descripcion || '';
				document.getElementById('estado').checked = rol.estado;
				
				modal.classList.remove('hidden');
			}
		})
		.catch(error => console.error('Error:', error));
}

function deleteRol(id) {
	if (confirm('¿Estás seguro de que deseas eliminar este rol?')) {
		const form = document.createElement('form');
		form.method = 'POST';
		form.action = `/roles/${id}`;
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
		}
	})
	.catch(error => {
		console.error('Error:', error);
		location.reload();
	});
}

// Cerrar modal al hacer clic fuera
document.getElementById('rolModal').addEventListener('click', function(e) {
	if (e.target === this) {
		closeModal();
	}
});
</script>
@endsection
