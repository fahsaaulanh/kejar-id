# Kejar.id Matrikulasi

Built with ❤️

## Onboarding and Development Guide

### Dependencies

- Git (duh?)
- Yarn 1.12

### Installation

1. Clone this repository and install the dependencies above
2. Copy `.env` from `env.example` and modify the configuration value appropriately
3. `composer install` to install dependencies
4. If you are using Docker, visit its container (see docker readme)
5. If you are not using Docker, run `php artisan serve` to run it on development environment

### Convention

**Directory Structure**  
Bootstrap CSS Directory in `/public/css/bootstrap.css`

Jquery is also include in `/public/js/jquery.js`

view folder structures  `/resources/views`

controller folder structures `/app/Http/Controllers` there is example e.g `LoginController` and `HomeController`

API service folder structures `/app/Services` there is example e.g `User`

**composer.lock**  
Do not check `composer.lock` into repository, we're using composer so lock file should only be `composer.lock`
