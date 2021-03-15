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


### Deployment
Deployment by měl více 
#### Jedna aplikace
1. Vytvořit fork pro Váš běh digitální akademie
1. Vytvořit účet na herokuapp.com
1. Vytvořit si účet na AWS - je potřeba S3 Bucket nastavit.
1. Vytvořit novou aplikaci na heroku
1. Deployment method - Nastavit GitHub, Váš nový fork
1. Enable Automatic deploys, pokud chcete, aby se Vám aplikace automaticky updatovala s novými commity
1. Nainstalovat ClearDB MySQL addon - https://dashboard.heroku.com/apps/<yourApp>/resources
    1. Ignite, free verze stačí.
1. Go to Settings 
    1. env `CLEARDB_DATABASE_URL` by měla být nastavená.
    1. Nastav Buildpacks. Musí být v tomto pořadí
        1. heroku/nodejs
        2. heroku/php
    1. Naconfiguruj VARS 
        * `APP_KEY` ^^ viz .env
        * `AWS_ACCESS_KEY_ID` - access key k S3
        * `AWS_BUCKET` - jmeno AWS bucketu
        * `AWS_DEFAULT_REGION` - region, kde je umisten S3 bucket
        * `AWS_SECRET_ACCESS_KEY` - secret key
        * `AWS_URL` - url s3 bucketu
        * `DB_DATABASE` - použij db name z `CLEARDB_DATABASE_URL`
        * `DB_HOST` - použij host z `CLEARDB_DATABASE_URL`
        * `DB_PASSWORD` - použij pass z `CLEARDB_DATABASE_URL`
        * `DB_PORT` - 3306
        * `DB_USERNAME` - použij username z `CLEARDB_DATABASE_URL` 
        * `FILESYSTEM_DRIVER` - `s3`

V tomto bodu jste ready-to-deploy. V záložce Deploy stačí v sekci Manual deploy stisknout tlačítko a tradá.

#### Více aplikací
Pokud máte více týmů a chcete více aplikací pro každý tým, tak je potřeba applikace dát do tzn. pipeliny. Pokud chceš deployvat různé verze, tak pro každý tým musíš vytvořit samostatnou branch. Pokud Ti to je jedno, stačí Ti `master` branch.


1. V záložce Deploy je - Connect to Pipeline 
1. Vytvoř novou pipeline - vyber třeba Staging.
1. Poté je Tvá applikace vidět ve sloupečku STAGING. 
1. Tvá aplikace je aktivní a ve sloupci STAGING lze přidat novou aplikaci.
1. Pro ni opět nastav stejné VARS a addons (Cleardb) jak v krocích pro deploy jedné aplikace.
1. Vyber si, z jaké branche by se měla deployvat. 
1. Opakuj tyto kroky pro každý tým co máš.
1. `Optional` _- můžeš nastavit Review apps_
    1. Review app se automaticky vytvoří pro Pull request do jakékoliv branche.
    2. Pokud chceš tuto funkcionalitu využít, je potřeba ji zapnout a nastavit v Settings pipeline VARS. 
    3. Hodí se, pokud chcete učit nějaké flow, kdy QA může otestovat aplikaci ještě před mergem do hlavní branche.