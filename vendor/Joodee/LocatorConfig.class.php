<?php
/**
 * Class LocatorConfig
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
class LocatorConfig{

    protected static $config;

    public static function &getConfig(){

        return self::$config;
    }

    public static function init(&$bootstrap){

        if($bootstrap['apc_enabled']){

            if(($config = apc_fetch ( $bootstrap['secret'].'_config', $success)) && $success && !empty($config)){

                self::$config =& $config;
                return;
            }

            self::buildConfig($bootstrap);

            apc_store($bootstrap['secret'].'_config', self::$config, self::$config['apc_ttl']);
        }
        else{

            if(is_null($bootstrap['apc_enabled'])){

                apc_delete($bootstrap['secret'].'_config');
            }

            self::buildConfig($bootstrap);
        }
    }

    protected static function buildConfig(&$bootstrap){

        $application = include $bootstrap['path']['config'].'/joodee.config.php';

        $moduleConfigList = scandir($bootstrap['path']['config'].'/module');

        foreach($moduleConfigList as $fileName){

            if(substr($fileName, -11) == '.config.php'){

                $config = include $bootstrap['path']['config'].'/module/'.$fileName;
                $application = self::array_merge_recursive($application, $config);
            }
        }

        $connection  = include $bootstrap['path']['config'].'/connection.config.php';

        self::$config = self::array_merge_recursive($bootstrap, $application, $connection);

        self::extendRoutesRecursive(self::$config['routes']['/']);
    }

    protected static function extendRoutesRecursive(&$root){

        if(isset($root['view']['filter'])){

            if(empty($root['view']['filter'])){

                $root['view']['widgets'] = array();
            }
            else{

                if(!is_array($root['view']['filter'])){

                    $root['view']['filter'] = array($root['view']['filter']);
                }

                foreach($root['view']['filter'] as $filter) {

                    if(is_string($filter) && isset($root['view']['widgets'][$filter])){

                        unset($root['view']['widgets'][$filter]);
                    }
                    elseif(is_array($filter)){

                        foreach($filter as $item){

                            foreach($root['view']['widgets'] as $area=>$widgetList){

                                foreach($widgetList as $key=>$widgetItem){

                                    if(isset($widgetItem['alias']) && $widgetItem['alias'] == $item){

                                        unset($root['view']['widgets'][$area][$key]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            unset($root['view']['filter']);
        }

        if(!empty($root['view']['widgets'])){

            foreach($root['view']['widgets'] as $aKey=>$widgetList){

                $i=1;

                foreach($widgetList as $wKey=>$widget){

                    if(!isset($widget['order'])){

                        $widgetList[$wKey]['order'] = $i++;
                    }

                    if(!empty($widget['private'])){

                        $widgetList[$wKey]['_private'] = true;
                    }
                }

                $root['view']['widgets'][$aKey] = Helper::order($widgetList, 'order', 'asc', 0);
            }
        }

        if(!empty($root['view']['meta'])){

            foreach($root['view']['meta'] as $key=>$item){

                if(!empty($item['private'])){

                    $root['view']['meta'][$key]['_private'] = true;
                }
            }
        }

        if(!empty($root['view']['links'])){

            foreach($root['view']['links'] as $key=>$item){

                if(!empty($item['private'])){

                    $root['view']['links'][$key]['_private'] = true;
                }
            }
        }

        if(!empty($root['view']['scripts'])){

            foreach($root['view']['scripts'] as $key=>$item){

                if(!empty($item['private'])){

                    $root['view']['scripts'][$key]['_private'] = true;
                }
            }
        }

        foreach($root as $cKey=>$node){

            if(substr($cKey, -1)=='/'){

                if(!isset($node['view'])){

                    $root[$cKey]['view'] = $root['view'];
                }
                else{

                    $root[$cKey]['view'] = self::array_merge_recursive($root['view'], $node['view']);
                }

                if(!empty($root[$cKey]['view']['widgets'])){

                    foreach($root[$cKey]['view']['widgets'] as $aKey=>$widgetList){

                        foreach($widgetList as $wKey=>$widget){

                            if(!empty($widget['_private'])){

                                unset($root[$cKey]['view']['widgets'][$aKey][$wKey]);
                            }
                        }
                    }
                }

                if(!empty($root[$cKey]['view']['meta'])){

                    foreach($root[$cKey]['view']['meta'] as $key=>$item){

                        if(!empty($item['_private'])){

                            unset($root[$cKey]['view']['meta'][$key]);
                        }
                    }
                }

                if(!empty($root[$cKey]['view']['links'])){

                    foreach($root[$cKey]['view']['links'] as $key=>$item){

                        if(!empty($item['_private'])){

                            unset($root[$cKey]['view']['links'][$key]);
                        }
                    }
                }

                if(!empty($root[$cKey]['view']['scripts'])){

                    foreach($root[$cKey]['view']['scripts'] as $key=>$item){

                        if(!empty($item['_private'])){

                            unset($root[$cKey]['view']['scripts'][$key]);
                        }
                    }
                }

                self::extendRoutesRecursive($root[$cKey]);
            }
        }


        if(!empty($root['view']['widgets'])){

            foreach($root['view']['widgets'] as $aKey=>$widgetList){

                foreach($widgetList as $wKey=>$widget){

                    if(isset($root['view']['widgets'][$aKey][$wKey]['_private'])){

                        unset($root['view']['widgets'][$aKey][$wKey]['_private']);
                    }
                }
            }
        }

        if(!empty($root['view']['meta'])){

            foreach($root['view']['meta'] as $key=>$item){

                if(isset($item['_private'])){

                    unset($root['view']['meta'][$key]['_private']);
                }
            }
        }

        if(!empty($root['view']['links'])){

            foreach($root['view']['links'] as $key=>$item){

                if(isset($item['_private'])){

                    unset($root['view']['links'][$key]['_private']);
                }
            }
        }

        if(!empty($root['view']['scripts'])){

            foreach($root['view']['scripts'] as $key=>$item){

                if(isset($item['_private'])){

                    unset($root['view']['scripts'][$key]['_private']);
                }
            }
        }
    }

    public static function array_merge_recursive() {

        $arrays = func_get_args();
        $base = array_shift($arrays);

        foreach ($arrays as $array) {

            reset($base);

            while(list($key, $value) = each($array)) {

                if (is_array($value) && isset($base[$key]) && is_array($base[$key])) {

                    if(is_numeric($key)){

                        $base[] = $value;
                    }
                    else{

                        $base[$key] = self::array_merge_recursive($base[$key], $value);
                    }
                }
                else{

                    $base[$key] = $value;
                }
            }
        }

        return $base;
    }
}
