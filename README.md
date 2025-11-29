# Conecta Cidade 🏙️

> Projeto Acadêmico - UPX IV | Centro Universitário FACENS

O **Conecta Cidade** é uma plataforma web de participação cidadã focada em mobilidade urbana. O sistema permite que cidadãos reportem problemas na infraestrutura da cidade (como buracos, falta de iluminação, sinalização) e participem democraticamente votando em propostas de melhoria.

O projeto está alinhado aos **Objetivos de Desenvolvimento Sustentável (ODS)** da ONU, especificamente ODS 11 (Cidades Sustentáveis) e ODS 17 (Parcerias).

## 🚀 Funcionalidades

### 👤 Para o Cidadão
* **Autenticação:** Cadastro e Login seguros.
* **Dashboard:** Visão geral de reportes e estatísticas pessoais.
* **Reportes:** Criação de reportes com geolocalização (mapa interativo), upload de fotos/vídeos e categorização (Ex: Buracos, Semáforos, Iluminação).
* **Acompanhamento:** Visualização do status dos reportes (Pendente, Em Análise, Resolvido).
* **Votação:** Sistema de votação (Apoiar/Não Apoiar/Neutro) em propostas de melhoria urbana.
* **Comentários:** Interação em reportes e propostas.

### 🛡️ Para o Administrador
* **Gestão de Reportes:** Alteração de status (Pendente -> Resolvido) e nível de urgência.
* **Visualização Geral:** Mapa de calor e lista de problemas reportados.

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 8.2+, Laravel Framework.
* **Frontend:** Blade Templates, JavaScript (ES6), TailwindCSS e Bootstrap.
* **Banco de Dados:** MySQL / MariaDB.
* **Mapas:** Leaflet.js e OpenStreetMap.
* **Gerenciamento de Pacotes:** Composer (PHP) e NPM (Node.js).

## 💻 Pré-requisitos

Para rodar o projeto localmente, você precisará ter instalado:
* [PHP](https://www.php.net/) (Versão 8.2 ou superior)
* [Composer](https://getcomposer.org/)
* [Node.js](https://nodejs.org/) & NPM
* [MySQL](https://www.mysql.com/) (ou MariaDB/XAMPP/Laragon)

## 🔧 Como Instalar e Rodar

Siga o passo a passo abaixo para configurar o ambiente de desenvolvimento:

```bash
git clone [https://github.com/seu-usuario/conecta-cidade.git](https://github.com/seu-usuario/conecta-cidade.git)
cd conecta-cidade

2. Instalar Dependências do Backend (PHP)
composer install

3. Instalar Dependências do Frontend (JS/CSS)
npm install

4. Configurar Variáveis de Ambiente
cp .env.example .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=conectacidade
DB_USERNAME=seu username
DB_PASSWORD= sua senha.

5. Criar Banco de Dados e Rodar Migrations
php artisan migrate

6. Iniciar o Projeto
php artisan serve
