<?php
/**
 * Class AccountManagerModel
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
class AccountManagerModel extends AccountModel{

    public static function getAccountList($limit, $offset=0, $filter){

        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM account";

        $condition = array();
        $arguments = array();

        if(!empty($filter['keywords'])){

            $filter['keywords'] = explode(' ', $filter['keywords']);

            foreach($filter['keywords'] as $keyword){

                if(!empty($keyword)){

                    $condition[] = '(acc_id=? OR first_name LIKE ? OR last_name LIKE ? OR gender=? OR nickname LIKE ? OR username LIKE ? OR email LIKE ? OR mobile_phone LIKE ? OR last_logged_ip LIKE ?)';

                    $arguments[] = $keyword;
                    $arguments[] = '%'.$keyword.'%';
                    $arguments[] = '%'.$keyword.'%';
                    $arguments[] = $keyword;
                    $arguments[] = '%'.$keyword.'%';
                    $arguments[] = '%'.$keyword.'%';
                    $arguments[] = '%'.$keyword.'%';
                    $arguments[] = '%'.$keyword.'%';
                    $arguments[] = '%'.$keyword.'%';
                }
            }
        }

        if(!empty($filter['from'])){

            $condition[] = 'DATE(created_at)>?';
            $arguments[] = $filter['from'];
        }

        if(!empty($filter['to'])){

            $condition[] = 'DATE(created_at)<?';
            $arguments[] = $filter['to'];
        }

        if(!empty($filter['role'])){

            $condition[] = 'role=?';
            $arguments[] = $filter['role'];
        }

        $condition[] = "deleted<>'Yes'";

        $condition = implode(' AND ', $condition);

        if(!empty($condition)){

            $query .= ' WHERE '.$condition;
        }

        if($filter['order_by']=='full_name'){

            $order = "first_name {$filter['dir']}, last_name {$filter['dir']}";
        }
        else{

            $order = "{$filter['order_by']} {$filter['dir']}";
        }

        $query .= " ORDER BY {$order}";

        if(is_numeric($limit) && is_numeric($offset)){

            $query .= " LIMIT {$offset}, {$limit}";
        }

        return Locator::getAdo()->getAll($query, $arguments);
    }
}
