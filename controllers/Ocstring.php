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
use Pmesolution\Translate\Models\Language;
use System\Twig\Loader;
use Config;
use Session;
use Cms\Classes\Theme;
use Cms\Classes\Page;
use Request;
/**
 * Ocstring Back-end Controller
 */
class Ocstring extends Controller
{
    
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Pmesolution.Translate', 'translate', 'ocstring');
    }

    public static function translate($lang_key){
        $result= Language::where('lang_key',$lang_key)->first();

        $decoded = json_decode($result);
           if(isset($decoded)){
            Session::put('lang_id', $decoded->id);
           }else {
                //lang_id doesn't exists;
                $r = Language::where('default', 1)->first();
                $d = json_decode($r);
                //here, the database result define the default language to use
                Session::put('lang_id', $d->id);
           }
    }

    /*
        public function onScan(){
            $currentTheme = Theme::getEditTheme();
            $allPages = Page::listInTheme($currentTheme, true);
            $base_url = $_SERVER['HTTP_ORIGIN'].'/'.Request::getBaseURL().'/';
           
            var_dump($base_url);

            $c = curl_init($base_url);
            curl_exec($c);
            curl_close($c);
            foreach ($allPages as $pg) {
                echo $pg->title . ' : ' . $pg->url;
                if($pg->url != '/404'){
                    $url = $base_url.$pg->url;
                                    
                   $c = curl_init($url);
                   curl_exec($c);
                   curl_close($c);
                    //echo $pg->url;                
                }
            }
        }
    */
}
