@extends('layouts.app')

@section('content')

<div class="content-container">
	<!-- Header -->
	<div class="card mb-6">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<div>
					<h1 class="text-2xl font-bold">Asignación Económica</h1>
					<p class="text-sm text-secondary-color mt-1">Pensum: {{ $pensum->nombre }} | Gestión: {{ $gestion }}</p>
				</div>
				<a href="{{ route('asignacion_economica.index') }}" class="btn-secondary flex items-center">
					<i class="fas fa-arrow-left mr-2"></i> Volver
				</a>
			</div>
		</div>
	</div>

	<!-- Alertas -->
	@if(session('success'))
	<div id="success-alert" class="alert alert-success mb-4 alert-dismissible">
		<div class="alert-content">
			<i class="fas fa-check-circle mr-2"></i>
			<span>{{ session('success') }}</span>
		</div>
		<button type="button" class="close" onclick="document.getElementById('success-alert').remove()">
			<i class="fas fa-times"></i>
		</button>
	</div>
	@endif

	@if(session('error'))
	<div id="error-alert" class="alert alert-danger mb-4 alert-dismissible">
		<div class="alert-content">
			<i class="fas fa-exclamation-triangle mr-2"></i>
			<span>{{ session('error') }}</span>
		</div>
		<button type="button" class="close" onclick="document.getElementById('error-alert').remove()">
			<i class="fas fa-times"></i>
		</button>
	</div>
	@endif

	<!-- Costos Semestrales -->
	<div class="card mb-6">
		<div class="card-header">
			<h2 class="text-lg font-semibold">Costos Semestrales</h2>
		</div>
		<div class="card-body">
			@if($costosSemestrales->isEmpty())
				<div class="empty-data">
					<i class="fas fa-info-circle mr-1"></i> No hay costos semestrales definidos para este pensum y gestión
				</div>
			@else
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Semestre</th>
								<th>Monto</th>
								<th>Fecha Creación</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($costosSemestrales as $costo)
							<tr data-id="{{ $costo->id_costo_semestral }}">
								<td>{{ $costo->id_costo_semestral }}</td>
								<td>{{ $costo->semestre == 1 ? 'Primer Semestre' : 'Segundo Semestre' }}</td>
								<td>{{ number_format($costo->monto_semestre, 2) }}</td>
								<td>{{ $costo->created_at->format('d/m/Y H:i') }}</td>
								<td>
									<button onclick="openAsignacionModal({{ $costo->id_costo_semestral }})" class="btn btn-sm btn-primary">
										<i class="fas fa-plus-circle mr-1"></i> Asignar Costo
									</button>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</div>
	</div>

	<!-- Asignaciones de Costos -->
	<div class="card">
		<div class="card-header">
			<h2 class="text-lg font-semibold">Asignaciones de Costos</h2>
		</div>
		<div class="card-body">
			@if($asignaciones->isEmpty())
				<div class="empty-data">
					<i class="fas fa-info-circle mr-1"></i> No hay asignaciones de costos para este pensum y gestión
				</div>
			@else
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Inscripción</th>
								<th>Semestre</th>
								<th>Monto</th>
								<th>Observaciones</th>
								<th>Estado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($asignaciones as $asignacion)
							<tr data-id="{{ $asignacion->id_asignacion_costo }}">
								<td>{{ $asignacion->id_asignacion_costo }}</td>
								<td>{{ $asignacion->inscripcion->nombre ?? 'N/A' }}</td>
								<td>{{ $asignacion->costoSemestral->semestre == 1 ? 'Primer Semestre' : 'Segundo Semestre' }}</td>
								<td>{{ number_format($asignacion->monto, 2) }}</td>
								<td>{{ $asignacion->observaciones ?? 'N/A' }}</td>
								<td>
									<span class="badge {{ $asignacion->estado ? 'badge-success' : 'badge-danger' }}">
										{{ $asignacion->estado ? 'Activo' : 'Inactivo' }}
									</span>
								</td>
								<td>
									<div class="btn-group">
										<button onclick="toggleAsignacionStatus('{{ $asignacion->cod_pensum }}', '{{ $asignacion->cod_inscrip }}', '{{ $asignacion->id_asignacion_costo }}')" class="btn btn-sm btn-icon {{ $asignacion->estado ? 'btn-light' : 'btn-secondary' }}" title="{{ $asignacion->estado ? 'Desactivar' : 'Activar' }}">
											<i class="fas {{ $asignacion->estado ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
										</button>
										<button onclick="openEditAsignacionModal('{{ $asignacion->cod_pensum }}', '{{ $asignacion->cod_inscrip }}', '{{ $asignacion->id_asignacion_costo }}')" class="btn btn-sm btn-icon btn-warning" title="Editar">
											<i class="fas fa-edit"></i>
										</button>
										<button onclick="confirmDeleteAsignacion('{{ $asignacion->cod_pensum }}', '{{ $asignacion->cod_inscrip }}', '{{ $asignacion->id_asignacion_costo }}')" class="btn btn-sm btn-icon btn-danger" title="Eliminar">
											<i class="fas fa-trash-alt"></i>
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
	</div>

	<!-- Modal para asignar costo semestral -->
	<div id="asignacionModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Asignar Costo Semestral</h3>
					<button type="button" class="close" onclick="closeAsignacionModal()">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<form id="asignacionForm">
						<input type="hidden" id="costoSemestralId" name="costoSemestralId">
						<input type="hidden" id="pensumCodigo" name="pensumCodigo" value="{{ $pensum->codigo }}">
						<input type="hidden" id="gestion" name="gestion" value="{{ $gestion }}">
						
						<div class="form-group mb-3">
							<label for="inscripcionId" class="form-label">Inscripción</label>
							<select id="inscripcionId" name="inscripcionId" class="form-select" required>
								<option value="">Seleccione una inscripción</option>
								@foreach($inscripciones as $inscripcion)
								<option value="{{ $inscripcion->cod_inscrip }}">{{ $inscripcion->nombre }}</option>
								@endforeach
							</select>
						</div>
						
						<div class="form-group mb-3">
							<label for="monto" class="form-label">Monto</label>
							<input type="number" step="0.01" id="monto" name="monto" class="form-control" required>
						</div>
						
						<div class="form-group mb-3">
							<label for="observaciones" class="form-label">Observaciones</label>
							<textarea id="observaciones" name="observaciones" rows="3" class="form-control"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" onclick="closeAsignacionModal()">
						<i class="fas fa-times mr-1"></i> Cancelar
					</button>
					<button type="button" class="btn btn-primary" onclick="saveAsignacion()">
						<i class="fas fa-save mr-1"></i> Guardar
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal para editar asignación de costo -->
	<div id="editAsignacionModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Editar Asignación de Costo</h3>
					<button type="button" class="close" onclick="closeEditAsignacionModal()">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<form id="editAsignacionForm">
						<input type="hidden" id="editPensumCodigo" name="pensumCodigo">
						<input type="hidden" id="editInscripcionId" name="inscripcionId">
						<input type="hidden" id="editAsignacionId" name="asignacionId">
						
						<div class="form-group mb-3">
							<label for="editMonto" class="form-label">Monto</label>
							<input type="number" step="0.01" id="editMonto" name="monto" class="form-control" required>
						</div>
						
						<div class="form-group mb-3">
							<label for="editObservaciones" class="form-label">Observaciones</label>
							<textarea id="editObservaciones" name="observaciones" rows="3" class="form-control"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" onclick="closeEditAsignacionModal()">
						<i class="fas fa-times mr-1"></i> Cancelar
					</button>
					<button type="button" class="btn btn-warning" onclick="updateAsignacion()">
						<i class="fas fa-edit mr-1"></i> Actualizar
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal de confirmación para eliminar -->
	<div id="deleteAsignacionModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Confirmar Eliminación</h3>
					<button type="button" class="close" onclick="closeDeleteAsignacionModal()">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						<i class="fas fa-exclamation-triangle mr-2"></i>
						¿Está seguro que desea eliminar esta asignación de costo? Esta acción no se puede deshacer.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" onclick="closeDeleteAsignacionModal()">
						<i class="fas fa-times mr-1"></i> Cancelar
					</button>
					<button type="button" id="confirmDeleteAsignacionBtn" class="btn btn-danger">
						<i class="fas fa-trash-alt mr-1"></i> Eliminar
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
		document.getElementById('costoSemestralId').value = costoSemestralId;
		
		// Cargar inscripciones disponibles
		fetch(`/api/inscripciones/pensum/{{ $pensum->codigo }}`)
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					const inscripcionSelect = document.getElementById('inscripcionId');
					inscripcionSelect.innerHTML = '<option value="">Seleccione una inscripción</option>';
					
					data.data.forEach(inscripcion => {
						const option = document.createElement('option');
						option.value = inscripcion.cod_inscrip;
						option.textContent = inscripcion.nombre || `Inscripción #${inscripcion.cod_inscrip}`;
						inscripcionSelect.appendChild(option);
					});
					
					const modal = document.getElementById('asignacionModal');
					modal.classList.add('show');
					modal.style.display = 'block';
				} else {
					showAlert('Error al cargar las inscripciones', 'danger');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				showAlert('Error al cargar las inscripciones', 'danger');
			});
	}

	function closeAsignacionModal() {
		const modal = document.getElementById('asignacionModal');
		modal.classList.remove('show');
		modal.style.display = 'none';
		document.getElementById('asignacionForm').reset();
	}

	function openEditAsignacionModal(codPensum, codInscrip, idAsignacion) {
		document.getElementById('editPensumCodigo').value = codPensum;
		document.getElementById('editInscripcionId').value = codInscrip;
		document.getElementById('editAsignacionId').value = idAsignacion;
		
		// Cargar datos de la asignación
		fetch(`/configuracion/asignacion-economica/${codPensum}/${codInscrip}/${idAsignacion}/show`)
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					const asignacion = data.data;
					document.getElementById('editMonto').value = asignacion.monto;
					document.getElementById('editObservaciones').value = asignacion.observaciones || '';
					
					const modal = document.getElementById('editAsignacionModal');
					modal.classList.add('show');
					modal.style.display = 'block';
				} else {
					showAlert('Error al cargar los datos de la asignación de costo', 'danger');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				showAlert('Error al cargar los datos de la asignación de costo', 'danger');
			});
	}

	function closeEditAsignacionModal() {
		const modal = document.getElementById('editAsignacionModal');
		modal.classList.remove('show');
		modal.style.display = 'none';
		document.getElementById('editAsignacionForm').reset();
	}

	function confirmDeleteAsignacion(codPensum, codInscrip, idAsignacion) {
		deleteAsignacionData = { codPensum, codInscrip, idAsignacion };
		const modal = document.getElementById('deleteAsignacionModal');
		modal.classList.add('show');
		modal.style.display = 'block';
		
		// Configurar el botón de eliminar para esta instancia específica
		document.getElementById('confirmDeleteAsignacionBtn').onclick = function() {
			deleteAsignacion(codPensum, codInscrip, idAsignacion);
		};
	}

	function closeDeleteAsignacionModal() {
		const modal = document.getElementById('deleteAsignacionModal');
		modal.classList.remove('show');
		modal.style.display = 'none';
		deleteAsignacionData = null;
	}
	
	function deleteAsignacion(codPensum, codInscrip, idAsignacion) {
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
				showAlert(`Error: ${data.message}`, 'danger');
				closeDeleteAsignacionModal();
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al eliminar la asignación de costo', 'danger');
			closeDeleteAsignacionModal();
		});
	}

	// Función auxiliar para mostrar alertas
	function showAlert(message, type) {
		const alertDiv = document.createElement('div');
		alertsDiv = document.createElement('div');
		alertsDiv.style.position = 'fixed';
		alertsDiv.style.top = '20px';
		alertsDiv.style.right = '20px';
		alertsDiv.style.zIndex = '9999';
		document.body.appendChild(alertsDiv);

		alertDiv.className = `alert alert-${type} alert-dismissible`;
		alertDiv.innerHTML = `
			<div class="alert-content">
				<i class="fas fa-${type === 'danger' ? 'exclamation-triangle' : 'check-circle'} mr-2"></i>
				<span>${message}</span>
			</div>
			<button type="button" class="close" onclick="this.parentElement.remove()">
				<i class="fas fa-times"></i>
			</button>
		`;
		alertsDiv.appendChild(alertDiv);

		setTimeout(() => {
			alertDiv.remove();
			if (alertsDiv.children.length === 0) {
				alertsDiv.remove();
			}
		}, 5000);
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
				showAlert('Error al cambiar el estado de la asignación de costo', 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al cambiar el estado de la asignación de costo', 'danger');
		});
	}

	// Función para guardar una nueva asignación
	function saveAsignacion() {
		const formData = {
			cod_pensum: document.getElementById('pensumCodigo').value,
			cod_inscrip: document.getElementById('inscripcionId').value,
			monto: document.getElementById('monto').value,
			observaciones: document.getElementById('observaciones').value,
			estado: true,
			id_costo_semestral: document.getElementById('costoSemestralId').value
		};
		
		if (!formData.cod_inscrip || !formData.monto) {
			showAlert('Por favor complete todos los campos obligatorios', 'warning');
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
				showAlert(`Error: ${errorMessages}`, 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al crear la asignación de costo', 'danger');
		});
	}

	// Función para actualizar una asignación existente
	function updateAsignacion() {
		const codPensum = document.getElementById('editPensumCodigo').value;
		const codInscrip = document.getElementById('editInscripcionId').value;
		const idAsignacion = document.getElementById('editAsignacionId').value;
		
		const formData = {
			monto: document.getElementById('editMonto').value,
			observaciones: document.getElementById('editObservaciones').value,
			estado: true
		};
		
		if (!formData.monto) {
			showAlert('Por favor complete todos los campos obligatorios', 'warning');
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
				showAlert(`Error: ${errorMessages}`, 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al actualizar la asignación de costo', 'danger');
		});
	}

	// El botón de eliminar se configura dinámicamente en la función confirmDeleteAsignacion

	// Inicializar modales
	document.addEventListener('DOMContentLoaded', function() {
		// Cerrar modales cuando se hace clic fuera de ellos
		window.onclick = function(event) {
			const modals = document.getElementsByClassName('modal');
			for (let i = 0; i < modals.length; i++) {
				if (event.target == modals[i]) {
					modals[i].style.display = 'none';
					modals[i].classList.remove('show');
				}
			}
		};
	});
</script>
@endsection
