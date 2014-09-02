<?php
/**
 * Class Alert
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
class Alert{

    /**
     * @static
     * @param mixed $message
     * @param string $template {null, 'success', 'error', 'warning', 'info'}
     * @param string $title
     * @return string
     */
    public static function fetchAlert($message, $template = null, $title = ''){

        if(!in_array($template, array('success', 'error', 'warning', 'info'))){

            $template = 'warning';
        }

        Locator::getSmarty()->assign('alertTitle', $title);
        Locator::getSmarty()->assign('alertMessage', $message);

        return Locator::getSmarty('joodee')->fetch('alert_'.$template.'.tpl');
    }

    /**
     * @static
     * @param mixed $message
     * @param string $template {null, 'success', 'error', 'warning', 'info'}
     * @param string $title
     * @return string
     */
    public static function addAlert($message, $template = null, $title = ''){

        if(!in_array($template, array('success', 'error', 'warning', 'info'))){

            $template = 'warning';
        }

        Locator::getSmarty()->assign('alertTitle', $title);
        Locator::getSmarty()->assign('alertMessage', $message);

        $_SESSION['alerts'][] = Locator::getSmarty('joodee')->fetch('alert_'.$template.'.tpl');
    }

    public static function fetchAll(){

        if(empty($_SESSION['alerts'])){

            return '';
        }

        $result = '';

        foreach($_SESSION['alerts'] as $alert){

            $result .= $alert;
        }

        unset($_SESSION['alerts']);

        return $result;
    }
}
