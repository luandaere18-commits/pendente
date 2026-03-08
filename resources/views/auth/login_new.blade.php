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
        
        .login-header h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
        }
        
        .login-body {
            padding: 2.5rem 2rem;
        }
        
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            color: white;
            font-weight: 500;
            width: 100%;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #1e40af, #2563eb);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="text-center mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL" style="height: 60px; max-height: 60px; width: auto; display: block; margin: 0 auto;">
                    <h1 style="margin-top: 0.5rem; margin-bottom: 0;">MC-COMERCIAL</h1>
                </div>
                <p>Sistema de Gestão</p>
            </div>
            
            <div class="login-body">
                <div id="loginError" class="alert alert-danger d-none"></div>
                
                <form id="loginForm" onsubmit="return false;">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Manter sessão iniciada</label>
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Configuração global do AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                }
            });

            // Limpar token antigo ao carregar a página
            localStorage.removeItem('auth_token');
            
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                
                const $submitBtn = $(this).find('button[type="submit"]');
                const originalText = $submitBtn.html();
                
                // Desabilitar botão e mostrar loading
                $submitBtn.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i> Aguarde...');
                
                // Esconder mensagem de erro anterior
                $('#loginError').addClass('d-none');
                
                const formData = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                    remember: $('#remember').is(':checked'),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                console.log('Attempting login with:', formData);

                $.ajax({
                    url: '/login',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('Login successful:', response);
                        // Redirecionar para dashboard
                        window.location.href = '/dashboard';
                    },
                    error: function(xhr, status, error) {
                        console.error('Login error:', {xhr, status, error});
                        
                        let msg = 'Erro ao autenticar. Verifique suas credenciais.';
                        
                        if (xhr.status === 401) {
                            msg = 'Email ou senha inválidos.';
                        } else if (xhr.status === 422) {
                            msg = 'Por favor, preencha todos os campos corretamente.';
                        } else if (xhr.status === 429) {
                            msg = 'Muitas tentativas. Por favor, aguarde alguns minutos.';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        
                        $('#loginError').removeClass('d-none').text(msg);
                        $submitBtn.prop('disabled', false).html(originalText);
                    }
                });
                
                return false;
            });

            // Função para remover mensagem de erro quando o usuário começa a digitar
            $('#email, #password').on('input', function() {
                $('#loginError').addClass('d-none');
            });
        });
    </script>
</body>
</html>
