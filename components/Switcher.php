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
<?php namespace Pmesolution\Translate\Components;

use Cms\Classes\ComponentBase;
use Pmesolution\Translate\Models\Language;
use Request;
use Session;

class Switcher extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'switcher Component',
            'description' => 'Language swither component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }


    public function links(){

        $list = array();
        $languages = Language::All();

         $session= Session::get('lang_id');
         $default = Language::where('default', 1)->first();
         $current_lang = ($session != null)?$session : $default->id ;

        //parse url to check if language key is already appended
        $uri = Request::getUri();
        $sh = Request::getSchemeAndHttpHost();
        $installpath= Request::getBaseURL();
        $baseUrl = $sh.$installpath;
        $uri = str_replace($baseUrl, '', $uri);
        $paths  = explode('/', $uri );
        
        //rebuilt url structure
        $route= '';
        
        for($i=1 ; $i< count($paths) ; $i++){
            if(strlen($paths[$i]) > 2 ){
                $route.= '/'.$paths[$i];
            }
        }

        foreach ($languages as $l){
            if($l->flag_icon){
                    $bgimg = 'background-image: url(\''.$l->flag_icon->getPath().'\');';
                }else {
                    $bgimg = '';
                }

                if($current_lang != $l['id']){
                    $list[] = array(
                        'url' =>$baseUrl.'/'.$l['lang_key'].$route,
                        'lang' => $l['lang_key'],
                        'bgimg' => $bgimg,
                        'name' => $l['name']
                    );
                }

                
            
        }
        return $list;
    }

}
