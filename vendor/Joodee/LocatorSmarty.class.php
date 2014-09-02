<?php
/**
 * Class LocatorSmarty
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
class LocatorSmarty{

    protected static $instance;

    /**
     * @static
     * @return SmartyWrapper
     */
    public static function getInstance($module){

        if(is_null(self::$instance)){

            $config = Locator::getConfig();

            include_once $config['path']['vendor'].'/Smarty/libs/Smarty.class.php';

            self::$instance = new SmartyWrapper();
        }

        self::$instance->asset_module_dir = $module;

        return self::$instance;
    }

    private function __construct() {}

    private function __clone() {}

    private function __wakeup() {}

}
