## Aplicação

Esta aplicação realiza a transferência de valores entre 2 usuários.

Usuários do tipo "C", podem realizar e receber valores.

Usuários do tipo "S", somente recebem valores.

## Importante

- Os usuários de id 1 ao 5 são usuários comuns e do 6 ao 10 são lojistas. Os mesmos já possuem valores em suas respectivas carteiras.
- As tabelas do banco de dados são as seguintes:
    * users (Usuários da aplicação)
    * wallets (Carteira dos usuários)
    * transactions (Registro das transações)
    * Payload `{
           "value" : "100.00",
           "payer" : 1,
           "payee" : 2
       }`

## Ambiente

Aplicação desenvolvida utilizando o Laravel versão 6, banco de dados Mysql e Redis, Swagger e Docker.

A porta para executar a aplicação é a 8083. 

Foram criados 3 containers um para executar a  aplicação, sendo, `app-desafio` para a aplicação, `app-mysql` para o banco de dados e `app-redis` banco de dados em memória para o processamento da fila.

Após o procesamento das transações será disparado um e-mail para o beneficiário. Para receber este e-mail, informe suas credenciais no arquivo .env referente as credenciais do Mailtrap.

## Instalação

Para executar a aplicação é necessário realizar os procedimentos abaixo:

- Baixar o projeto
- Renomear o arquivo `.env.example` para `.env`
- Executar o comando para criar os cotainers Docker `docker-compose up -d`
- Executar o comando para baixar as dependências `composer install`
    * Ou via Docker, `docker-compose exec app composer install`
- Executar o comando para gerar a nova chave do Laravel `php artisan key:generate`
    * Ou via Docker, `docker-compose exec app php artisan key:generate`
- Executar o comando para criar as tabelas do banco de dados `php artisan migrate`
    * Ou via Docker, `docker-compose exec app php artisan migrate`
- Executar o comando para popular o banco de dados `php artisan db:seed`
    * Ou via Docker, `docker-compose exec app php artisan db:seed`
- Excutar o comando para ativar a fila de processamento `php artisan queue:listen redis`
    * Ou via Docker, `docker-compose exec app php artisan queue:listen redis`

## Endpoints

- Lista todos os usuários da aplicação. A senha de todos os usuários cadastrados é `password`
    * http://localhost:8083/api/users
    
- Autenticação dos usuários
    * http://localhost:8083/api/auth/login (Efetua o login)
        * Payload `{ "email": "user_email", "password": "user_password" }`
    * http://localhost:8083/api/auth/logout (Efetua logout)
    * http://localhost:8083/api/auth/refresh (Atualiza os dados do token)
    * http://localhost:8083/api/auth/me (Mostra informações do usuário)

- Transação SEM autenticação
    * http://localhost:8083/transaction (Realiza o processamento da transferência).
    * http://localhost:8083/transaction-queue (Realiza o processamento da transferência através de fila de processamento).

- Transação COM autenticação
    * http://localhost:8083/transaction-with-authentication (Realiza o processamento da transferência).
    * http://localhost:8083/transaction-queue-with-authentication (Realiza o processamento da transferência através de fila de processamento).

- Documentação
    * http://localhost:8083/api/documentation (Documentação do endpoint).

## Fila de Processamento

- Para ativar a fila de processamento digite o comando na raiz do projeto `php artisan queue:listen redis`
    * Ou via Docker, `docker-compose exec app php artisan queue:listen redis`

## Testes

Para realizar os testes unitários execute o comando `composer tests-unit`
    * Ou via Docker, `docker-compose exec app composer tests-unit`

Para realizar os testes de feature execute o comando `composer tests-feature`
    * Ou via Docker, `docker-compose exec app composer tests-feature`
    
## Desenvolvedor

- Rodrigo Ruy Oliveira
- Email: rro.oliveira@gmail.com
