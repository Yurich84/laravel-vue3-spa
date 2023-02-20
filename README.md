<p align="center">
<img height="80" src="https://laravel.com/img/logomark.min.svg">
<img height="80" src="https://vuejs.org/images/logo.png" alt="Vue logo">
<img height="80" src="https://cdn.worldvectorlogo.com/logos/element-ui-1.svg">
</p>

<h1>This project under development!</h1>

[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)

[//]: # (![GitHub Workflow Status]&#40;https://img.shields.io/github/workflow/status/Yurich84/laravel-vue-spa-skeleton/Laravel?label=tests&#41;)
[//]: # (![GitHub Workflow Status]&#40;https://img.shields.io/github/workflow/status/Yurich84/laravel-vue-spa-skeleton/Check%20&%20fix%20styling?label=style&#41;)

#### This is a groundwork for a large modular SPA, that utilises Laravel, Vue, ElementUI. 
#### CRUD generator is integrated in project creates standalone modules on the frontend and backend.

<p align="center">
    <img width="100%" src="https://i.imgur.com/VNa5jOg.png" >
</p>

The main goals of the project are:
- to avoid hard cohesion between modules
- to form the basis for writing clean code
- to be easy to expand
- to avoid code duplication
- to reduce the start time of the project
- to reduce the time of project support and code navigation
- to be understandable for an inexperienced programmer

## Extensions

- BackEnd: [Laravel 9](https://laravel.com/)
- FrontEnd: [Vue3 Composition Api](https://vuejs.org) + [VueRouter](https://router.vuejs.org) + [Pinia](https://pinia.vuejs.org) + [VueI18n](https://kazupon.github.io/vue-i18n/)
- Login using [Vue-Auth](https://websanova.com/docs/vue-auth/home), [Axios](https://github.com/mzabriskie/axios) and [Sanctum](https://laravel.com/docs/8.x/sanctum).
- The api routes, are separate for each module, in **Modules/{ModuleName}/routes_api.php**
- [ElementUI](https://element-plus.org/) UI Kit 
- [Lodash](https://lodash.com) js utilities
- [Day.js](https://dayjs.com) time manipulations
- [FontAwesome 5](http://fontawesome.io/icons/) icons

## Install
- `git clone https://github.com/Yurich84/laravel-vue-spa-skeleton.git`
- `cd laravel-vue-spa-skeleton`
- `composer install`
- `cp .env.example .env` - copy .env file
- set your DB credentials in `.env`
- `php artisan key:generate`
- `php artisan migrate`
- `yarn install`

## Testing

### Unit Testing
`php artisan test`

## Usage
- `npm run watch` or `npm run hot` - for hot reloading
- `php artisan serve` and go [127.0.0.1:8000](http://127.0.0.1:8000)
- Create new user and login.

### Creating module
You can easily create module with CRUD functionality.
 
`php artisan make:module {ModuleName}`

This will create: 

- **migration** `database/migrations/000_00_00_000000_create_{ModuleName}_table.php`

- **model** `app/Models/{ModuleName}.php`

- **factory** `database/factories/{ModuleName}Factory.php`

- **tests** `tests/Feature/{ModuleName}Test.php`

- **backend module** `app/Modules/{ModuleName}/`
```
{ModuleName}/
│
├── routes_api.php
│
├── Controllers/
│   └── {ModuleName}Controller.php
│
├── Requests/
│   └── {ModuleName}Request.php
│
└── Resources/
    └── {ModuleName}Resource.php
```

- **frontend module** `resources/js/modules/{moduleName}/`
```
{moduleName}/
│
├── routes.js
│
├── {moduleName}Api.js
│
├── {moduleName}Store.js
│
├── components/
    ├── {ModuleName}List.vue
    ├── {ModuleName}View.vue
    └── {ModuleName}Form.vue
```


> After creating module, you can edit model and migration by adding fields you need. 
> Also you can add this fields into view.
> Don't forget run php artisan migrate.

Every module loads dynamically.

## [Video](https://www.youtube.com/watch?v=0qKNlrmhgNg)
