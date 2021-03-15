# Czechitas DA Testing App

Aplikace využívá PHP framework [Laravel](https://laravel.com/docs/8.x/), [Bootstrap 4](https://getbootstrap.com/docs/4.6/getting-started/introduction/), [Webpack 5](https://webpack.js.org/).

## Prerekvizity:

- PHP 7.3+
- Composer 2 https://getcomposer.org/download/
- MySQL - netestováno s jinou DB, ale možná bude fungovat
- NodeJS 14+ - pro build assetů (JS/CSS)
- npm

## Instalace

1. Naklonování repozitáře
1. Instalace PHP závislostí - `composer install`
    - V produkčním prostředí spouštět `composer install --optimize-autoloader --prefer-dist --no-dev --no-ansi --no-interaction`
1. Vytvoření souboru `.env` a vložení obsahu z `.env.example`
    1. Vyplnit přístupové údaje do DB
    1. APP_KEY je možné přegenerovat spuštění `php artisan key:generate` - spouštět pouze při první instalaci
1. Vytvoření DB schématu pomocí `php artisan migrate`
    1. Vložení 2 uživatelských účtu (role `master` a `admin`) do DB pomocí `php artisan db:seed`
1. Instalace NodeJS závislostí a build assetů - `npm install` a  `npm run build`

### Konfigurace pomocí `.env`

- `APP_KEY` - Secret key - slouží k šifrování cookies a session - při změně budou všichni uživatelé odhlášení
    - Lze přegenerovat pomocí `php artisan key:generate`
- `APP_URL` - URL adresa, na které systém běží. Používá se při generování obsahu emailů
- `APP_FORCE_URL` - Pokud je `true` je nutné zadat i `APP_URL`. Pokud návštěvník přijde na jinou URL, je přesměrován.
    - Příklad: `APP_URL=http://www.czechitas.cz` uživatel přijde na `http://czechitas.cz` -> je přesměrován na adresu s `www`
    - Neřeší HTTP/HTTPS
- `HTTPS_ENABLE` - pokud je HTTPS povoleno, je automaticky každý request na HTTP přesměrován na HTTPS s kódem 301
    - Volitelně lze zapnout také HSTS, více na [kutac.cz/pocitace-a-internety/https-nestaci-jak-na-hsts-a-hpkp](https://www.kutac.cz/pocitace-a-internety/https-nestaci-jak-na-hsts-a-hpkp)
- `DB_*` - přístupové údaje k DB
