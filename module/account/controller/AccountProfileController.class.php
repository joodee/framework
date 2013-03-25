<?php
/**
 * Class AccountProfileController
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
class AccountProfileController{

    public static function editAction(){

        if(empty($_SESSION['account']['id'])){

            Alert::addAlert(AccountIntl::$you_should_be_logged_in_for_this_action, 'error', AccountIntl::$access_denied);
            return '';
        }

        $profile = AccountModel::getAccount($_SESSION['account']['id'], true, true);

        $profile['birthday_day'] = substr($profile['birthday'], 8, 2);
        $profile['birthday_month'] = substr($profile['birthday'], 5, 2);
        $profile['birthday_year'] = substr($profile['birthday'], 0, 4);

        $timeZone = explode('/', $profile['timezone']);

        if(isset(TimeZoneList::$items[$timeZone[0]])){

            $profile['timezone_area'] = $timeZone[0];
        }
        elseif(in_array($profile['timezone'], TimeZoneList::$items['Other'])){

            $profile['timezone_area'] = 'Other';
        }
        else{

            $profile['timezone_area'] = '';
        }

        if(Helper::isPost()){

            $rules = array(
                'nickname' => array(
                    'required' => AccountIntl::$validation_nickname_required,
                    'length_max|32' => AccountIntl::$validation_nickname_length_max,
                ),
                'first_name' => array(
                    'required' => AccountIntl::$validation_first_name_required,
                    'length_max|32' => AccountIntl::$validation_first_name_length_max,
                ),
                'last_name' => array(
                    'required' => AccountIntl::$validation_last_name_required,
                    'length_max|32' => AccountIntl::$validation_last_name_length_max,
                ),
                'birthday_day' => array(
                    'required' => AccountIntl::$validation_birthday_date_required,
                    'number' => AccountIntl::$validation_birthday_date_not_valid,
                    'range|1:31' => AccountIntl::$validation_birthday_date_not_valid,
                ),
                'birthday_month' => array(
                    'required' => AccountIntl::$validation_birthday_month_required,
                    'number' => AccountIntl::$validation_birthday_month_not_valid,
                    'range|1:12' => AccountIntl::$validation_birthday_month_not_valid,
                ),
                'birthday_year' => array(
                    'required' => AccountIntl::$validation_birthday_year_required,
                    'number' => AccountIntl::$validation_birthday_year_not_valid,
                    'range|'.(date('Y')-120).':'.date('Y') => AccountIntl::$validation_birthday_year_not_valid,
                ),
                'gender' => array(
                    'required' => AccountIntl::$validation_gender_required,
                    'in|Male,Female,Other' => AccountIntl::$validation_gender_not_in_list,
                ),
                'mobile_phone' => array(
                    'required' => AccountIntl::$validation_mobile_phone_required,
                    'length_range|11:14' => AccountIntl::$validation_mobile_phone_length_range,
                    '/^[\+][0-9]+$/' => AccountIntl::$validation_mobile_phone_regexp,
                ),
                'email' => array(
                    'required' => AccountIntl::$validation_email_required,
                    'email|checkdnsrr' => AccountIntl::$validation_email_invalid,
                    'length_max|64' => AccountIntl::$validation_email_length
                ),
                'location_iso2' => array(
                    'required' => AccountIntl::$validation_location_required,
                ),
                'timezone_area' => array(
                    'required' => AccountIntl::$validation_timezone_required,
                ),
                'timezone_value' => array(
                    'required' => AccountIntl::$validation_timezone_required,
                ),
            );

            $errors = array();

            if(!Validator::check($_POST, $rules)){

                $errors = array_merge($errors, Validator::getErrors());
            }

            if(empty($errors['email'])){

                $foundAccount = AccountModel::getAccountByEmail($_POST['email'], false);

                if(!empty($foundAccount) && $foundAccount['acc_id']!=$_SESSION['account']['id']){

                    $errors['email'] = AccountIntl::$validation_email_in_use;
                }
            }

            if(empty($errors['location_iso2'])){

                if(!isset(CountryList::$items[$_POST['location_iso2']])){

                    $errors['location_iso2'] = AccountIntl::$validation_location_unknown;
                }
            }

            if(empty($errors['timezone_area']) && empty($errors['timezone_value'])){

                if(!isset(TimeZoneList::$items[$_POST['timezone_area']])){

                    $errors['timezone_area'] = AccountIntl::$validation_timezone_required;
                }
                elseif(!in_array($_POST['timezone_value'], TimeZoneList::$items[$_POST['timezone_area']])){

                    $errors['timezone_value'] = AccountIntl::$validation_timezone_required;
                }
            }

            if(Helper::isDemoRole()){

                $errors['demo'] = AccountIntl::$action_restricted_for_demo_role;
            }

            if(empty($errors)){

                if($_POST['timezone_area']=='Other'){

                    $_POST['timezone'] = $_POST['timezone_value'];
                }
                else{

                    $_POST['timezone'] = $_POST['timezone_area'].'/'.$_POST['timezone_value'];
                }

                $_POST['birthday'] = $_POST['birthday_year'].'-'.sprintf('%02d', $_POST['birthday_month']).'-'.sprintf('%02d', $_POST['birthday_day']);

                $updated = AccountProfileModel::updateProfile($_POST, $_SESSION['account']['id']);

                if($updated){

                    Alert::addAlert(AccountIntl::$profile_updated_successfully_message, 'success', AccountIntl::$profile_updated_successfully_title);

                    $profile = AccountModel::getAccount($_SESSION['account']['id'], true, false);

                    $profile['birthday_day'] = substr($profile['birthday'], 8, 2);
                    $profile['birthday_month'] = substr($profile['birthday'], 5, 2);
                    $profile['birthday_year'] = substr($profile['birthday'], 0, 4);

                    $timeZone = explode('/', $profile['timezone']);

                    if(isset(TimeZoneList::$items[$timeZone[0]])){

                        $profile['timezone_area'] = $timeZone[0];
                    }
                    elseif(in_array($profile['timezone'], TimeZoneList::$items['Other'])){

                        $profile['timezone_area'] = 'Other';
                    }
                    else{

                        $profile['timezone_area'] = '';
                    }
                }
                else{

                    Alert::addAlert('', 'error', AccountIntl::$manager_unknown_error);
                }
            }
            else{

                Locator::getSmarty()->assign('profile_errors', $errors);
                Alert::addAlert($errors, 'error', AccountIntl::$validation_failed);
            }
        }

        if(Helper::isPost() && !empty($errors)){

            $profile = array_merge($_POST, array('timezone'=>$profile['timezone']));
        }

        Locator::getSmarty()->assignByRef('profile', $profile);

        return Locator::getSmarty()->fetch('account_profile.tpl');
    }

    public static function changePasswordAction(){

        $errors = array();

        if(empty($_SESSION['account']['id'])){

            Alert::addAlert(AccountIntl::$you_should_be_logged_in_for_this_action, 'error', AccountIntl::$access_denied);
            return Helper::redirect('/');
        }

        if(Helper::isPost()){

            $rules = array(
                'password_current' => array(
                    'required' => AccountIntl::$validation_password_required
                ),
                'password_new' => array(
                    'required' => AccountIntl::$validation_password_required,
                    'length_min|8' => AccountIntl::$validation_password_length_min,
                    'length_max|32' => AccountIntl::$validation_password_length_max,
                ),
                'password_new_confirm' => array(
                    'required' => AccountIntl::$validation_confirm_password_required,
                    'equals|password_new' => AccountIntl::$validation_passwords_dont_match,
                ),
            );

            $account = AccountModel::getAccount($_SESSION['account']['id']);

            $password = AccountModel::encryptPassword($_POST['password_current'], $account['salt'], $account['algorithm']);

            if(!Validator::check($_POST, $rules)){

                $errors = Validator::getErrors();
                Alert::addAlert($errors, 'error', AccountIntl::$validation_failed);
            }
            elseif($password != $account['password']){

                $errors['password_current'] = AccountIntl::$validation_wrong_password;
            }
            elseif(Helper::isDemoRole()){

                $errors['demo'] = AccountIntl::$action_restricted_for_demo_role;
            }
            else{

                $config =& Locator::getConfig();

                $password = AccountModel::encryptPassword($_POST['password_new'], $account['salt'], $config['environment']['module']['account']['encryption_algorithm']);

                if(AccountModel::updateAccountField($account['acc_id'], 'password', $password)){

                    AccountModel::updateAccountField($account['acc_id'], 'algorithm', $config['environment']['module']['account']['encryption_algorithm']);

                    Locator::getSmarty()->assign('account', $account);

                    $mail = new PHPMailer();
                    $mail->AddAddress($account['email'], $account['first_name'].' '.$account['last_name']);
                    $mail->SetFrom($config['environment']['global']['noreply_email'], $config['environment']['global']['company_name']);
                    $mail->Subject    = AccountIntl::$change_password_success_mail_subject;
                    $mail->AltBody    = AccountIntl::$plain_body_use_html_compatible_email_client;
                    $mail->WordWrap   = $config['environment']['global']['mail_body_word_wrap'];
                    $mail->MsgHTML(Locator::getSmarty()->fetch('mail_body_password_change_success.tpl'));
                    $mail->IsHTML(true);
                    $mail->Send();

                    Alert::addAlert(AccountIntl::$change_password_success_message, 'success', AccountIntl::$change_password_success_message_title);
                }
                else{

                    Alert::addAlert(AccountIntl::$error_unknown_message, 'error', AccountIntl::$error_occurred_title);
                }
            }
        }

        if(!empty($errors)){

            Alert::addAlert($errors, 'error', AccountIntl::$validation_failed);
        }

        Locator::getSmarty()->assign('change_password_errors', $errors);

        return Locator::getSmarty()->fetch('password_change.tpl');
    }
}
