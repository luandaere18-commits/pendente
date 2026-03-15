# 🚀 Como Linkar com GitHub - Passo a Passo

## 1️⃣ Criar Repositório no GitHub

### No seu browser (github.com):

1. Acesse **https://github.com/new**
2. Preencha:
   - **Repository name**: `Pendentes` ou `MC-COMERCIAL`
   - **Description**: `Site de formação profissional em Blade + Tailwind`
   - **Public** ✅ (para poder compartilhar com Lovable)
   - ❌ Não inicialize com README (já tem um!)
3. Clique **Create repository**

---

## 2️⃣ Configurar Git Localmente

### Terminal (PowerShell como Admin):

```powershell
# Navegar para o projeto
cd C:\Users\Elite\Pictures\Pendentes-main

# Verificar se Git já está configurado
git config --global user.name
git config --global user.email

# Se não estiver, configurar:
git config --global user.name "Seu Nome"
git config --global user.email "seu.email@gmail.com"
```

---

## 3️⃣ Inicializar Git Local

```powershell
# Verificar status
git status

# Se NÃO houver .git, inicializar:
git init

# Adicionar todos os ficheiros
git add .

# Criar primeiro commit
git commit -m "Projeto inicial - Site público com Blade e Tailwind"
```

---

## 4️⃣ Conectar ao GitHub

### Copie do GitHub a URL do repositório criado

Exemplo: `https://github.com/SEU-USUARIO/Pendentes.git`

### No terminal:

```powershell
# Adicionar o remote
git remote add origin https://github.com/SEU-USUARIO/Pendentes.git

# Verificar conexão
git remote -v
```

---

## 5️⃣ Fazer Push para GitHub

```powershell
# Renomear branch para 'main' (se necessário)
git branch -M main

# Fazer push
git push -u origin main

# Na primeira vez, pode pedir autenticação
# Use: Personal Access Token (não a senha!)
```

### 🔑 Se pedir autenticação (Personal Access Token):

1. Acesse **https://github.com/settings/tokens**
2. Clique **Generate new token**
3. Nome: `Git Local`
4. Selecione:
   - ✅ repo (acesso completo)
   - ✅ admin:repo_hook
5. Clique **Generate token**
6. **Copie o token** (apareça uma única vez!)
7. Cole no terminal quando pedir senha

---

## 6️⃣ Verificar no GitHub

Acesse **https://github.com/SEU-USUARIO/Pendentes**

Deve ver todos os ficheiros do projeto!

---

## 📤 Fazer Commits no Futuro

```powershell
# Após fazer mudanças
git add .
git commit -m "Descrição clara da mudança"
git push origin main
```

---

## ✅ Exemplos de Mensagens de Commit

```
git commit -m "Feat: Adicionar página de serviços Blade"
git commit -m "Fix: Corrigir layout responsivo em mobile"
git commit -m "Docs: Atualizar README com instruções"
git commit -m "Style: Ajustar cores Tailwind na navbar"
```

---

## 🎯 Link Final para Compartilhar

```
https://github.com/SEU-USUARIO/Pendentes
```

**Este é o link que passa ao Lovable!** ✨
