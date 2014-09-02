<?php
/**
 * Class SmartyWrapper
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
class SmartyWrapper extends Smarty{

    public $module_dir = null;
    public $asset_module_dir = null;
    public $asset_path = null;

    public function __construct(){

        parent::__construct();

        $config =& Locator::getConfig();

        $this->setTemplateDir($config['path']['module']);
        $this->addPluginsDir($config['path']['vendor'] . '/Joodee/plugins/Smarty');

        $this->setCompileDir($config['path']['data'] . '/templates_c');
        $this->compile_check = constant('Smarty::'.$config['smarty_compile_check']);

        $this->caching = 0;
        $this->cache_lifetime = 0;
    }

    public function resetTemplateDir(){

        $config =& Locator::getConfig();
        $this->setTemplateDir($config['path']['module']);
    }

    public function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null, $display = false, $merge_tpl_vars = true, $no_output_filter = false){

        if(!is_null($this->module_dir) || !is_null($this->asset_module_dir)){

            if(is_null($this->asset_path)){

                $template = ($this->asset_module_dir?$this->asset_module_dir:$this->module_dir).'/view/'.$template;
            }
            else{

                $config =& Locator::getConfig();

                if(file_exists($config['path']['module'].'/'.($this->asset_module_dir?$this->asset_module_dir:$this->module_dir).'/view'.$this->asset_path.'/'.$template)){

                    $template = ($this->asset_module_dir?$this->asset_module_dir:$this->module_dir).'/view'.$this->asset_path.'/'.$template;
                }
                else{

                    $template = ($this->asset_module_dir?$this->asset_module_dir:$this->module_dir).'/view/'.$template;
                }
            }
        }

        return parent::fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
    }

    /**
     * Terminator function
     * Disallows raw output
     * Use 'return Locator::getSmarty()->fetch();'
     * instead of 'Locator::getSmarty()->display();'
     */
    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null){

        // Nothing to do here
    }
}
