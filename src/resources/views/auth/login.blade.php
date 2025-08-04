@extends('layouts.app')

@section('title', 'Iniciar Sesión - Sistema de Cobros CETA')

@section('content')
<div class="login-container">
	<div class="login-wrapper">
		<!-- Card Container -->
		<div class="login-card">
			<!-- Header -->
			<div class="login-header">
				<div class="login-logo">
					<img src="{{ asset('images/logo-ceta.png') }}" alt="Logo CETA">
				</div>
				
				<h2 class="login-title">Sistema de Cobros</h2>
				<p class="login-subtitle">Instituto Tecnológico CETA</p>
			</div>

			<!-- Login Form -->
			<form class="login-form" action="{{ route('login.post') }}" method="POST">
				@csrf
				
				<!-- Errores -->
				@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
							<p>{{ $error }}</p>
						@endforeach
					</div>
				@endif

				<!-- Email/Usuario -->
				<div class="form-group">
					<label for="email" class="form-label">
						Usuario o Cédula
					</label>
					<div class="input-icon">
						<i class="fas fa-user icon-left"></i>
						<input 
							id="email" 
							name="email" 
							type="text" 
							required 
							class="form-input"
							placeholder="Ingresa tu usuario o cédula"
							value="{{ old('email') }}"
						>
					</div>
				</div>

				<!-- Contraseña -->
				<div class="form-group">
					<label for="password" class="form-label">
						Contraseña
					</label>
					<div class="input-icon">
						<i class="fas fa-lock icon-left"></i>
						<input 
							id="password" 
							name="password" 
							type="password" 
							required 
							class="form-input"
							placeholder="Ingresa tu contraseña"
						>
						<button type="button" onclick="togglePassword()" class="icon-right">
							<i id="toggleIcon" class="fas fa-eye"></i>
						</button>
					</div>
				</div>

				<!-- Botón de Login -->
				<div class="form-actions">
					<button type="submit" class="btn-primary btn-block">
						<i class="fas fa-sign-in-alt mr-2"></i>
						Iniciar Sesión
					</button>
				</div>
			</form>

			<!-- Footer -->
			<div class="login-footer">
				<p>
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
