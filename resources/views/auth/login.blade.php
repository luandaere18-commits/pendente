<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MC-COMERCIAL - Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                url("data:image/svg+xml,%3Csvg width='80' height='80' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='10' y='10' width='25' height='25' rx='3' fill='none' stroke='rgba(255,255,255,0.06)' stroke-width='1'/%3E%3Crect x='50' y='45' width='15' height='15' rx='2' fill='rgba(255,255,255,0.03)'/%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0v60M0 30h60' stroke='rgba(255,255,255,0.02)' stroke-width='0.5'/%3E%3C/svg%3E");
            opacity: 0.8;
        }
        body > * { position: relative; z-index: 1; }
        .login-container { min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem; }
        .back-link {
            position: fixed; top: 1.5rem; left: 1.5rem; color: rgba(255,255,255,0.85); text-decoration: none;
            font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 1rem; border-radius: 0.75rem; background: rgba(255,255,255,0.12);
            backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.2s; z-index: 10;
        }
        .back-link:hover { color: white; background: rgba(255,255,255,0.25); transform: translateX(-3px); }
        .login-card { background: white; border-radius: 1rem; box-shadow: 0 25px 50px rgba(0,0,0,0.25); overflow: hidden; max-width: 420px; width: 100%; }
        .login-header { background: white; padding: 2.5rem 2rem 1.5rem; text-align: center; }
        .login-header h1 { margin: 0.75rem 0 0; font-size: 1.5rem; font-weight: 700; color: #1e3a8a; }
        .login-header p { margin: 0.25rem 0 0; color: #64748b; font-size: 0.9rem; }
        .login-body { padding: 1.5rem 2rem 2.5rem; }
        .form-label { font-weight: 500; color: #374151; margin-bottom: 0.5rem; }
        .form-control { border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.75rem 1rem; font-size: 0.95rem; transition: all 0.2s; background: #f9fafb; }
        .form-control:focus { border-color: #1e40af; box-shadow: 0 0 0 3px rgba(30,64,175,0.1); background: white; }
        .input-group-text { background: #f3f4f6; border: 1px solid #d1d5db; border-right: none; border-radius: 0.5rem 0 0 0.5rem; color: #6b7280; }
        .input-group .form-control { border-left: none; border-radius: 0 0.5rem 0.5rem 0; }
        .btn-login { background: linear-gradient(135deg, #1e3a8a, #1e40af); border: none; border-radius: 0.5rem; padding: 0.875rem 2rem; font-weight: 600; font-size: 1rem; width: 100%; color: white; transition: all 0.2s; }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgba(30,64,175,0.3); background: linear-gradient(135deg, #1e40af, #2563eb); color: white; }
        .form-check-input:checked { background-color: #1e40af; border-color: #1e40af; }
        .form-check-label { color: #374151; font-size: 0.9rem; }
        .alert { border: none; border-radius: 0.5rem; margin-bottom: 1.5rem; }
    </style>
</head>
<body>
    <a href="{{ route('site.home') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Voltar ao Site
    </a>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL" style="height: 70px; width: auto; display: block; margin: 0 auto;">
                <h1>MC-COMERCIAL</h1>
                <p>Sistema de Gestão</p>
            </div>
            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>@foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
                        </div>
                    </div>
                @endif
                <form id="loginForm" onsubmit="return false;">
                    <div id="loginError" class="alert alert-danger d-none"></div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Endereço de Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="Digite seu email">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Palavra-passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Digite sua palavra-passe">
                        </div>
                        @error('password')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Manter sessão iniciada</label>
                    </div>
                    <button type="submit" class="btn btn-login"><i class="fas fa-sign-in-alt me-2"></i>Iniciar Sessão</button>
                </form>
                <div class="text-center mt-4">
                    <a href="{{ route('site.home') }}" style="color: #1e40af; font-size: 0.9rem; text-decoration: none; font-weight: 500;">
                        <i class="fas fa-globe me-1"></i> Ir para o site
                    </a>
                </div>
                <div class="text-center mt-3">
                    <small style="color: #6b7280; font-size: 0.85rem;">© {{ date('Y') }} MC-COMERCIAL. Todos os direitos reservados.</small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                const btn = $(this).find('button[type="submit"]');
                const originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>A entrar...').prop('disabled', true);
                $('#loginError').addClass('d-none');
                $.ajax({
                    url: '/api/login', method: 'POST',
                    data: { email: $('#email').val(), password: $('#password').val(), remember: $('#remember').is(':checked') },
                    success: function(response) {
                        if (response.token) {
                            localStorage.setItem('auth_token', response.token);
                            if (response.user) localStorage.setItem('auth_user', JSON.stringify(response.user));
                            window.location.href = '/dashboard';
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Credenciais inválidas.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        $('#loginError').html('<i class="fas fa-exclamation-circle me-2"></i>' + msg).removeClass('d-none');
                        btn.html(originalText).prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>
</html>
