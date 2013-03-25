<?php
/**
 * Class Pager
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
class Pager {

    public static function fetch($rowsInCurrentList, $rowsFound=null, $rowsPerPage=20, $page=null){

        if(is_null($page)){

            if(empty($_GET['page'])){

                $page = 1;
            }
            else{

                $page = $_GET['page'];
            }
        }

        $page = abs(intval($page));

        if(empty($page)){

            $page = 1;
        }

        $uri = parse_url($_SERVER['REQUEST_URI']);

        if(empty($uri['path'])){

            $uri['path'] = '/';
        }

        if(!isset($uri['query'])){

            $uri['query'] = '';
        }

        @parse_str($uri['query'], $uri['query']);

        $pager = '<ul class="pager">';

        if($page>1){

            if($page>2 || !is_null($rowsFound)){

                $uri['query']['page'] = 1;
                $pager .= '<li><a href="'.$uri['path'].'?'.http_build_query($uri['query']).'">&lt;&lt;</a></li>';
            }

            $uri['query']['page'] = $page-1;
            $pager .= '<li><a href="'.$uri['path'].'?'.http_build_query($uri['query']).'">&lt;</a></li>';
        }
        else{

            if(!is_null($rowsFound)){

                $pager .= '<li class="disabled"><a>&lt;&lt;</a></li>';
            }

            $pager .= '<li class="disabled"><a>&lt;</a></li>';
        }

        $from = ($page-1)*$rowsPerPage+1;

        $to = $from+$rowsInCurrentList-1;

        $pager .= '<li class="disabled"><a>'.($from.'-'.(is_null($rowsFound)?($to>$from?$to:'0'):($to>$rowsFound?$rowsFound:$to)).(is_null($rowsFound)?'':' / '.intval($rowsFound))).'</a></li>';

        if(is_null($rowsFound) || intval($rowsFound)>$to){

            if(!empty($rowsInCurrentList) && $rowsInCurrentList==$rowsPerPage){

                $uri['query']['page'] = $page+1;
                $pager .= '<li><a href="'.$uri['path'].'?'.http_build_query($uri['query']).'">&gt;</a></li>';
            }
            else{

                $pager .= '<li class="disabled"><a>&gt;</a></li>';
            }


            if(!is_null($rowsFound)){

                if(!empty($rowsInCurrentList)){

                    $uri['query']['page'] = ceil(intval($rowsFound)/$rowsPerPage);
                    $pager .= '<li><a href="'.$uri['path'].'?'.http_build_query($uri['query']).'">&gt;&gt;</a></li>';
                }
                else{

                    $pager .= '<li class="disabled"><a>&gt;&gt;</a></li>';
                }
            }
        }
        else{

            $pager .= '<li class="disabled"><a>&gt;</a></li>';
            $pager .= '<li class="disabled"><a>&gt;&gt;</a></li>';
        }

        $pager .= '</ul>';
        
        return $pager;
    }
}
