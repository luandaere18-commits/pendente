<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MC-COMERCIAL - Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .login-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 420px;
            width: 100%;
        }
        
        .login-header {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            padding: 2.5rem 2rem;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="white" opacity="0.1"><circle cx="20" cy="20" r="2"/><circle cx="80" cy="20" r="2"/><circle cx="20" cy="80" r="2"/><circle cx="80" cy="80" r="2"/><circle cx="50" cy="50" r="3"/></svg>');
        }
        
        .login-header .content {
            position: relative;
            z-index: 1;
        }
        
        .login-header h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: -0.5px;
        }
        
        .login-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.85;
            font-size: 0.95rem;
        }
        
        .login-body {
            padding: 2.5rem 2rem;
        }
        
        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background-color: #f9fafb;
        }
        
        .form-control:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            background-color: white;
        }
        
        .input-group-text {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            border-right: none;
            border-radius: 0.5rem 0 0 0.5rem;
            color: #6b7280;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 0.5rem 0.5rem 0;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            border: none;
            border-radius: 0.5rem;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.2s ease;
            letter-spacing: 0.25px;
        }
        
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(30, 64, 175, 0.2);
            background: linear-gradient(135deg, #1e40af, #2563eb);
        }
        
        .form-check-input:checked {
            background-color: #1e40af;
            border-color: #1e40af;
        }
        
        .form-check-label {
            color: #374151;
            font-size: 0.9rem;
        }
        
        .alert {
            border: none;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .logo-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }
        
        .copyright {
            color: #6b7280;
            font-size: 0.85rem;
        }
        
        .is-invalid {
            border-color: #dc2626;
        }
        
        .text-danger {
            color: #dc2626 !important;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="content">
                    <div class="text-center mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL" style="height: 60px; max-height: 60px; width: auto; display: block; margin: 0 auto;">
                        <h1 style="margin-top: 0.5rem; margin-bottom: 0;">MC-COMERCIAL</h1>
                    </div>
                    <p>Sistema de Gestão</p>
                </div>
            </div>
            
            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                
                <form id="loginForm" onsubmit="return false;">
                    <div id="loginError" class="alert alert-danger d-none"></div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Endereço de Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   required 
                                   autofocus 
                                   placeholder="Digite seu email">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Palavra-passe</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   placeholder="Digite sua palavra-passe">
                        </div>
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Manter sessão iniciada
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sessão
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <small class="copyright">
                        © 2025 MC-COMERCIAL. Todos os direitos reservados.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        // Remover qualquer token antigo ao carregar a página de login
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Função para verificar o token
        function verificarToken(token) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/api/user',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(xhr) {
                        reject(xhr);
                    }
                });
            });
        }

        $(document).ready(function() {
            // Flag para controlar se já verificamos o token
            let tokenVerificado = false;

            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                
                const email = $('#email').val();
                const password = $('#password').val();
                
                $('#loginError').addClass('d-none').text('');
                
                $.ajax({
                    url: '/api/login',
                    method: 'POST',
                    data: {
                        email: email,
                        password: password,
                        remember: $('#remember').is(':checked')
                    },
                    success: function(response) {
                        localStorage.setItem('auth_token', response.token);
                        window.location.href = '/dashboard';
                    },
                    error: function(xhr) {
                        let msg = 'Erro ao autenticar. Verifique suas credenciais.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        $('#loginError').removeClass('d-none').text(msg);
                    }
                });
            });
            
            // Verificar token apenas uma vez ao carregar a página
            if (!tokenVerificado) {
                tokenVerificado = true;
                const token = localStorage.getItem('auth_token');
                
                if (token) {
                    verificarToken(token)
                        .then(response => {
                            if (response && response.id) {
                                window.location.href = '/dashboard';
                            } else {
                                localStorage.removeItem('auth_token');
                            }
                        })
                        .catch(() => {
                            localStorage.removeItem('auth_token');
                        });
                }
            }
        });
    </script>
</body>
</html>
