# Conecta_Cidade_UPX-IV

🎓 Projeto acadêmico desenvolvido no Centro Universitário FACENS

♾️ Conecta Cidade
Plataforma de Participação Cidadã em Mobilidade Urbana

🎯 Sobre o Projeto
O Conecta Cidade é uma plataforma web desenvolvida para fortalecer a participação cidadã na gestão da mobilidade urbana.

A solução visa criar um canal digital direto entre a população e os gestores públicos, facilitando a identificação rápida de problemas e a priorização de soluções com base na demanda real da comunidade.

Objetivos Principais
Reporte de Problemas: Permite aos cidadãos relatar problemas urbanos (buracos na rua, semáforos, iluminação) com geolocalização, fotos/vídeos e um sistema de protocolo para acompanhamento.

Votação em Propostas: Inclui um sistema para que usuários votem em propostas de melhoria urbana criadas pela comunidade ou pela prefeitura.

Alinhamento com ODS: O projeto contribui diretamente para os Objetivos de Desenvolvimento Sustentável da ONU: ODS 11 (Cidades e Comunidades Sustentáveis) e ODS 17 (Parcerias e Meios de Implementação).

💻 Tecnologias Utilizadas:  Laravel, JavaScript , HTML e CSS Banco de dados: MariaDB

🛠️ Instalação e Configuração
Siga os passos abaixo para configurar e executar o projeto em sua máquina local.

1. Requisitos
Você precisará ter instalado:

PHP (versão 8.2+ é a versão alvo, conforme composer.json e phpunit.xml)

MariaDB ou MySQL

Composer

Node.js e npm

2. Clonar Repositório e Instalar Dependências

# Clone o repositório
git clone [seu-link-do-repositorio]
cd Conecta_Cidade_UPX-IV

# Instale as dependências PHP
composer install

# Instale as dependências JavaScript
npm install

3. Configuração do Ambiente (.env)
Crie o arquivo de ambiente copiando o arquivo de exemplo:

cp .env.example .env

Edite o arquivo .env para configurar as variáveis de ambiente, especialmente as do banco de dados:

APP_NAME="Conecta Cidade"
APP_URL=http://localhost:8000
APP_DEBUG=true

# --- Configurações do Banco de Dados (MariaDB/MySQL) ---
DB_CONNECTION=mysql # Mantenha como 'mysql' para MariaDB
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=conectacidade  # Nome do seu banco
DB_USERNAME=root           # Seu usuário do banco
DB_PASSWORD=               # Sua senha do banco

4. Geração da Chave e Migrações
   
# Gere a chave única da aplicação
php artisan key:generate

# Execute as migrações (criação das tabelas)
php artisan migrate

# Opcional: Execute os seeders para adicionar dados de teste/padrão

5. Compilação do Frontend e Execução
Inicie o servidor de desenvolvimento (Vite) para compilar os assets CSS/JS e o servidor Laravel:

# Inicie o servidor Vite para os assets (CSS/JS)
npm run dev

# Em outra janela do terminal, inicie o servidor local do Laravel
php artisan serve

O projeto estará acessível em: http://127.0.0.1:8000 (ou a URL indicada pelo php artisan serve).

🚀 Uso/Execução
Acesso: Acesse o projeto na URL local.

Registro/Login: Crie uma conta em /register ou use uma conta existente em /login.

Reportes: Acesse /reportes/criar para relatar um novo problema, fornecendo título, descrição, categoria, urgência e localização no mapa.

Propostas: Navegue em /propostas para ver propostas em votação ou crie a sua em /propostas/criar.
