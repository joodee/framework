<?php
/**
 * Class Autoload
 *
 * Joodee Framework v1.0 - http://www.joodee.org
 * ==========================================================
 *
 * Copyright 2012-2013 Alexandr Zincenco <alex@joodee.org>
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
class Autoload {

    protected static $classMap = array();

    private static $cacheUpdated = false;

    public static function register(){

        spl_autoload_register(array('Autoload', 'loader'));
    }

    public static function loader($className){

        if(file_exists(dirname(__FILE__).'/'.$className.'.class.php')){

            require_once dirname(__FILE__).'/'.$className.'.class.php';
        }
        elseif($route =& Locator::getRoute()
                && (isset(self::$classMap[$className]) || isset(self::$classMap[$className.'.'.$route['view']['lang_iso2']]))){

            $config =& Locator::getConfig();

            self::load($config['path']['module'], $className, $route['view']['lang_iso2']);
        }
        else{

            $config =& Locator::getConfig();
            $route =& Locator::getRoute();

            if(is_null($config['apc_enabled'])){

                apc_delete($config['secret'].'_autoload');

                if(file_exists($config['path']['cache'].'/AutoloadClassMap.cache.php')){

                    unlink($config['path']['cache'].'/AutoloadClassMap.cache.php');
                }
            }

            if($config['apc_enabled']){

                self::$classMap = apc_fetch($config['secret'].'_autoload', $success);

                if($success && (isset(self::$classMap[$className]) || isset(self::$classMap[$className.'.'.$route['view']['lang_iso2']]))){

                    self::load($config['path']['module'], $className, $route['view']['lang_iso2']);
                }
                elseif(file_exists($config['path']['cache'].'/AutoloadClassMap.cache.php')
                            && (self::$classMap = include $config['path']['cache'].'/AutoloadClassMap.cache.php')
                                    && (isset(self::$classMap[$className]) || isset(self::$classMap[$className.'.'.$route['view']['lang_iso2']]))){

                    self::load($config['path']['module'], $className, $route['view']['lang_iso2']);
                    apc_store($config['secret'].'_autoload', self::$classMap, $config['apc_ttl']);
                }
                else{

                    self::updateClassCache($config);

                    if(isset(self::$classMap[$className]) || isset(self::$classMap[$className.'.'.$route['view']['lang_iso2']])){

                        self::load($config['path']['module'], $className, $route['view']['lang_iso2']);
                    }
                }
            }
            elseif(file_exists($config['path']['cache'].'/AutoloadClassMap.cache.php')
                        && (self::$classMap = include $config['path']['cache'].'/AutoloadClassMap.cache.php')
                                && (isset(self::$classMap[$className])) || isset(self::$classMap[$className.'.'.$route['view']['lang_iso2']])){

                self::load($config['path']['module'], $className, $route['view']['lang_iso2']);
            }
            else{

                self::updateClassCache($config);

                if(isset(self::$classMap[$className]) || isset(self::$classMap[$className.'.'.$route['view']['lang_iso2']])){

                    self::load($config['path']['module'], $className, $route['view']['lang_iso2']);
                }
            }
        }
    }

    public static function load($modulePath, $className, $langIso2){

        if(isset(self::$classMap[$className])){

            self::$classMap[$className.'.'.$langIso2] = substr(self::$classMap[$className], 0, -10).".{$langIso2}.class.php";
        }

        if(file_exists($modulePath.'/'.self::$classMap[$className.'.'.$langIso2])){

            require_once $modulePath.'/'.self::$classMap[$className.'.'.$langIso2];
        }
        elseif(isset(self::$classMap[$className]) && file_exists($modulePath.'/'.self::$classMap[$className])){

            require_once $modulePath.'/'.self::$classMap[$className];
        }
        elseif(!self::$cacheUpdated){

            self::updateClassCache(Locator::getConfig());
            self::loader($className);
        }
    }

    public static function updateClassCache(&$config){

        if(self::$cacheUpdated){

            return;
        }

        self::$classMap = array();

        self::buildClassMap($config['path']['module'], strlen($config['path']['module'])+1);

        file_put_contents($config['path']['cache'].'/AutoloadClassMap.cache.php', '<?php return '.var_export(self::$classMap, true).';');

        if($config['apc_enabled']){

            apc_store($config['secret'].'_autoload', self::$classMap, $config['apc_ttl']);
        }

        self::$cacheUpdated = true;
    }

    private static function buildClassMap($dir, $cut=0){

        $result = array();

        $list = scandir($dir);

        foreach($list as $file){

            if($file === '.' || $file === '..') {

                continue;
            }

            if(is_file($dir.'/'.$file)) {

                $result[] = $file;

                if(substr($file, -10) == '.class.php'){

                    self::$classMap[substr($file, 0, -10)] = substr($dir.'/'.$file, $cut);
                }

                continue;
            }

            foreach(self::buildClassMap($dir.'/'.$file, $cut) as $file){

                $result[] = $file;
            }
        }

        return $result;
    }
}
