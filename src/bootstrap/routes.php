<?php

require_once CORE . 'Control/Route.php';

$filesRoute = glob(BASE . 'app/routes/{*,**/*}.php', GLOB_BRACE);

foreach($filesRoute as $file) {
    require_once $file;
}

Route::findActualRoute();
