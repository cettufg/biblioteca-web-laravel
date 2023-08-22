# Modelo padrão de utilização em aplicações

Modelo laravel + vuejs3 padrão já configurado para utilização com quasar e tailwind css configurados.

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

```bash
composer install

npm install

```

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
