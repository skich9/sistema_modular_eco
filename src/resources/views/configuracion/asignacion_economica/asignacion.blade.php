@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">
	<div class="flex justify-between items-center mb-6">
		<div>
			<h1 class="text-2xl font-bold text-gray-800">Asignación Económica</h1>
			<p class="text-gray-600">Pensum: {{ $pensum->nombre }} | Gestión: {{ $gestion }}</p>
		</div>
		<a href="{{ route('asignacion_economica.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded flex items-center">
			<i class="fas fa-arrow-left mr-2"></i> Volver
		</a>
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

	<!-- Costos Semestrales -->
	<div class="bg-white shadow-md rounded-lg p-6 mb-6">
		<h2 class="text-lg font-semibold text-gray-800 mb-4">Costos Semestrales</h2>
		
		@if($costosSemestrales->isEmpty())
			<p class="text-gray-500 text-center py-4">No hay costos semestrales definidos para este pensum y gestión</p>
		@else
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semestre</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Creación</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-200">
						@foreach($costosSemestrales as $costo)
						<tr>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $costo->id_costo_semestral }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $costo->semestre == 1 ? 'Primer Semestre' : 'Segundo Semestre' }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($costo->monto_semestre, 2) }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $costo->created_at->format('d/m/Y H:i') }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
								<button onclick="openAsignacionModal({{ $costo->id_costo_semestral }})" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">
									Asignar Costo
								</button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endif
	</div>

	<!-- Asignaciones de Costos -->
	<div class="bg-white shadow-md rounded-lg p-6">
		<h2 class="text-lg font-semibold text-gray-800 mb-4">Asignaciones de Costos</h2>
		
		@if($asignaciones->isEmpty())
			<p class="text-gray-500 text-center py-4">No hay asignaciones de costos para este pensum y gestión</p>
		@else
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscripción</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semestre</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observaciones</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-200">
						@foreach($asignaciones as $asignacion)
						<tr>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asignacion->id_asignacion_costo }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asignacion->inscripcion->nombre ?? 'N/A' }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asignacion->costoSemestral->semestre == 1 ? 'Primer Semestre' : 'Segundo Semestre' }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($asignacion->monto, 2) }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asignacion->observaciones ?? 'N/A' }}</td>
							<td class="px-6 py-4 whitespace-nowrap">
								<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $asignacion->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
									{{ $asignacion->estado ? 'Activo' : 'Inactivo' }}
								</span>
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
								<div class="flex space-x-2">
									<button onclick="toggleAsignacionStatus('{{ $asignacion->cod_pensum }}', '{{ $asignacion->cod_inscrip }}', '{{ $asignacion->id_asignacion_costo }}')" class="text-indigo-600 hover:text-indigo-900" title="{{ $asignacion->estado ? 'Desactivar' : 'Activar' }}">
										<i class="fas {{ $asignacion->estado ? 'fa-toggle-on' : 'fa-toggle-off' }} text-lg"></i>
									</button>
									<button onclick="openEditAsignacionModal('{{ $asignacion->cod_pensum }}', '{{ $asignacion->cod_inscrip }}', '{{ $asignacion->id_asignacion_costo }}')" class="text-yellow-600 hover:text-yellow-900" title="Editar">
										<i class="fas fa-edit text-lg"></i>
									</button>
									<button onclick="confirmDeleteAsignacion('{{ $asignacion->cod_pensum }}', '{{ $asignacion->cod_inscrip }}', '{{ $asignacion->id_asignacion_costo }}')" class="text-red-600 hover:text-red-900" title="Eliminar">
										<i class="fas fa-trash-alt text-lg"></i>
									</button>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endif
	</div>

	<!-- Modal para crear asignación de costo -->
	<div id="asignacionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
		<div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
			<div class="mt-3 text-center">
				<h3 id="modal-title" class="text-lg leading-6 font-medium text-gray-900">Crear Asignación de Costo</h3>
				<form id="asignacionForm" class="mt-4">
					<input type="hidden" id="costo_semestral_id" name="id_costo_semestral">
					<input type="hidden" id="pensum_id" name="cod_pensum" value="{{ $pensum->cod_pensum }}">
					
					<div class="mb-4">
						<label for="inscripcion" class="block text-sm font-medium text-gray-700 text-left">Inscripción</label>
						<select id="inscripcion" name="cod_inscrip" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
							<option value="">Seleccione una inscripción</option>
							<!-- Aquí se cargarán las inscripciones dinámicamente -->
						</select>
					</div>
					<div class="mb-4">
						<label for="monto" class="block text-sm font-medium text-gray-700 text-left">Monto</label>
						<input type="number" id="monto" name="monto" step="0.01" min="0" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
					</div>
					<div class="mb-4">
						<label for="observaciones" class="block text-sm font-medium text-gray-700 text-left">Observaciones</label>
						<textarea id="observaciones" name="observaciones" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
					</div>
					<div class="mb-4">
						<label for="estado_asignacion" class="block text-sm font-medium text-gray-700 text-left">Estado</label>
						<select id="estado_asignacion" name="estado" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
					<div class="flex justify-between mt-6">
						<button type="button" onclick="closeAsignacionModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

	<!-- Modal para editar asignación de costo -->
	<div id="editAsignacionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
		<div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
			<div class="mt-3 text-center">
				<h3 class="text-lg leading-6 font-medium text-gray-900">Editar Asignación de Costo</h3>
				<form id="editAsignacionForm" class="mt-4">
					<input type="hidden" id="edit_pensum_id" name="cod_pensum">
					<input type="hidden" id="edit_inscripcion_id" name="cod_inscrip">
					<input type="hidden" id="edit_asignacion_id" name="id_asignacion_costo">
					
					<div class="mb-4">
						<label for="edit_monto" class="block text-sm font-medium text-gray-700 text-left">Monto</label>
						<input type="number" id="edit_monto" name="monto" step="0.01" min="0" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
					</div>
					<div class="mb-4">
						<label for="edit_observaciones" class="block text-sm font-medium text-gray-700 text-left">Observaciones</label>
						<textarea id="edit_observaciones" name="observaciones" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
					</div>
					<div class="mb-4">
						<label for="edit_estado" class="block text-sm font-medium text-gray-700 text-left">Estado</label>
						<select id="edit_estado" name="estado" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
					<div class="flex justify-between mt-6">
						<button type="button" onclick="closeEditAsignacionModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
							Cancelar
						</button>
						<button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
							Actualizar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal de confirmación para eliminar -->
	<div id="deleteAsignacionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
		<div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
			<div class="mt-3 text-center">
				<h3 class="text-lg leading-6 font-medium text-gray-900">Confirmar Eliminación</h3>
				<div class="mt-2 px-7 py-3">
					<p class="text-sm text-gray-500">¿Está seguro que desea eliminar esta asignación de costo? Esta acción no se puede deshacer.</p>
				</div>
				<div class="flex justify-between mt-6">
					<button type="button" onclick="closeDeleteAsignacionModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
						Cancelar
					</button>
					<button type="button" id="confirmDeleteAsignacionBtn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
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
	let deleteAsignacionData = null;

	function openAsignacionModal(costoSemestralId) {
		document.getElementById('costo_semestral_id').value = costoSemestralId;
		
		// Cargar inscripciones disponibles
		fetch(`/api/inscripciones/pensum/{{ $pensum->cod_pensum }}`)
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					const inscripcionSelect = document.getElementById('inscripcion');
					inscripcionSelect.innerHTML = '<option value="">Seleccione una inscripción</option>';
					
					data.data.forEach(inscripcion => {
						const option = document.createElement('option');
						option.value = inscripcion.cod_inscrip;
						option.textContent = inscripcion.nombre || `Inscripción #${inscripcion.cod_inscrip}`;
						inscripcionSelect.appendChild(option);
					});
					
					document.getElementById('asignacionModal').classList.remove('hidden');
				} else {
					alert('Error al cargar las inscripciones');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error al cargar las inscripciones');
			});
	}

	function closeAsignacionModal() {
		document.getElementById('asignacionModal').classList.add('hidden');
		document.getElementById('asignacionForm').reset();
	}

	function openEditAsignacionModal(codPensum, codInscrip, idAsignacion) {
		document.getElementById('edit_pensum_id').value = codPensum;
		document.getElementById('edit_inscripcion_id').value = codInscrip;
		document.getElementById('edit_asignacion_id').value = idAsignacion;
		
		// Cargar datos de la asignación
		fetch(`/configuracion/asignacion-economica/${codPensum}/${codInscrip}/${idAsignacion}/show`)
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					const asignacion = data.data;
					document.getElementById('edit_monto').value = asignacion.monto;
					document.getElementById('edit_observaciones').value = asignacion.observaciones || '';
					document.getElementById('edit_estado').value = asignacion.estado ? '1' : '0';
					document.getElementById('editAsignacionModal').classList.remove('hidden');
				} else {
					alert('Error al cargar los datos de la asignación de costo');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error al cargar los datos de la asignación de costo');
			});
	}

	function closeEditAsignacionModal() {
		document.getElementById('editAsignacionModal').classList.add('hidden');
		document.getElementById('editAsignacionForm').reset();
	}

	function confirmDeleteAsignacion(codPensum, codInscrip, idAsignacion) {
		deleteAsignacionData = { codPensum, codInscrip, idAsignacion };
		document.getElementById('deleteAsignacionModal').classList.remove('hidden');
	}

	function closeDeleteAsignacionModal() {
		document.getElementById('deleteAsignacionModal').classList.add('hidden');
		deleteAsignacionData = null;
	}

	function toggleAsignacionStatus(codPensum, codInscrip, idAsignacion) {
		fetch(`/configuracion/asignacion-economica/${codPensum}/${codInscrip}/${idAsignacion}/toggle-status`, {
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
				alert('Error al cambiar el estado de la asignación de costo');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error al cambiar el estado de la asignación de costo');
		});
	}

	document.getElementById('asignacionForm').addEventListener('submit', function(e) {
		e.preventDefault();
		
		const formData = {
			cod_pensum: document.getElementById('pensum_id').value,
			cod_inscrip: document.getElementById('inscripcion').value,
			monto: document.getElementById('monto').value,
			observaciones: document.getElementById('observaciones').value,
			estado: document.getElementById('estado_asignacion').value === '1',
			id_costo_semestral: document.getElementById('costo_semestral_id').value
		};
		
		if (!formData.cod_inscrip || !formData.monto) {
			alert('Por favor complete todos los campos obligatorios');
			return;
		}
		
		fetch('/configuracion/asignacion-economica/asignacion', {
			method: 'POST',
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
				const errorMessages = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
				alert(`Error: ${errorMessages}`);
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error al crear la asignación de costo');
		});
	});

	document.getElementById('editAsignacionForm').addEventListener('submit', function(e) {
		e.preventDefault();
		
		const codPensum = document.getElementById('edit_pensum_id').value;
		const codInscrip = document.getElementById('edit_inscripcion_id').value;
		const idAsignacion = document.getElementById('edit_asignacion_id').value;
		
		const formData = {
			monto: document.getElementById('edit_monto').value,
			observaciones: document.getElementById('edit_observaciones').value,
			estado: document.getElementById('edit_estado').value === '1'
		};
		
		if (!formData.monto) {
			alert('Por favor complete todos los campos obligatorios');
			return;
		}
		
		fetch(`/configuracion/asignacion-economica/${codPensum}/${codInscrip}/${idAsignacion}`, {
			method: 'PUT',
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
				const errorMessages = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
				alert(`Error: ${errorMessages}`);
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error al actualizar la asignación de costo');
		});
	});

	document.getElementById('confirmDeleteAsignacionBtn').addEventListener('click', function() {
		if (deleteAsignacionData) {
			const { codPensum, codInscrip, idAsignacion } = deleteAsignacionData;
			
			fetch(`/configuracion/asignacion-economica/${codPensum}/${codInscrip}/${idAsignacion}`, {
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
					closeDeleteAsignacionModal();
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error al eliminar la asignación de costo');
				closeDeleteAsignacionModal();
			});
		}
	});
</script>
@endsection
