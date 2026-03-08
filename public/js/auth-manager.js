/**
 * Gerenciador de Autenticação e Requisições AJAX - MC Comercial
 * 
 * Este arquivo centraliza toda a lógica de autenticação e configuração
 * de requisições AJAX para o sistema MC Comercial, resolvendo os problemas
 * de autenticação que existiam anteriormente.
 * 
 * PROBLEMAS RESOLVIDOS:
 * - Login não funcionava (agora usa rota híbrida /api/web-login)
 * - CRUDs falhavam por falta de autenticação
 * - Tratamento inconsistente de erros 401
 * - Código duplicado em cada view
 * 
 * FUNCIONALIDADES:
 * - Verificação automática de autenticação
 * - Configuração global de headers AJAX
 * - Interceptação e tratamento automático de erros
 * - Classe CrudManager para operações padronizadas
 * - Sistema unificado de alertas
 * - Redirecionamentos automáticos para login
 * 
 * USO:
 * 1. É carregado automaticamente no layout principal
 * 2. Cada CRUD cria seu próprio manager: new CrudManager('Nome', '/api/endpoint')
 * 3. Usa métodos async/await: await manager.loadList()
 * 
 * @author Sistema MC Comercial
 * @version 2.0 - Versão corrigida e otimizada
 */

class AuthManager {
    constructor() {
        this.token = localStorage.getItem('auth_token');
        this.init();
    }

    /**
     * Inicializa o gerenciador de autenticação
     */
    init() {
        this.setupAjaxDefaults();
        this.setupInterceptors();
        
        // Verifica autenticação apenas em páginas protegidas
        if (this.isProtectedPage()) {
            this.checkAuthentication();
        }
    }

    /**
     * Verifica se a página atual requer autenticação
     */
    isProtectedPage() {
        const publicPaths = ['/', '/login', '/site', '/home'];
        const currentPath = window.location.pathname;
        
        // Se é uma página pública, não precisa verificar auth
        return !publicPaths.some(path => 
            currentPath === path || currentPath.startsWith('/site/')
        );
    }

    /**
     * Configura os defaults do jQuery AJAX
     */
    setupAjaxDefaults() {
        $.ajaxSetup({
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: (xhr) => {
                // Adiciona token apenas se existir
                if (this.token) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + this.token);
                }
            }
        });
    }

    /**
     * Configura interceptadores de requisições
     */
    setupInterceptors() {
        // Intercepta todas as requisições AJAX
        $(document).ajaxError((event, jqXHR, ajaxSettings, thrownError) => {
            if (jqXHR.status === 401) {
                this.handleUnauthorized();
            } else if (jqXHR.status === 403) {
                this.showAlert('Acesso negado. Você não tem permissão para esta ação.', 'warning');
            } else if (jqXHR.status >= 500) {
                this.showAlert('Erro interno do servidor. Tente novamente mais tarde.', 'danger');
            }
        });
    }

    /**
     * Verifica se o usuário está autenticado
     */
    async checkAuthentication() {
        if (!this.token) {
            this.redirectToLogin();
            return false;
        }

        try {
            const response = await $.ajax({
                url: '/api/user',
                method: 'GET'
            });

            // Se chegou aqui, o token é válido
            this.user = response;
            return true;

        } catch (error) {
            if (error.status === 401) {
                this.handleUnauthorized();
            }
            return false;
        }
    }

    /**
     * Lida com erro de não autorizado (401)
     */
    handleUnauthorized() {
        this.clearAuth();
        this.showAlert('Sessão expirada. Faça login novamente.', 'warning');
        
        // Delay para mostrar a mensagem antes de redirecionar
        setTimeout(() => {
            this.redirectToLogin();
        }, 2000);
    }

    /**
     * Limpa dados de autenticação
     */
    clearAuth() {
        localStorage.removeItem('auth_token');
        this.token = null;
        this.user = null;
    }

    /**
     * Redireciona para a página de login
     */
    redirectToLogin() {
        window.location.href = '/login';
    }

    /**
     * Faz logout do usuário
     */
    async logout() {
        try {
            await $.ajax({
                url: '/api/logout',
                method: 'POST'
            });
        } catch (error) {
            console.warn('Erro ao fazer logout:', error);
        } finally {
            this.clearAuth();
            this.redirectToLogin();
        }
    }

    /**
     * Mostra um alerta na tela
     */
    showAlert(message, type = 'info', duration = 5000) {
        // Remove alertas antigos
        $('.auth-alert').remove();

        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show auth-alert" 
                 style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        $('body').append(alertHtml);

        // Remove automaticamente após o tempo especificado
        if (duration > 0) {
            setTimeout(() => {
                $('.auth-alert').fadeOut(() => {
                    $('.auth-alert').remove();
                });
            }, duration);
        }
    }

    /**
     * Obtém o usuário autenticado
     */
    getUser() {
        return this.user;
    }

    /**
     * Obtém o token de autenticação
     */
    getToken() {
        return this.token;
    }

    /**
     * Define um novo token de autenticação
     */
    setToken(token) {
        this.token = token;
        localStorage.setItem('auth_token', token);
        this.setupAjaxDefaults(); // Reconfigurar AJAX com novo token
    }

    /**
     * Verifica se o usuário está autenticado
     */
    isAuthenticated() {
        return !!this.token;
    }
}

// Utilitários globais para CRUD
class CrudManager {
    constructor(resourceName, apiEndpoint) {
        this.resourceName = resourceName;
        this.apiEndpoint = apiEndpoint;
    }

    /**
     * Carrega lista de recursos
     */
    async loadList() {
        try {
            const data = await $.ajax({
                url: this.apiEndpoint,
                method: 'GET'
            });
            return data;
        } catch (error) {
            throw error;
        }
    }

    /**
     * Busca um recurso específico
     */
    async findById(id) {
        try {
            const data = await $.ajax({
                url: `${this.apiEndpoint}/${id}`,
                method: 'GET'
            });
            return data;
        } catch (error) {
            throw error;
        }
    }

    /**
     * Cria um novo recurso
     */
    async create(data) {
        try {
            const response = await $.ajax({
                url: this.apiEndpoint,
                method: 'POST',
                data: JSON.stringify(data)
            });
            window.authManager.showAlert(`${this.resourceName} criado com sucesso!`, 'success');
            return response;
        } catch (error) {
            this.handleError(error, 'criar');
            throw error;
        }
    }

    /**
     * Atualiza um recurso
     */
    async update(id, data) {
        try {
            const response = await $.ajax({
                url: `${this.apiEndpoint}/${id}`,
                method: 'PUT',
                data: JSON.stringify(data)
            });
            window.authManager.showAlert(`${this.resourceName} atualizado com sucesso!`, 'success');
            return response;
        } catch (error) {
            this.handleError(error, 'atualizar');
            throw error;
        }
    }

    /**
     * Remove um recurso
     */
    async delete(id) {
        try {
            await $.ajax({
                url: `${this.apiEndpoint}/${id}`,
                method: 'DELETE'
            });
            window.authManager.showAlert(`${this.resourceName} removido com sucesso!`, 'success');
        } catch (error) {
            this.handleError(error, 'remover');
            throw error;
        }
    }

    /**
     * Trata erros de CRUD
     */
    handleError(error, action) {
        let message = `Erro ao ${action} ${this.resourceName}.`;
        
        if (error.responseJSON && error.responseJSON.message) {
            message = error.responseJSON.message;
        } else if (error.responseJSON && error.responseJSON.errors) {
            // Erros de validação
            const errors = Object.values(error.responseJSON.errors).flat();
            message = errors.join('<br>');
        }

        window.authManager.showAlert(message, 'danger');
    }
}

// Inicializa o gerenciador de autenticação quando o documento estiver pronto
$(document).ready(function() {
    window.authManager = new AuthManager();
    
    // Disponibiliza classe CrudManager globalmente
    window.CrudManager = CrudManager;
    
    // Configura botão de logout se existir
    $(document).on('click', '[data-logout]', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Terminar Sessão?',
            text: 'Tem a certeza que deseja terminar a sessão?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, terminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.authManager.logout();
            }
        });
    });
});
