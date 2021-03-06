<?php
/**
 * index.php
 *
 * Joodee Framework v1.1 - http://www.joodee.org
 * ==========================================================
 *
 * Copyright 2012-2014 Alexandr Zincenco <alex@joodee.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

define('TIME', time());
define('MICROTIME', microtime(true));
define('__ROOT__', dirname(dirname(__FILE__)));

chdir(dirname(__ROOT__));

$config = include __ROOT__ . '/config/bootstrap.config.php';

include $config['path']['vendor'].'/Joodee/Autoload.class.php';

Autoload::register();

LocatorConfig::init($config);

Joodee::run();

if(ini_get('display_errors') || !empty($config['set_exec_time_cookie'])){

    setcookie('ExecTime', round(((microtime(true)-MICROTIME)*1000), 2).' ms', 0, '/', '.'.current(explode(':', getenv('HTTP_HOST'))));
}

Joodee::flush();
