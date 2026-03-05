# WeAreSchool - Plataforma de Partilha de Projetos Escolares

O **WeAreSchool** é uma plataforma moderna e intuitiva desenhada para conectar alunos e professores através da partilha de conhecimento e projetos inspiradores.

## 🚀 Funcionalidades Principais

- **Submissão de Projetos**: Alunos podem submeter os seus trabalhos com descrições detalhadas e tags.
- **Anexos Múltiplos**: Suporte para diversos formatos de ficheiros (PDF, Imagens, ZIP, etc.) com visualização inline.
- **Categorização por Disciplinas**: Organização automática por áreas de estudo com cores e ícones personalizados.
- **Sistema de Contacto**: Chat direto entre utilizadores para facilitar a colaboração.
- **Interações**: Comentários e feedback sobre projetos.
- **Painel Administrativo**: Gestão completa de disciplinas, projetos e utilizadores.

## 🛠️ Tecnologias Utilizadas

- **Backend**: [Laravel 12+](https://laravel.com)
- **Frontend Interativo**: [Livewire 3](https://livewire.laravel.com)
- **Componentes Dinâmicos**: [Alpine.js](https://alpinejs.dev)
- **Estilização**: [Tailwind CSS](https://tailwindcss.com)
- **Base de Dados**: SQLite (ou MySQL em ambiente de produção)

## 📦 Instalação e Configuração

1. **Clonar o repositório**:
   ```bash
   git clone https://github.com/Matheus2008Melo/PAP.git
   ```

2. **Instalar dependências do PHP**:
   ```bash
   composer install
   ```

3. **Instalar dependências do Frontend**:
   ```bash
   npm install
   ```

4. **Configurar variáveis de ambiente**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Executar migrações**:
   ```bash
   php artisan migrate
   ```

6. **Iniciar o servidor de desenvolvimento**:
   ```bash
   npm run dev
   ```

---
**De Alunos para Alunos** - Criado com ❤️ para a comunidade escolar.
