# Centro de Formação API

API REST desenvolvida em Laravel para gerenciamento de centros de formação, cursos, formadores e produtos.

## 🔧 Requisitos do Sistema

- PHP >= 8.1
- Composer
- MySQL >= 5.7 ou MariaDB >= 10.3
- Node.js >= 16.x
- NPM >= 8.x

## ⚙️ Instalação

1. Clone o repositório:
```bash
git clone https://github.com/ari4268/pagina_back.git
cd pagina_back
```

2. Instale as dependências do PHP:
```bash
composer install
```

3. Instale as dependências do Node.js: (opcional para executar)
```bash
npm install
```

4. Copie o arquivo de ambiente: 
```bash
cp .env.example .env
```

5. Configure o arquivo .env com suas configurações de banco de dados: (Nome da BD: c_formacao_bd)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco_de_dados
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

6. Gere a chave da aplicação:
```bash
php artisan key:generate
```

7. Execute as migrações e seeds:
```bash
php artisan migrate:fresh --seed
```

8. Gere a documentação da API:
```bash
php artisan l5-swagger:generate
```

## 🚀 Executando o Projeto

1. Inicie o servidor Laravel:
```bash
php artisan serve
```

2. Em outro terminal, compile os assets:
```bash
npm run dev
```

O projeto estará disponível em `http://localhost:8000`

## 📝 Documentação da API

A documentação da API está disponível em:
- Swagger UI: `http://localhost:8000/api/documentation`

## 🔐 Autenticação

A API utiliza autenticação Bearer Token. Para obter um token:

1. Faça login usando as credenciais padrão:
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@admin.com","password":"password"}'
```

2. Use o token retornado nos headers das requisições:
```bash
Authorization: Bearer seu_token_aqui
```

## 📚 Recursos Disponíveis

- Centros de Formação (CRUD)
- Cursos (CRUD)
- Formadores (CRUD)
- Horários (CRUD)
- Produtos (CRUD)
- Categorias (CRUD)
- Pré-inscrições
- Autenticação (Login/Logout)

## 🗂️ Estrutura do Banco de Dados

O projeto utiliza as seguintes tabelas principais:
- centros
- cursos
- formadores
- horarios
- produtos
- categorias
- pre_inscricoes
- users

## 🤝 Contribuindo

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.


## 👨‍💻 Autor

Seu Nome - [@ari4268](https://github.com/ari4268)
