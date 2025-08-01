@extends('layouts.app')

@section('title', 'Iniciar Sesión - Sistema de Cobros CETA')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 py-12 px-4 sm:px-6 lg:px-8">
	<div class="max-w-md w-full">
		<!-- Card Container -->
		<div class="bg-white rounded-2xl shadow-2xl p-8 space-y-8">
			<!-- Header -->
			<div class="text-center">
				<div class="mx-auto h-24 w-24 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-lg">
					<img src="{{ asset('images/logo-ceta.png') }}" alt="Logo CETA" class="h-16 w-16 object-contain">
				</div>
				
				<h2 class="text-3xl font-bold text-gray-900 mb-2">
					Sistema de Cobros
				</h2>
				<p class="text-gray-600 text-lg">
					Instituto Tecnológico CETA
				</p>
			</div>

			<!-- Login Form -->
			<form class="space-y-6" action="{{ route('login.post') }}" method="POST">
				@csrf
				
				<!-- Errores -->
				@if ($errors->any())
					<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
						@foreach ($errors->all() as $error)
							<p class="text-sm">{{ $error }}</p>
						@endforeach
					</div>
				@endif

				<!-- Email/Usuario -->
				<div>
					<label for="email" class="block text-sm font-medium text-gray-700 mb-2">
						Usuario o Cédula
					</label>
					<div class="relative">
						<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
							<i class="fas fa-user text-gray-400"></i>
						</div>
						<input 
							id="email" 
							name="email" 
							type="text" 
							required 
							class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-500"
							placeholder="Ingresa tu usuario o cédula"
							value="{{ old('email') }}"
						>
					</div>
				</div>

				<!-- Contraseña -->
				<div>
					<label for="password" class="block text-sm font-medium text-gray-700 mb-2">
						Contraseña
					</label>
					<div class="relative">
						<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
							<i class="fas fa-lock text-gray-400"></i>
						</div>
						<input 
							id="password" 
							name="password" 
							type="password" 
							required 
							class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-500"
							placeholder="Ingresa tu contraseña"
						>
						<div class="absolute inset-y-0 right-0 pr-3 flex items-center">
							<button type="button" onclick="togglePassword()" class="text-gray-400 hover:text-gray-600">
								<i id="toggleIcon" class="fas fa-eye"></i>
							</button>
						</div>
					</div>
				</div>

				<!-- Botón de Login -->
				<div>
					<button 
						type="submit" 
						class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
					>
						<i class="fas fa-sign-in-alt mr-2"></i>
						Iniciar Sesión
					</button>
				</div>
			</form>

			<!-- Footer -->
			<div class="text-center">
				<p class="text-xs text-gray-500">
					© {{ date('Y') }} Instituto Tecnológico CETA. Todos los derechos reservados.
				</p>
			</div>
		</div>
	</div>
</div>

<script>
function togglePassword() {
	const passwordInput = document.getElementById('password');
	const toggleIcon = document.getElementById('toggleIcon');
	
	if (passwordInput.type === 'password') {
		passwordInput.type = 'text';
		toggleIcon.classList.remove('fa-eye');
		toggleIcon.classList.add('fa-eye-slash');
	} else {
		passwordInput.type = 'password';
		toggleIcon.classList.remove('fa-eye-slash');
		toggleIcon.classList.add('fa-eye');
	}
}
</script>
@endsection
