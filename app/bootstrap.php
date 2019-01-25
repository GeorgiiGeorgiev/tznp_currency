<?php

// цепляем родительские классы
require_once 'core/DB.php';

require_once 'core/Controller.php';

require_once 'core/Model.php';

require_once 'core/View.php';

require_once 'core/Api.php';

require_once 'core/Route.php';

// цепляем файлы моделей (наверно это неправильно)
require_once 'models/History.php';

require_once 'models/Setting.php';

// попытатся создать стандартные таблицы, записать стандартные настройки
include_once 'migrations/dbCreateHistory.php';

include_once 'migrations/dbCreateSettings.php';

include_once 'migrations/dbSetDefaultSettings.php';

// или удалить таблицы
//include_once 'migrations/dbDropSettings.php';

//include_once 'migrations/dbDropHistory.php';

// парсинг url
Route::start();