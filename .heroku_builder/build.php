<?php

define('LARAVEL_START', microtime(true));

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

function cmdErr($err, $code = 1)
{
    echo "$err\n";
    exit($code);
}

function replacePlaceholders($content, $vars)
{
    return preg_replace_callback('/\$({)?([A-Z0-9_]+)(?(1)}|\b)/', function ($match) use ($vars) {
        [$search,, $variableName] = $match;
        if (isset($vars[$variableName])) {
            return $vars[$variableName];
        }
        return $search;
    }, $content);
}



$cfg = require 'config.php';
$sampleEnv = @file_get_contents('.env.example');
if (empty($sampleEnv)) {
    cmdErr('.env.example file does not exist or is empty');
}
$sampleSwagger = @file_get_contents('swagger.yaml.example');
if (empty($sampleSwagger)) {
    cmdErr('swagger.yaml.example file does not exist or is empty');
}

// $sql = '';
$bashPreDeploy = $bashPostDeploy = '';


foreach ($cfg['apps'] as $app) {
    $slug = \Illuminate\Support\Str::slug($app['name']);
    $dbName = $app['dbName'] ?? $slug;

    $subDomain = $slug === '' ? $cfg['app_name_prefix'] : $cfg['app_name_prefix'] . '-' . $slug;
    $kernel->call('key:generate', ['--show' => true]);
    $appKey = trim($kernel->output());

    $apiarySlug = str_replace(['_', '-'], '', $subDomain);

    $vars = array_merge($app['extra-vars'], [
        'APP_SUB_DOMAIN' => $subDomain,
        'APP_SLUG' => $slug,
        'APP_KEY' => $appKey,
        'DB_DATABASE' => $dbName,
        'APIARY_SLUG' => $apiarySlug,
        'APIARY_NAME' => $app['name'] === '' ? $cfg['semester_name'] : $cfg['semester_name'] . ' - ' . $app['name'],
    ]);

    file_put_contents("./output/.{$subDomain}.env", replacePlaceholders($sampleEnv, $vars));
    file_put_contents("./output/.{$subDomain}-swagger.yaml", replacePlaceholders($sampleSwagger, $vars));

    $bashPreDeploy .= <<<EOL
        # Create {$vars['APIARY_NAME']}
        heroku apps:create --region=eu --no-remote {$subDomain}
        heroku pipelines:add --app={$subDomain} --stage=staging {$cfg['pipeline']}

        heroku buildpacks:add heroku/nodejs --app={$subDomain}
        heroku buildpacks:add heroku/php --app={$subDomain}

        cat .{$subDomain}.env | xargs heroku config:set --app={$subDomain}\n\n
        EOL;

    $bashPostDeploy .= "heroku run --app={$subDomain} -- php artisan db:seed --force --class=TestDataSeeder\n";
}

file_put_contents("./output/pre-deploy.sh", $bashPreDeploy);
file_put_contents("./output/post-deploy.sh", $bashPostDeploy);
