# README - Executando uma aplicação Laravel localmente

Este repositório contém os passos necessários para executar uma aplicação Laravel localmente. Siga as instruções abaixo para configurar seu ambiente de desenvolvimento e começar a executar a aplicação.

## Pré-requisitos

Certifique-se de que seu sistema atenda aos seguintes pré-requisitos:

- [PHP](https://www.php.net/) (versão 8.1 ou superior) (https://www.locaweb.com.br/blog/temas/codigo-aberto/como-instalar-o-php-no-ubuntu/)
- [EXTENSÕES_PHP] unzip, php8.1-dom, php8.1-xml, php8.1-curl, php8.1-mysql
- [Composer](https://getcomposer.org/) (gerenciador de dependências do PHP) (https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04-pt)
- [Node.js](https://nodejs.org/) (versão 14.x ou superior)
- [Npm] (gerenciador de pacotes do Node.js) (versão 9.x LTS ou superior)
- [MySQL](https://www.mysql.com/) para o desenvolvimento, foi utilizada uma imagem docker com MYSQL.

## Configuração inicial

1. Clone este repositório para sua máquina local usando o seguinte comando:
   ```
   git clone https://github.com/PedroSarment/Pontea.git
   ```

2. Navegue até o diretório do projeto:
   ```
   cd Pontea


3. Instale as dependências do Composer executando o seguinte comando:
   ```
   composer install
   ```

3. Instale as dependências do npm executando o seguinte comando:
   ```
   npm install
   ```

4. Copie o arquivo `.env.example` para um novo arquivo chamado `.env`:
   ```
   cp .env.example .env
   ```

5. Gere a chave da aplicação Laravel executando o comando:
   ```
   php artisan key:generate
   ```

7. Execute as migrações do banco de dados para criar as tabelas necessárias:
   ```
   php artisan migrate
   ```

8. Inicie o servidor de desenvolvimento do Laravel:
   ```
   php artisan serve
   ```

9. Abra um navegador da web e acesse a URL `http://localhost:8000`. A aplicação Laravel agora deve estar em execução localmente.

10. Para acessar a documentação da API, acesse a url http://localhost:8000/docs.
