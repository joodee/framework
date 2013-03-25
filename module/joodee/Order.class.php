<?php
/**
 * Class Order
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
class Order {

    public static function link($alias, $name, $direction = 'asc', $linkClass = null, $iconClassAsc = 'icon-chevron-up', $iconClassDesc = 'icon-chevron-down'){

        $route =& Locator::getRoute();

        $href = $route['uri'];

        $query = array();

        foreach($_GET as $key=>$value){

            if(is_numeric($key)){

                $href .= urlencode($value) . '/';
            }
            else{

                $query[$key] = $value;
            }
        }

        $switch = array(
            'asc' => 'desc',
            'desc' => 'asc',
        );

        if(!isset($query['dir']) || !in_array($query['dir'], $switch)){

            $query['dir'] = 'asc';
        }

        $icon = '';

        if(isset($_GET['order_by']) && $_GET['order_by'] == $alias){

            $query['dir'] = $switch[$query['dir']];

            $icon = '<i class="'.($query['dir']=='asc'?$iconClassDesc:$iconClassAsc).'"></i>';
        }
        else{

            $query['dir'] = $direction;
        }

        $query['order_by'] = $alias;

        $href .= '?' . http_build_query($query);

        return '<a href="' . $href . '"' . (is_null($linkClass)?'':' class="'.$linkClass.'"') . '>' . $icon . htmlspecialchars($name) . '</a>';
    }

    public static function getArguments($map, $defaultDirection = 'asc'){

        $defaultDirection = strtolower($defaultDirection);

        if(!in_array($defaultDirection, array('asc', 'desc'))){

            $defaultDirection = 'asc';
        }

        $result = array();

        if(empty($_GET['order_by']) || !isset($map[$_GET['order_by']])){

            $result['order_by'] = current($map);
        }
        else{

            $result['order_by'] = $map[$_GET['order_by']];
        }

        if(isset($_GET['dir'])){

            $result['direction'] = strtolower($_GET['dir']);
        }
        else{

            $result['direction'] = $defaultDirection;
        }

        if(!in_array($result['direction'], array('asc', 'desc'))){

            $result['direction'] = $defaultDirection;
        }

        $result['direction'] = strtoupper($result['direction']);

        return $result;
    }
}