@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
	<div class="flex justify-between items-center mb-6">
		<h1 class="text-2xl font-bold text-gray-800">Parámetros Económicos</h1>
		<button type="button" onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
			<i class="fas fa-plus mr-2"></i> Nuevo Parámetro
		</button>
	</div>

	<!-- Alerta de éxito -->
	@if(session('success'))
	<div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 relative" role="alert">
		<p>{{ session('success') }}</p>
		<button onclick="document.getElementById('success-alert').remove()" class="absolute top-0 right-0 mt-2 mr-2">
			<i class="fas fa-times"></i>
		</button>
	</div>
	@endif

	<!-- Alerta de error -->
	@if(session('error'))
	<div id="error-alert" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 relative" role="alert">
		<p>{{ session('error') }}</p>
		<button onclick="document.getElementById('error-alert').remove()" class="absolute top-0 right-0 mt-2 mr-2">
			<i class="fas fa-times"></i>
		</button>
	</div>
	@endif

	<!-- Tabla de parámetros económicos -->
	<div class="bg-white shadow-md rounded-lg overflow-hidden">
		<table class="min-w-full divide-y divide-gray-200">
			<thead class="bg-gray-50">
				<tr>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
				</tr>
			</thead>
			<tbody class="bg-white divide-y divide-gray-200">
				@forelse($parametros as $parametro)
				<tr>
					<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $parametro->id_parametro_economico }}</td>
					<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $parametro->nombre }}</td>
					<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($parametro->valor, 2) }}</td>
					<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $parametro->descripcion }}</td>
					<td class="px-6 py-4 whitespace-nowrap">
						<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $parametro->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
							{{ $parametro->estado ? 'Activo' : 'Inactivo' }}
						</span>
					</td>
					<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
						<div class="flex space-x-2">
							<button onclick="toggleStatus({{ $parametro->id_parametro_economico }})" class="text-indigo-600 hover:text-indigo-900" title="{{ $parametro->estado ? 'Desactivar' : 'Activar' }}">
								<i class="fas {{ $parametro->estado ? 'fa-toggle-on' : 'fa-toggle-off' }} text-lg"></i>
							</button>
							<button onclick="openEditModal({{ $parametro->id_parametro_economico }})" class="text-yellow-600 hover:text-yellow-900" title="Editar">
								<i class="fas fa-edit text-lg"></i>
							</button>
							<button onclick="confirmDelete({{ $parametro->id_parametro_economico }})" class="text-red-600 hover:text-red-900" title="Eliminar">
								<i class="fas fa-trash-alt text-lg"></i>
							</button>
						</div>
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay parámetros económicos registrados</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>

	<!-- Modal para crear/editar parámetro económico -->
	<div id="paramModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
		<div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
			<div class="mt-3 text-center">
				<h3 id="modal-title" class="text-lg leading-6 font-medium text-gray-900"></h3>
				<form id="paramForm" class="mt-4">
					<input type="hidden" id="param_id" name="param_id">
					<div class="mb-4">
						<label for="nombre" class="block text-sm font-medium text-gray-700 text-left">Nombre</label>
						<input type="text" id="nombre" name="nombre" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
					</div>
					<div class="mb-4">
						<label for="valor" class="block text-sm font-medium text-gray-700 text-left">Valor</label>
						<input type="number" id="valor" name="valor" step="0.01" min="0" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
					</div>
					<div class="mb-4">
						<label for="descripcion" class="block text-sm font-medium text-gray-700 text-left">Descripción</label>
						<input type="text" id="descripcion" name="descripcion" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
					</div>
					<div class="mb-4">
						<label for="estado" class="block text-sm font-medium text-gray-700 text-left">Estado</label>
						<select id="estado" name="estado" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
					<div class="flex justify-between mt-6">
						<button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
							Cancelar
						</button>
						<button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
							Guardar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal de confirmación para eliminar -->
	<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
		<div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
			<div class="mt-3 text-center">
				<h3 class="text-lg leading-6 font-medium text-gray-900">Confirmar Eliminación</h3>
				<div class="mt-2 px-7 py-3">
					<p class="text-sm text-gray-500">¿Está seguro que desea eliminar este parámetro económico? Esta acción no se puede deshacer.</p>
				</div>
				<div class="flex justify-between mt-6">
					<button type="button" onclick="closeDeleteModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
						Cancelar
					</button>
					<button type="button" id="confirmDeleteBtn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
						Eliminar
					</button>
				</div>
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
		fetch(`/configuracion/parametros-economicos/${id}/toggle-status`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			}
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				window.location.reload();
			} else {
				alert('Error al cambiar el estado del parámetro económico');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error al cambiar el estado del parámetro económico');
		});
	}

	document.getElementById('paramForm').addEventListener('submit', function(e) {
		e.preventDefault();
		
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
				'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			},
			body: JSON.stringify(formData)
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				window.location.reload();
			} else {
				const errorMessages = Object.values(data.errors).flat().join('\n');
				alert(`Error: ${errorMessages}`);
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error al guardar el parámetro económico');
		});
	});

	document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
		if (deleteId) {
			fetch(`/configuracion/parametros-economicos/${deleteId}`, {
				method: 'DELETE',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
				}
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					window.location.reload();
				} else {
					alert(`Error: ${data.message}`);
					closeDeleteModal();
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error al eliminar el parámetro económico');
				closeDeleteModal();
			});
		}
	});
</script>
@endsection
