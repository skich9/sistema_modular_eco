@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">
	<div class="flex justify-between items-center mb-6">
		<h1 class="text-2xl font-bold text-gray-800">Asignación Económica</h1>
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

	<!-- Formulario de selección de pensum y gestión -->
	<div class="bg-white shadow-md rounded-lg p-6 mb-6">
		<h2 class="text-lg font-semibold text-gray-800 mb-4">Seleccionar Pensum y Gestión</h2>
		<form id="seleccionForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
			<div>
				<label for="pensum" class="block text-sm font-medium text-gray-700 mb-1">Pensum</label>
				<select id="pensum" name="pensum" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
					<option value="">Seleccione un pensum</option>
					@foreach($pensums as $pensum)
						<option value="{{ $pensum->cod_pensum }}">{{ $pensum->nombre }}</option>
					@endforeach
				</select>
			</div>
			<div>
				<label for="gestion" class="block text-sm font-medium text-gray-700 mb-1">Gestión</label>
				<select id="gestion" name="gestion" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
					<option value="">Seleccione una gestión</option>
					@for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
						<option value="{{ $i }}" {{ $i == $gestionActual ? 'selected' : '' }}>{{ $i }}</option>
					@endfor
				</select>
			</div>
			<div class="md:col-span-2 flex justify-end">
				<button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
					<i class="fas fa-search mr-2"></i> Buscar
				</button>
			</div>
		</form>
	</div>

	<!-- Sección para crear nuevo costo semestral -->
	<div class="bg-white shadow-md rounded-lg p-6 mb-6">
		<h2 class="text-lg font-semibold text-gray-800 mb-4">Crear Nuevo Costo Semestral</h2>
		<form id="costoSemestralForm" class="grid grid-cols-1 md:grid-cols-3 gap-6">
			<input type="hidden" id="usuario_id" name="id_usuario" value="{{ session('usuario_autenticado')['id'] }}">
			<div>
				<label for="pensum_costo" class="block text-sm font-medium text-gray-700 mb-1">Pensum</label>
				<select id="pensum_costo" name="cod_pensum" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
					<option value="">Seleccione un pensum</option>
					@foreach($pensums as $pensum)
						<option value="{{ $pensum->cod_pensum }}">{{ $pensum->nombre }}</option>
					@endforeach
				</select>
			</div>
			<div>
				<label for="gestion_costo" class="block text-sm font-medium text-gray-700 mb-1">Gestión</label>
				<select id="gestion_costo" name="gestion" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
					<option value="">Seleccione una gestión</option>
					@for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
						<option value="{{ $i }}" {{ $i == $gestionActual ? 'selected' : '' }}>{{ $i }}</option>
					@endfor
				</select>
			</div>
			<div>
				<label for="semestre" class="block text-sm font-medium text-gray-700 mb-1">Semestre</label>
				<select id="semestre" name="semestre" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
					<option value="">Seleccione un semestre</option>
					<option value="1">Primer Semestre</option>
					<option value="2">Segundo Semestre</option>
				</select>
			</div>
			<div class="md:col-span-3">
				<label for="monto_semestre" class="block text-sm font-medium text-gray-700 mb-1">Monto Semestral</label>
				<input type="number" id="monto_semestre" name="monto_semestre" step="0.01" min="0" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
			</div>
			<div class="md:col-span-3 flex justify-end">
				<button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
					<i class="fas fa-plus mr-2"></i> Crear Costo Semestral
				</button>
			</div>
		</form>
	</div>

	<!-- Tabla de costos semestrales existentes -->
	<div class="bg-white shadow-md rounded-lg p-6">
		<h2 class="text-lg font-semibold text-gray-800 mb-4">Costos Semestrales Existentes</h2>
		<div id="costosSemestralesContainer">
			<p class="text-gray-500 text-center py-4">Seleccione un pensum y una gestión para ver los costos semestrales</p>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script>
	document.getElementById('seleccionForm').addEventListener('submit', function(e) {
		e.preventDefault();
		
		const codPensum = document.getElementById('pensum').value;
		const gestion = document.getElementById('gestion').value;
		
		if (!codPensum || !gestion) {
			alert('Por favor seleccione un pensum y una gestión');
			return;
		}
		
		window.location.href = `/configuracion/asignacion-economica/${codPensum}/${gestion}`;
	});

	document.getElementById('costoSemestralForm').addEventListener('submit', function(e) {
		e.preventDefault();
		
		const formData = {
			cod_pensum: document.getElementById('pensum_costo').value,
			gestion: document.getElementById('gestion_costo').value,
			semestre: document.getElementById('semestre').value,
			monto_semestre: document.getElementById('monto_semestre').value,
			id_usuario: document.getElementById('usuario_id').value
		};
		
		if (!formData.cod_pensum || !formData.gestion || !formData.semestre || !formData.monto_semestre) {
			alert('Por favor complete todos los campos');
			return;
		}
		
		fetch('/configuracion/asignacion-economica/costo-semestral', {
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
				alert('Costo semestral creado exitosamente');
				document.getElementById('costoSemestralForm').reset();
				
				// Si hay un pensum y gestión seleccionados, recargar la página para mostrar el nuevo costo
				const codPensum = document.getElementById('pensum').value;
				const gestion = document.getElementById('gestion').value;
				if (codPensum && gestion) {
					window.location.href = `/configuracion/asignacion-economica/${codPensum}/${gestion}`;
				}
			} else {
				const errorMessages = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
				alert(`Error: ${errorMessages}`);
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error al crear el costo semestral');
		});
	});
</script>
@endsection
