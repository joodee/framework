<?php
/**
 * Class SetupController
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
class SetupController{

    public static function checkSettingsAction(){

        static $rerouted = false;

        if(!$rerouted){

            $rerouted = true;

            return Helper::reroute('/');
        }


        $config =& Locator::getConfig();

        $settings = array(
            'directories' => array('label' => 'Writable directories', 'status' => 'Ok', 'errors' => array()),
            'configuration' => array('label' => 'Configuration files', 'status' => 'Ok', 'errors' => array()),
            'connection' => array('label' => 'Database connection', 'status' => 'Ok', 'errors' => array()),
            'database' => array('label' => 'Database tables', 'status' => 'Ok', 'errors' => array()),
            'domain' => array('label' => 'Domain name', 'status' => 'Ok', 'errors' => array()),
            'htaccess' => array('label' => '.htaccess', 'status' => 'Ok', 'errors' => array()),
        );

        $notes = array();

        if(!is_writable($config['path']['data'])){

            $settings['directories']['errors'][] = sprintf("Directory [ %s ] is not writable.", $config['path']['data']);
        }
        else{

            try {

                $fileSPLObjects =  new RecursiveIteratorIterator(new RecursiveDirectoryIterator($config['path']['data']), RecursiveIteratorIterator::SELF_FIRST);

                foreach($fileSPLObjects as $fullFileName => $fileSPLObject) {

                    if($fileSPLObject->isDir() && !in_array($fileSPLObject->getFilename(), array('.', '..'))) {

                        if(!is_writable($fullFileName)){

                            $settings['directories']['errors'][] = sprintf("Directory [ %s ] is not writable.", $fullFileName);
                        }
                    }
                }
            }
            catch (UnexpectedValueException $e) {

                $settings['directories']['errors'][] = sprintf("Directory [ %s ] is not readable.", $config['path']['data']);
            }
        }


        if(empty($config['connection'])){

            $settings['configuration']['errors'][] = 'Connection settings not found, please check [ ~/config/connection.config.php ] file.';
        }

        if(empty($config['environment']['global']['project_name'])){

            $settings['configuration']['errors'][] = 'Framework configuration not found, please check [ ~/config/joodee.config.php ] file.';
        }

        if(empty($config['routes']['/']['terms-of-service/'])){

            $settings['configuration']['errors'][] = 'Demo project configuration not found, please check [ ~/config/module/*_demo.config.php ] file.';
        }

        if(empty($config['routes']['/']['logout/'])){

            $settings['configuration']['errors'][] = 'Account module configuration not found, please check [ ~/config/module/*_account.config.php ] file.';
        }

        if(empty($config['routes']['/']['captcha/'])){

            $settings['configuration']['errors'][] = 'Captcha module configuration not found, please check [ ~/config/module/*_captcha.config.php ] file.';
        }


        if(empty(Locator::getAdo()->_connectionID)){

            $settings['connection']['errors'][] = 'Database connection error, please check settings in [ ~/config/connection.config.php ] file.';
            $settings['database']['status'] = 'Fail';
        }

        if(empty($settings['connection']['errors'])){

            if(!$databaseExists = SetupModel::databaseExists($config['connection']['adodb']['default']['database'])){

                if(empty($config['connection']['adodb']['default']['database'])){

                    $settings['database']['errors'][] = 'Database name not set, please check [ ~/config/connection.config.php ] file.';
                }
                else{

                    $databaseExists = SetupModel::createDatabase($config['connection']['adodb']['default']['database']);

                    if($databaseExists){

                        $notes[] = "New database [ {$config['connection']['adodb']['default']['database']} ] created.";
                    }
                    else{

                        $settings['database']['errors'][] = "Unable to create database with [ {$config['connection']['adodb']['default']['database']} ] name.";
                    }
                }
            }

            if($databaseExists){

                if(!SetupModel::tableExists('account')){

                    $queries = explode(';', file_get_contents(__ROOT__ . '/install/account/tables.mysql.sql'));

                    $errorOccurred = false;

                    foreach($queries as $query){

                        $query = trim($query);

                        if(!empty($query)){

                            Locator::getAdo()->Execute($query);

                            if(Locator::getAdo()->ErrorNo()){

                                $settings['database']['errors'][] = "Unable to create tables in [ {$config['connection']['adodb']['default']['database']} ] database.";
                                $errorOccurred = true;
                                break;
                            }
                        }
                    }

                    if(!$errorOccurred){

                        $notes[] = "Tables [ account ] and [ account_activity ] created in [ {$config['connection']['adodb']['default']['database']}]  database.";
                    }
                }
            }
        }

        if(empty($_SERVER['SERVER_SOFTWARE']) || strpos(strtolower($_SERVER['SERVER_SOFTWARE']), 'apache')===false){

            unset($settings['htaccess']);
        }
        elseif(!file_exists($config['path']['public'].'/.htaccess')){

            $settings['htaccess']['errors'][] = 'File [ ~/public/.htaccess ] not found.';
        }


        if(strpos(getenv('HTTP_HOST'), '.')===false){

            $settings['domain']['errors'][] = 'Domain name is not fully qualified, top level domain name (dot "." character) required, e.g. "example.com".';
        }

        $errors = array();

        foreach($settings as $key=>$item){

            if(!empty($item['errors'])){

                $errors = array_merge($errors, $item['errors']);
                $settings[$key]['status'] = 'Fail';
            }
        }

        if(empty($errors)){

            Alert::addAlert("The last step, you should disable this check, please delete [ ~/config/module/9999_setup.config.php ] configuration file.", 'success', 'You have successfully set up Joodee Framework.');
        }
        else{

            Alert::addAlert($errors, 'warning', 'Warning!');
        }

        if(!empty($notes)){

            Alert::addAlert($notes, 'info', 'Note!');
        }

        Locator::getSmarty()->assign('settings', $settings);

        return Locator::getSmarty()->fetch('page_setup.tpl');
    }
}
