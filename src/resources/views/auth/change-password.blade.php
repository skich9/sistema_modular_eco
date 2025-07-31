@extends('layouts.app')

@section('title', 'Cambiar Contraseña - Sistema de Cobros CETA')

@section('content')
<div class="min-h-screen bg-gray-50">
	<!-- Navigation Header -->
	<nav class="bg-white shadow-lg">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex justify-between h-16">
				<div class="flex items-center">
					<a href="{{ route('dashboard') }}" class="flex items-center">
						<img src="{{ asset('images/logo-ceta.png') }}" alt="Logo CETA" class="h-8 w-8 mr-3">
						<span class="text-xl font-bold text-gray-900">Sistema de Cobros CETA</span>
					</a>
				</div>
				
				<div class="flex items-center">
					<a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
						<i class="fas fa-arrow-left mr-2"></i>Volver al Dashboard
					</a>
				</div>
			</div>
		</div>
	</nav>

	<!-- Main Content -->
	<div class="max-w-md mx-auto py-12 px-4 sm:px-6 lg:px-8">
		<div class="bg-white shadow rounded-lg">
			<div class="px-4 py-5 sm:p-6">
				<h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
					<i class="fas fa-key mr-2"></i>Cambiar Contraseña
				</h3>

				<!-- Alerts -->
				@if($errors->any())
					<div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded alert-auto-hide">
						<div class="flex items-center">
							<i class="fas fa-exclamation-triangle mr-2"></i>
							<span>{{ $errors->first() }}</span>
						</div>
					</div>
				@endif

				@if(session('success'))
					<div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded alert-auto-hide">
						<div class="flex items-center">
							<i class="fas fa-check-circle mr-2"></i>
							<span>{{ session('success') }}</span>
						</div>
					</div>
				@endif

				<form action="{{ route('change-password.post') }}" method="POST" class="space-y-6">
					@csrf

					<!-- Current Password -->
					<div>
						<label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
							Contraseña Actual
						</label>
						<div class="relative">
							<input 
								id="current_password" 
								name="current_password" 
								type="password" 
								required 
								class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
								placeholder="Ingrese su contraseña actual"
							>
							<button 
								type="button" 
								class="absolute inset-y-0 right-0 pr-3 flex items-center"
								onclick="togglePassword('current_password', 'current-password-icon')"
							>
								<i id="current-password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
							</button>
						</div>
					</div>

					<!-- New Password -->
					<div>
						<label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
							Nueva Contraseña
						</label>
						<div class="relative">
							<input 
								id="new_password" 
								name="new_password" 
								type="password" 
								required 
								class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
								placeholder="Mínimo 6 caracteres"
							>
							<button 
								type="button" 
								class="absolute inset-y-0 right-0 pr-3 flex items-center"
								onclick="togglePassword('new_password', 'new-password-icon')"
							>
								<i id="new-password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
							</button>
						</div>
					</div>

					<!-- Confirm New Password -->
					<div>
						<label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
							Confirmar Nueva Contraseña
						</label>
						<div class="relative">
							<input 
								id="new_password_confirmation" 
								name="new_password_confirmation" 
								type="password" 
								required 
								class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
								placeholder="Repita la nueva contraseña"
							>
							<button 
								type="button" 
								class="absolute inset-y-0 right-0 pr-3 flex items-center"
								onclick="togglePassword('new_password_confirmation', 'confirm-password-icon')"
							>
								<i id="confirm-password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
							</button>
						</div>
					</div>

					<!-- Submit Button -->
					<div class="flex justify-end space-x-3">
						<a 
							href="{{ route('dashboard') }}" 
							class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
						>
							Cancelar
						</a>
						<button 
							type="submit" 
							class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
						>
							<i class="fas fa-save mr-2"></i>
							Actualizar Contraseña
						</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Password Requirements -->
		<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
			<h4 class="text-sm font-medium text-blue-800 mb-2">Requisitos de la contraseña:</h4>
			<ul class="text-sm text-blue-700 space-y-1">
				<li><i class="fas fa-check mr-2"></i>Mínimo 6 caracteres</li>
				<li><i class="fas fa-check mr-2"></i>Se recomienda incluir números y símbolos</li>
				<li><i class="fas fa-check mr-2"></i>Evite usar información personal</li>
			</ul>
		</div>
	</div>
</div>
@endsection
