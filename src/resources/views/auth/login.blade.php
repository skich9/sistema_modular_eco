@extends('layouts.app')

@section('title', 'Iniciar Sesión - CETA Pay')

@section('content')
<div class="login-container">
	<!-- Card Container -->
	<div class="login-card">
		<!-- Header -->
		<div class="login-header">
			<div class="login-logo">
				<i class="fas fa-dollar-sign login-logo-icon"></i>
			</div>
			
			<h2 class="login-title">CETA Pay</h2>
			<p class="login-subtitle">Sistema de Cobros Inteligente</p>
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
				<div class="login-form-group">
					<label for="email" class="login-label">
						Email
					</label>
					<input 
						id="email" 
						name="email" 
						type="text" 
						required 
						class="login-input"
						placeholder="admin@ceta.edu.bo"
						value="{{ old('email') }}"
					>
				</div>

				<!-- Contraseña -->
				<div class="login-form-group">
					<label for="password" class="login-label">
						Contraseña
					</label>
					<div class="login-password-container">
						<input 
							id="password" 
							name="password" 
							type="password" 
							required 
							class="login-input"
							placeholder="********"
						>
						<button 
							type="button" 
							class="login-password-toggle" 
							onclick="togglePasswordVisibility()"
						>
							<i class="fas fa-eye"></i>
						</button>
					</div>
				</div>

				<!-- Botón de Iniciar Sesión -->
				<div>
					<button type="submit" class="login-button">
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
