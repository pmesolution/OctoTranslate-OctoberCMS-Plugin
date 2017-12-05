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


use Cms\Helpers\Cms;
use Pmesolution\Translate\Models\Language as Language;
use Cms\Classes\Router;
use Cms\Classes\Theme;
use Response;
use Redirect;


//home
Route::get('/{lang_key}' , function($lang){

        $t = Theme::getActiveTheme();
        $router = new Router($t);
        $x = $router->findByUrl($lang);
        if($x == null){
  	        \Pmesolution\Translate\Controllers\Ocstring::translate($lang);
	        return App::make('Cms\Classes\Controller')->run('/');
        }else {
  	        \Pmesolution\Translate\Controllers\Ocstring::translate($lang);
	        return App::make('Cms\Classes\Controller')->run($lang);
        }

})->where('lang_key' , '[a-z]{2}');

/** alternative routes */


Route::get('{lang_key}/{page}', function($lang, $page){

        $t = Theme::getActiveTheme();
        $router = new Router($t);
        $url = $lang.'/'.$page;
        $requested = $router->findByUrl($url);

       
        $default = Language::where('default', 1)->first();


        if($lang == $default->lang_key){
        	return Redirect::to($page);
        }

        if($requested == null){
            \Pmesolution\Translate\Controllers\Ocstring::translate($lang);
            return App::make('Cms\Classes\Controller')->run($page); 
        }else {
            \Pmesolution\Translate\Controllers\Ocstring::translate($lang);
            return App::make('Cms\Classes\Controller')->run($url);
        }
})->where('lang_key' , '[a-z]{2}');
