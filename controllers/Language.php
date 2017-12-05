<?php
/*
This file is part of PMESolution OctoberCMS Translation plugin.

    PMESolution OctoberCMS Translation plugin is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    PMESolution OctoberCMS Translation plugin is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with PMESolution OctoberCMS Translation plugin.  If not, see <http://www.gnu.org/licenses/>. 2
*/
?>
<?php namespace Pmesolution\Translate\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use DB;
use Pmesolution\Translate\Models\Language as L;
use Input;
use System\Models\File;

//use Pmesolution\Translate\Models\Language as LanguageModel;

/**
 * Language Back-end Controller
 */
class Language extends Controller
{

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    //public $layout = 'custom';

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Pmesolution.Translate', 'translate', 'language');
        BackendMenu::setContext('Pmesolution.Translate.translations', 'translations', 'language');
    }

    public function index(){

        $lang = L::All();
        $this->vars['list'] = $lang;
        parent::index();

    }

    public function onUpdateLang(){
        
        $lang = L::Find(Input::get('id'));

            if($lang instanceof L){
                $lang->lang_key = Input::get('lang_key');
                $lang->name = Input::get('name');
                $lang->locale = Input::get('locale');
                $lang->hreflang = Input::get('hreflang');

                if (Input::hasFile('newflag')) {
                    $lang->flag_icon = Input::file('newflag');
                }

                $lang->save();
            }
    }
}
