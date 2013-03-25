<?php
/**
 * Smarty plugin
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
 *
 *
 * Smarty {widgets} function plugin
 *
 * Type:     function<br>
 * Name:     widgets<br>
 * Purpose:  display different widgets connected to route in configuration files
 *
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */
function smarty_function_widgets($params, $template)
{
    if(!isset($params['area']) || empty($template->tpl_vars['__view']->value['widgets'][$params['area']])
            || !is_array($template->tpl_vars['__view']->value['widgets'][$params['area']])){

        if(!empty($params['assign'])){

            $template->assign($params['assign'], '');
        }

        return '';
    }

    $output = Joodee::fetchWidgets($template->tpl_vars['__view']->value['widgets'][$params['area']]);

    if(!empty($output)){

        if(!empty($params['prefix'])){

            $output = $params['prefix'] . $output;
        }

        if(!empty($params['suffix'])){

            $output .= $params['suffix'];
        }
    }

    if(empty($params['assign'])){

        return $output;
    }
    else{

        $template->assign($params['assign'], $output);

        return '';
    }
}
