# Currency ISO Service

Este projeto é um serviço web que permite a busca de informações de moedas com base no padrão ISO 4217. Ele utiliza o Guzzle HTTP Client para buscar dados da Wikipédia e os analisa usando Symfony DomCrawler.

## Índice

- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Uso](#uso)
- [Testes](#testes)

## Requisitos

- Docker Compose

## Instalação

1. Clone o repositório:

   git clone git@github.com:Felipebellm/desafio-backend-PHP.git

2. Navege para raiz do protejo

    cd desafio-backend-PHP

3. Monte o ambiente

    se sua maquina tiver makefile habilitado rode o seguinte comando:
    
        make build
    
    se nao, rode os seguintes comandos:

        docker-compose up -d
        docker-compose exec app composer install
        cp .env.example .env
        docker-compose exec app chmod -R 777 .
        docker-compose exec app php artisan key:generate
        docker-compose exec app php artisan migrate
        docker-compose exec app composer require guzzlehttp/guzzle symfony/dom-crawler
        docker-compose exec app php artisan serve

## Uso

    - acesse a pagina localhost:8989
    - inserir codigos alfanumericos e numericos na quantidade que desejar. 
   

## Teste

    - rodar comando:
        docker-compose exec app ./vendor/bin/phpunit