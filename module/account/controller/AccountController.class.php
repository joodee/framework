<?php
/**
 * Class AccountController
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
class AccountController{

    public static function ajaxCheck($accId = null){

        Helper::headerJSON();

        if(!Helper::isAjax() || !Helper::isPost()){

            return 'false';
        }

        if(!empty($_POST['username']) && is_string($_POST['username'])){

            $account = AccountModel::getAccountByUsername($_POST['username'], false, (!empty($accId) && is_numeric($accId))?$accId:null);

            if(empty($account)){

                return 'true';
            }
            else{

                return 'false';
            }
        }
        elseif(!empty($_POST['email']) && is_string($_POST['email'])){

            $account = AccountModel::getAccountByEmail($_POST['email'], false, (!empty($accId) && is_numeric($accId))?$accId:null);

            if(empty($account)){

                return 'true';
            }
            else{

                return 'false';
            }
        }

        return 'false';
    }

    public static function authSuccessRedirect($accountRole){

        $config =& Locator::getConfig();
        $settings =& $config['environment']['module']['account'];

        if(!empty($_POST['redirect']) && is_string($_POST['redirect'])){

            $redirect = $_POST['redirect'];
        }
        else{

            $redirect = '/';

            if(!empty($settings['authentication_success_redirect'])){

                if(is_string($settings['authentication_success_redirect'])){

                    $redirect = $settings['authentication_success_redirect'];
                }
                elseif(is_array($settings['authentication_success_redirect'])){

                    if(isset($settings['authentication_success_redirect'][$accountRole])){

                        $redirect = $settings['authentication_success_redirect'][$accountRole];
                    }
                    elseif(isset($settings['authentication_success_redirect']['default'])){

                        $redirect = $settings['authentication_success_redirect']['default'];
                    }
                }
            }
        }

        Helper::redirect($redirect);
    }

    public static function checkAccountEventHandler(){

        if(!empty($_SESSION['account']['id'])){

            $account = AccountModel::getAccount($_SESSION['account']['id'], true, false);

            if(empty($account)){

                AccountAuthenticationController::logoutAction(array('redirect'=>'/'));
                die();
            }

            if($account['locked']!='No'){

                AccountAuthenticationController::logoutAction(array('redirect'=>'/'));

                Alert::addAlert(AccountIntl::$auth_contact_support_to_unlock, 'error', AccountIntl::$auth_account_locked_out);
            }
            elseif($account['deleted']!='No'){

                AccountAuthenticationController::logoutAction(array('redirect'=>'/'));
            }
            elseif($account['role']!=$_SESSION['account']['role']){

                $_SESSION['account']['role'] = $account['role'];
                Alert::addAlert('', 'info', AccountIntl::$your_account_role_has_changed_title);
                AccountController::authSuccessRedirect($account['role']);
            }
        }
    }

    public static function runScheduledActionsCron(){

        $config = Locator::getConfig();

        if(!empty($config['environment']['module']['account']['schedule_deletion_if_not_activated_x_days'])){

            $recSet = AccountModel::getAccountsActivationExpired($config['environment']['module']['account']['schedule_deletion_if_not_activated_x_days']);

            $foundRows = AccountModel::getFoundRows();

            if($foundRows){

                echo PHP_EOL . 'Account scheduled for deletion: ' . $foundRows;
                echo PHP_EOL . '=============================================';

                while($account = $recSet->FetchRow()){

                    if(AccountModel::updateAccountField($account['acc_id'], 'deletion_scheduled_at', date('Y-m-d H:i:s'))){

                        echo PHP_EOL . $account['acc_id'] . '. ' . $account['username'] . ', ' . $account['email'];
                    }
                }

                echo PHP_EOL . '=============================================' . PHP_EOL . PHP_EOL;
            }
        }

        if(!empty($config['environment']['module']['account']['delete_if_scheduled_x_days'])){

            $recSet = AccountModel::getAccountsScheduledForDeletionNrOfDays(
                (integer) $config['environment']['module']['account']['delete_if_scheduled_x_days'],
                (bool) $config['environment']['module']['account']['delete_expired_accounts_physically']
            );

            $foundRows = AccountModel::getFoundRows();

            if($foundRows){

                if((bool) $config['environment']['module']['account']['delete_expired_accounts_physically']){

                    echo PHP_EOL . 'Physically deleted accounts in ['.$config['connection']['adodb']['default']['database'].']: ' . $foundRows;
                }
                else{

                    echo PHP_EOL . 'Marked as deleted accounts in ['.$config['connection']['adodb']['default']['database'].']: ' . $foundRows;
                }

                echo PHP_EOL . '============================================================';

                while($account = $recSet->FetchRow()){

                    echo PHP_EOL . var_export($account, true) . ',';
                    AccountModel::deleteAccount($account['acc_id'], (bool) $config['environment']['module']['account']['delete_expired_accounts_physically']);
                }

                echo PHP_EOL . '============================================================' . PHP_EOL . PHP_EOL;
            }
        }
    }
}
