# Modelo padrão de utilização em aplicações

Modelo laravel + vuejs3 padrão + jwt já configurado para utilização com quasar e tailwind css configurados.

- Laravel 10
- PHP 8.1
- Vuejs3
- Quasar
- Tailwind Css

## Clone

```bash
git clone https://github.com/cettufg/modelo_laravel_vuejs.git
```

## Instalação
1. Na raiz do projeto, execute os seguintes comandos:

```bash
composer install

npm install

```

2. Após a instalação das dependênencias, configure seu arquivo .env de acordo com suas configurações locais.

3. Para publicar as configurações e gerar a chave JWT (autenticação de APIs), execute os comandos abaixo na raiz do projeto:

```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

php artisan jwt:secret

```

### Notas
Documentação do JWT Auth: [`Clique aqui`](https://jwt-auth.readthedocs.io/en/develop/quick-start/)

## Código Style para remover bugs css do quasar

```bash

<style>
[type='text']:focus, [type='email']:focus, [type='url']:focus, [type='password']:focus,
[type='number']:focus, [type='date']:focus, [type='datetime-local']:focus, [type='month']:focus,
[type='search']:focus, [type='tel']:focus, [type='time']:focus, [type='week']:focus, [multiple]:focus,
textarea:focus, select:focus{
    --tw-ring-shadow: 0;
}
</style>

```

