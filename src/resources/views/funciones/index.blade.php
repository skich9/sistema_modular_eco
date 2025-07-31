@extends('layouts.app')

@section('title', 'Gestión de Funciones')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Header -->
		<div class="bg-white shadow rounded-lg mb-6">
			<div class="px-6 py-4 border-b border-gray-200">
				<div class="flex justify-between items-center">
					<div>
						<h1 class="text-2xl font-bold text-gray-900">Gestión de Funciones</h1>
						<p class="text-sm text-gray-600 mt-1">Administra las funciones del sistema</p>
					</div>
					<button onclick="openModal('create')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
						<i class="fas fa-plus mr-2"></i>
						Nueva Función
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

		<!-- Tabla de Funciones -->
		<div class="bg-white shadow rounded-lg overflow-hidden">
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuarios</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-200">
						@forelse($funciones as $funcion)
							<tr class="hover:bg-gray-50">
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $funcion->id_funcion }}</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm font-medium text-gray-900">{{ $funcion->nombre }}</div>
								</td>
								<td class="px-6 py-4 text-sm text-gray-500">
									{{ $funcion->descripcion ?? 'Sin descripción' }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
									<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
										{{ $funcion->usuarios_count }} usuarios
									</span>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<label class="inline-flex items-center">
										<input type="checkbox" 
											   class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300"
											   {{ $funcion->estado ? 'checked' : '' }}
											   onchange="toggleStatus({{ $funcion->id_funcion }}, this.checked, 'funcion')">
										<span class="ml-2 text-sm {{ $funcion->estado ? 'text-green-600' : 'text-red-600' }}">
											{{ $funcion->estado ? 'Activo' : 'Inactivo' }}
										</span>
									</label>
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
									<button onclick="editFuncion({{ $funcion->id_funcion }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
										<i class="fas fa-edit"></i> Editar
									</button>
									<button onclick="deleteFuncion({{ $funcion->id_funcion }})" class="text-red-600 hover:text-red-900">
										<i class="fas fa-trash"></i> Eliminar
									</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="px-6 py-4 text-center text-gray-500">
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
<div id="funcionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
	<div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
		<div class="mt-3">
			<div class="flex items-center justify-between mb-4">
				<h3 class="text-lg font-medium text-gray-900" id="modalTitle">Nueva Función</h3>
				<button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
					<i class="fas fa-times"></i>
				</button>
			</div>
			
			<form id="funcionForm" method="POST">
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
	
	modal.classList.remove('hidden');
}

function closeModal() {
	document.getElementById('funcionModal').classList.add('hidden');
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
				
				modal.classList.remove('hidden');
			}
		})
		.catch(error => console.error('Error:', error));
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
		}
	})
	.catch(error => {
		console.error('Error:', error);
		location.reload();
	});
}

// Cerrar modal al hacer clic fuera
document.getElementById('funcionModal').addEventListener('click', function(e) {
	if (e.target === this) {
		closeModal();
	}
});
</script>
@endsection
