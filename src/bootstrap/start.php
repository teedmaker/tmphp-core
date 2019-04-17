<?php

require_once 'errors.php';
require_once 'defines.php';
require_once 'config-env-data.php';

TMPHP\App\Brain::init();

require_once __DIR__ . '/../Helpers/ClassToFunctions.php';

# including routes
require_once 'routes.php';
