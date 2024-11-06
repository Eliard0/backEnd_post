<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre o Projeto

Este é um projeto Laravel que inclui uma API com suporte a documentação em formato OpenAPI.

## Pré-requisitos

- PHP >= 8.0
- Composer
- Banco de dados ( MySQL )
- Node.js 

## Configuração do Projeto

1. Clone o repositório:
   git clone https://github.com/Eliard0/backEnd_post.git
   cd mais nome da pasta que voce colocou o projeto

2. Instale as dependências do projeto:
composer install

3. Crie o arquivo .env:
cp .env.example .env

4. Gere a chave da aplicação:
php artisan key:generate

5. Configure o banco de dados no arquivo .env.

6. Execute as migrações:
php artisan migrate

## Rodando o Projeto
Para iniciar o servidor de desenvolvimento:
php artisan serve

## Acessando a Documentação da API
Este projeto usa OpenAPI para gerar a documentação da API.

Gere o arquivo de documentação (caso ainda não tenha sido gerado):

php artisan l5-swagger:generate

## Acesse a documentação gerada pelo navegador. Precisa estar com o servidor rodando
localhost:8000/api/documentation ou http://localhost:8000/docs/api-docs.json

## Testando a API
Use o Postman ou outra ferramenta para testar as rotas da API. Você pode importar o arquivo YAML da documentação para visualizar e testar as rotas diretamente no Postman.