<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MC-COMERCIAL — Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            min-height: 100vh;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }
        h1, h2, h3 { font-family: 'Sora', 'Inter', sans-serif; }

        /* Geometric squares pattern on entire background */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h60v60H0z' fill='none'/%3E%3Cpath d='M30 0v60M0 30h60' stroke='rgba(255,255,255,0.04)' stroke-width='1'/%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg width='120' height='120' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='10' y='10' width='30' height='30' rx='4' fill='none' stroke='rgba(59,130,246,0.06)' stroke-width='1'/%3E%3Crect x='70' y='60' width='20' height='20' rx='3' fill='none' stroke='rgba(59,130,246,0.04)' stroke-width='1'/%3E%3Crect x='50' y='20' width='15' height='15' rx='2' fill='rgba(59,130,246,0.03)'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* Radial glow accents */
        .glow-top { position: absolute; top: -50%; right: -30%; width: 80vw; height: 80vw; border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,0.12), transparent 70%); pointer-events: none; }
        .glow-bottom { position: absolute; bottom: -40%; left: -20%; width: 60vw; height: 60vw; border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,0.08), transparent 70%); pointer-events: none; }

        /* Back to site link */
        .back-link {
            position: fixed; top: 1.5rem; left: 1.5rem; color: rgba(255,255,255,0.75); text-decoration: none;
            font-size: 0.875rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 1rem; border-radius: 0.75rem; background: rgba(255,255,255,0.08);
            backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.12); transition: all 0.25s; z-index: 10;
        }
        .back-link:hover { color: white; background: rgba(255,255,255,0.18); transform: translateX(-3px); }

        .login-wrapper { position: relative; z-index: 1; width: 100%; max-width: 440px; }
        .login-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: 1.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25), 0 0 80px rgba(59,130,246,0.1); overflow: hidden; animation: slideUp 0.6s ease-out; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .login-header { background: linear-gradient(135deg, #1e3a8a, #2563eb); padding: 2.5rem 2rem; text-align: center; color: white; position: relative; overflow: hidden; }
        .login-header::before { content: ''; position: absolute; inset: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h60v60H0z' fill='none'/%3E%3Cpath d='M30 0v60M0 30h60' stroke='rgba(255,255,255,0.05)' stroke-width='1'/%3E%3C/svg%3E"); }
        .login-header .content { position: relative; z-index: 1; }
        .login-header img { height: 56px; width: auto; margin: 0 auto 0.75rem; display: block; filter: brightness(0) invert(1); }
        .login-header h1 { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.03em; }
        .login-header p { font-size: 0.875rem; opacity: 0.7; margin-top: 0.25rem; }
        .login-body { padding: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-size: 0.8125rem; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem; }
        .input-wrap { position: relative; }
        .input-wrap i { position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #94a3b8; pointer-events: none; }
        .input-wrap input { width: 100%; padding: 0.75rem 0.875rem 0.75rem 2.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; font-size: 0.9375rem; color: #1e293b; background: #f8fafc; transition: all 0.2s; font-family: inherit; }
        .input-wrap input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59,130,246,0.12); background: #fff; }
        .input-wrap input::placeholder { color: #94a3b8; }
        .checkbox-wrap { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; }
        .checkbox-wrap input[type="checkbox"] { width: 1rem; height: 1rem; accent-color: #2563eb; cursor: pointer; }
        .checkbox-wrap label { font-size: 0.8125rem; color: #64748b; cursor: pointer; }
        .btn-login { width: 100%; padding: 0.875rem; background: linear-gradient(135deg, #1e3a8a, #2563eb); color: white; border: none; border-radius: 0.75rem; font-size: 1rem; font-weight: 700; font-family: 'Sora', sans-serif; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(37,99,235,0.3); }
        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .alert { padding: 0.75rem 1rem; border-radius: 0.75rem; font-size: 0.8125rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
        .alert-danger { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .site-link { text-align: center; margin-top: 1.25rem; }
        .site-link a { color: #2563eb; font-size: 0.8125rem; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 0.375rem; transition: all 0.2s; }
        .site-link a:hover { color: #1e3a8a; }
        .copyright { text-align: center; margin-top: 1rem; font-size: 0.75rem; color: #94a3b8; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner { width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.3); border-top-color: white; border-radius: 50%; animation: spin 0.6s linear infinite; }
    </style>
</head>
<body>
    <div class="glow-top"></div>
    <div class="glow-bottom"></div>

    <a href="{{ route('site.home') }}" class="back-link">
        <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        Voltar ao Site
    </a>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="content">
                    <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL"
                         onerror="this.style.display='none'">
                    <h1>MC-COMERCIAL</h1>
                    <p>Sistema de Gestão</p>
                </div>
            </div>
            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i data-lucide="alert-circle" style="width:16px;height:16px;flex-shrink:0;"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form id="loginForm" onsubmit="return false;">
                    <div id="loginError" class="alert alert-danger" style="display:none;"></div>

                    <div class="form-group">
                        <label for="email">Endereço de Email</label>
                        <div class="input-wrap">
                            <i data-lucide="mail"></i>
                            <input type="email" id="email" name="email" required autofocus placeholder="Digite seu email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Palavra-passe</label>
                        <div class="input-wrap">
                            <i data-lucide="lock"></i>
                            <input type="password" id="password" name="password" required placeholder="Digite sua palavra-passe">
                        </div>
                    </div>

                    <div class="checkbox-wrap">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Manter sessão iniciada</label>
                    </div>

                    <button type="submit" class="btn-login" id="btnLogin">
                        <i data-lucide="log-in" style="width:18px;height:18px;"></i>
                        Iniciar Sessão
                    </button>
                </form>

                <div class="site-link">
                    <a href="{{ route('site.home') }}">
                        <i data-lucide="globe" style="width:14px;height:14px;"></i>
                        Ir para o site
                    </a>
                </div>

                <div class="copyright">© {{ date('Y') }} MC-COMERCIAL. Todos os direitos reservados.</div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#btnLogin');
            const errDiv = $('#loginError');
            errDiv.hide();
            btn.prop('disabled', true).html('<div class="spinner"></div> A entrar...');

            $.ajax({
                url: '/api/login',
                method: 'POST',
                data: { email: $('#email').val(), password: $('#password').val(), remember: $('#remember').is(':checked') },
                success: function(res) {
                    if (res.token) {
                        localStorage.setItem('api_token', res.token);
                        if (res.user) localStorage.setItem('user', JSON.stringify(res.user));
                    }
                    window.location.href = '/dashboard';
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i data-lucide="log-in" style="width:18px;height:18px;"></i> Iniciar Sessão');
                    lucide.createIcons();
                    let msg = 'Credenciais inválidas.';
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        else if (xhr.responseJSON.errors) msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    errDiv.html('<i data-lucide="alert-circle" style="width:16px;height:16px;flex-shrink:0;"></i><span>' + msg + '</span>').show();
                    lucide.createIcons();
                }
            });
        });
    </script>
</body>
</html>
