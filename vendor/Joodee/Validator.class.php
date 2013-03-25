<?php
/**
 * Class Validator
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
class Validator{

    private static $errors = array();

    public static function check(&$data, &$fields, $trim = true, $childClassName = null){

        self::$errors = array();
        $result = true;

        foreach($fields as $fieldName=>$field){

            if(!isset($data[$fieldName])){

                $data[$fieldName] = null;
            }

            foreach($field as $rule=>$message){

                if($rule{0} == '/'){

                    if(!is_null($data[$fieldName])){

                        if(!is_string($data[$fieldName])){

                            if(!is_numeric($data[$fieldName])){

                                self::$errors[$fieldName] = 'Invalid data type';
                                $result = false;
                                break;
                            }

                            $data[$fieldName] = (string) $data[$fieldName];
                        }

                        if($trim){

                            $data[$fieldName] = trim($data[$fieldName]);
                        }

                        if($data[$fieldName] === ''){

                            continue;
                        }

                        if(!preg_match($rule, ($trim ? trim($data[$fieldName]) : $data[$fieldName]))){

                            if(is_null($message)){

                                self::$errors[$fieldName] = 'Invalid value';
                            }
                            else{

                                self::$errors[$fieldName] = $message;
                            }

                            $result = false;
                            break;
                        }
                    }
                }
                else{

                    $rule = explode('|', $rule);
                    $method = 'rule_'.$rule[0];
                    $args = isset($rule[1])?explode(':', $rule[1]):array();

                    if(is_null($childClassName)){

                        $error = self::$method($data, $fieldName, $trim, $args);
                    }
                    else{

                        // If PHP 5.3+
                        //$error = $childClassName::$method($data, $fieldName, $trim, $args);
                        $error = call_user_func(array($childClassName, $method), $data, $fieldName, $trim, $args);
                    }

                    if($error){

                        if(is_null($message)){

                            self::$errors[$fieldName] = $error;
                        }
                        else{

                            self::$errors[$fieldName] = $message;
                        }

                        $result = false;
                        break;
                    }
                }
            }
        }

        return $result;
    }

    public static function getErrors(){

        return self::$errors;
    }

    private static function rule_required(&$data, $fieldName, $trim, $args){

        if(!is_null($data[$fieldName])){

            if(!empty($args[0]) && strtolower($args[0])=='array'){

                if(!is_array($data[$fieldName])){

                    return 'Invalid data type';
                }

                if(empty($data[$fieldName])){

                    return 'Required field';
                }
                else{

                    return '';
                }
            }

            if(!is_string($data[$fieldName])){

                if(!is_numeric($data[$fieldName])){

                    return 'Invalid data type';
                }

                $data[$fieldName] = (string) $data[$fieldName];
            }

            if($trim){

                $data[$fieldName] = trim($data[$fieldName]);
            }

            if(!empty($data[$fieldName]) || is_numeric($data[$fieldName])){

                return '';
            }
        }

        return 'Required field';
    }

    private static function rule_numeric(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(!is_string($data[$fieldName])){

            if(!is_numeric($data[$fieldName])){

                return 'Invalid data type';
            }

            $data[$fieldName] = (string) $data[$fieldName];
        }

        if($trim){

            $data[$fieldName] = trim($data[$fieldName]);
        }

        if($data[$fieldName] === '' || is_numeric($data[$fieldName])){

            return '';
        }

        return 'Numeric value required';
    }

    private static function rule_number(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(!is_string($data[$fieldName])){

            if(!is_numeric($data[$fieldName])){

                return 'Invalid data type';
            }

            $data[$fieldName] = (string) $data[$fieldName];
        }

        if($trim){

            $data[$fieldName] = trim($data[$fieldName]);
        }

        if($data[$fieldName] === ''){

            return '';
        }

        if(preg_match('/^[0-9]{1,128}$/', $data[$fieldName])){

            return '';
        }

        return 'Invalid number';
    }

    private static function rule_id(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(!is_string($data[$fieldName])){

            if(!is_numeric($data[$fieldName])){

                return 'Invalid data type';
            }

            $data[$fieldName] = (string) $data[$fieldName];
        }

        if($trim){

            $data[$fieldName] = trim($data[$fieldName]);
        }

        if($data[$fieldName] === ''){

            return '';
        }

        if(preg_match('/^[0-9]{1,128}$/', $data[$fieldName]) && $data[$fieldName] > 0){

            return '';
        }

        return 'Invalid number';
    }

    private static function rule_string(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(is_string($data[$fieldName]) || is_numeric($data[$fieldName])){

            if($trim){

                $data[$fieldName] = trim($data[$fieldName]);
            }

            return '';
        }

        return 'Value is not a string';
    }

    private static function rule_array(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName]) || is_array($data[$fieldName])){

            return '';
        }

        return 'Array expected';
    }

    private static function rule_length_min(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(!isset($args[0]) || !is_numeric($args[0])){

            return "Invalid rule, valid example: 'length_min|8'";
        }

        if(!is_string($data[$fieldName])){

            if(!is_numeric($data[$fieldName])){

                return 'Invalid data type';
            }

            $data[$fieldName] = (string) $data[$fieldName];
        }

        if($trim){

            $data[$fieldName] = trim($data[$fieldName]);
        }

        if($data[$fieldName] === ''){

            return '';
        }

        if(mb_strlen($data[$fieldName], 'UTF-8') >= $args[0]){

            return '';
        }

        return "Minimum {$args[0]} characters allowed";
    }

    private static function rule_min(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(!isset($args[0]) || !is_numeric($args[0])){

            return "Invalid rule, valid example: 'min|2'";
        }

        if(!is_string($data[$fieldName])){

            if(!is_numeric($data[$fieldName])){

                return 'Invalid data type';
            }

            $data[$fieldName] = (string) $data[$fieldName];
        }

        if($trim){

            $data[$fieldName] = trim($data[$fieldName]);
        }

        if($data[$fieldName] === ''){

            return '';
        }

        if($data[$fieldName] >= $args[0]){

            return '';
        }

        return "Value should be higher than {$args[0]}";
    }

    private static function rule_length_max(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(!isset($args[0]) || !is_numeric($args[0])){

            return "Invalid rule, valid example: 'length_max|32'";
        }

        if(!is_string($data[$fieldName])){

            if(!is_numeric($data[$fieldName])){

                return 'Invalid data type';
            }

            $data[$fieldName] = (string) $data[$fieldName];
        }

        if($trim){

            $data[$fieldName] = trim($data[$fieldName]);
        }

        if($data[$fieldName] === ''){

            return '';
        }

        if(mb_strlen($data[$fieldName], 'UTF-8') <= $args[0]){

            return '';
        }

        return "Maximum {$args[0]} characters allowed";
    }

    private static function rule_max(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(!isset($args[0]) || !is_numeric($args[0])){

            return "Invalid rule, valid example: 'min|2'";
        }

        if(!is_string($data[$fieldName])){

            if(!is_numeric($data[$fieldName])){

                return 'Invalid data type';
            }

            $data[$fieldName] = (string) $data[$fieldName];
        }

        if($trim){

            $data[$fieldName] = trim($data[$fieldName]);
        }

        if($data[$fieldName] === ''){

            return '';
        }

        if($data[$fieldName] >= $args[0]){

            return '';
        }

        return "Value should be lower than {$args[0]}";
    }

    private static function rule_length_range(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(!isset($args[0]) || !is_numeric($args[0]) || !isset($args[1]) || !is_numeric($args[1])){

            return "Invalid rule, valid example: 'length_range|8:32'";
        }

        if(!is_string($data[$fieldName])){

            if(!is_numeric($data[$fieldName])){

                return 'Invalid data type';
            }

            $data[$fieldName] = (string) $data[$fieldName];
        }

        if($trim){

            $data[$fieldName] = trim($data[$fieldName]);
        }

        if($data[$fieldName] === ''){

            return '';
        }

        if((mb_strlen($data[$fieldName], 'UTF-8') >= $args[0]) && (mb_strlen($data[$fieldName], 'UTF-8') <= $args[1])){

            return '';
        }

        return "Minimum {$args[0]} and maximum {$args[1]} characters allowed";
    }

    private static function rule_range(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(!isset($args[0]) || !is_numeric($args[0]) || !isset($args[1]) || !is_numeric($args[1])){

            return "Invalid rule, valid example: 'length_range|8:32'";
        }

        if(!is_string($data[$fieldName])){

            if(!is_numeric($data[$fieldName])){

                return 'Invalid data type';
            }

            $data[$fieldName] = (string) $data[$fieldName];
        }

        if($trim){

            $data[$fieldName] = trim($data[$fieldName]);
        }

        if($data[$fieldName] === ''){

            return '';
        }

        if(($data[$fieldName] >= $args[0]) && ($data[$fieldName] <= $args[1])){

            return '';
        }

        return "Allowed value range is [{$args[0]}, {$args[1]}]";
    }

    private static function rule_email(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName])){

            return '';
        }

        if(!is_string($data[$fieldName])){

            return 'Invalid data type';
        }

        if($trim){

            $data[$fieldName] = trim($data[$fieldName]);
        }

        if($data[$fieldName] === ''){

            return '';
        }

        if(preg_match('/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/', $data[$fieldName])){

            if(empty($args[0]) || $args[0] != 'checkdnsrr'){

                return '';
            }

            $parsedUrl = parse_url('http://'.$data[$fieldName]);

            if(!empty($parsedUrl['host']) && checkdnsrr($parsedUrl['host'], empty($args[1])?'MX':strtoupper($args[1]))){

                return '';
            }
        }

        return 'Invalid email address';
    }

    private static function rule_equals(&$data, $fieldName, $trim, $args){

        if(isset($data[$args[0]]) && $data[$fieldName] === $data[$args[0]]){

            return '';
        }

        return 'Fields do not match';
    }

    private static function rule_in(&$data, $fieldName, $trim, $args){

        if(is_null($data[$fieldName]) || (is_string($data[$fieldName]) && $data[$fieldName] === '')){

            return '';
        }

        if(is_string($data[$fieldName]) && isset($args[0])){

            if($trim){

                $data[$fieldName] = trim($data[$fieldName]);
            }

            $args[0] = trim($args[0]);

            if($args[0] !== ''){

                $args[0] = explode(',', $args[0]);

                foreach($args[0] as $value){

                    if($data[$fieldName] == trim($value)){

                        return '';
                    }
                }
            }
        }

        return 'Value not in list';
    }
}
