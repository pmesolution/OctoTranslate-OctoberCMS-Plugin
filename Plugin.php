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
<?php namespace Pmesolution\Translate;
use Backend;
use System\Classes\PluginBase;
use Pmesolution\Translate\Models\Ocstring as LangString;
use Pmesolution\Translate\Models\Language as Language;
use Pmesolution\Translate\Classes\TranslatePage;
use Pmesolution\Blog\Models\Post;
use Event;
use Request;
use Input;
use Session;

/**
 * translate Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */

    public function boot(){

        //load additional css for backend
        Event::listen('backend.page.beforeDisplay', function($c,  $a , $p){
            $c->addCss('/plugins/pmesolution/translate/assets/css/admin.css');
        });

        //add language column for blog list in the backend
        Event::listen('backend.list.extendColumns', function ($widget) {
            // Only for the Posts controller
            if (( ! $widget->getController() instanceof \Pmesolution\Blog\Controllers\Post)) {
                return;
            }

            $widget->addColumns([
                'language' => [
                'label' => 'pmesolution.translate::lang.blog.language',
                'type'  => 'text'
                ],
            ]);
        });

        Event::listen('backend.list.extendColumns', function ($widget) {
            // Only for the Posts controller
            if (( ! $widget->getController() instanceof \Pmesolution\Blog\Controllers\Category)) {
                return;
            }

            $widget->addColumns([
                'language' => [
                'label' => 'pmesolution.translate::lang.blog.language',
                'type'  => 'text'
                ],
            ]);
        });



         Event::listen('cms.page.beforeDisplay', function($controller, $fileName) {
            return TranslatePage::handle($controller, $fileName);
         });

         Event::listen('cms.page.beforeDisplay', function($controller, $fileName) {


            if ($fileName != 'blog'){
                return ;
            }

            if($lang = Input::get('lang')){
                  $lang = Language::where('lang_key' ,$lang )->first();
                  Session::put('lang_id', $lang->id);
            }else {
                $id = Session::get('lang_id') == null ? 1 : Session::get('lang_id');
                Session::put('lang_id' , $id);
            }


         });

         Event::listen('backend.filter.extendScopes', function ($widget) {
            if (( ! $widget->getController() instanceof Pmesolution\Translate\Models\Ocstring)) {
                return;
            }

            $languages = Language::all();
               $available_lang = array();
                        foreach ($languages as $language){
                            $available_lang[$language->id] = $language->name;

                        }

            $widget->addScopes([
                'Language' => [
                'label'      => 'Filter language',
                'type'       => 'group',
                'scope'      => 'Language',
                'options'    => $available_lang 
                ],
            ]);

        });

        \Pmesolution\Blog\Models\Post::extend(function($model) {
            $model->bindEvent('model.beforeSave', function() use ($model) {
                $lang = Language::where('id', $model->lang_id)->first();
                $model->language = $lang->name;
            });
        });

        \Pmesolution\Blog\Models\Category::extend(function($model) {
            $model->bindEvent('model.beforeSave', function() use ($model) {
                $lang = Language::where('id', $model->lang_id)->first();
                $model->language = $lang->name;
            });
        });

        \Cms\Classes\Page::extend(function($controller){
        	$controller->bindEvent('page.pageUrl', function($url){
        		return $url.'dddddddd';
        	});
        });


    }

    public function register(){
        
                Event::listen('backend.form.extendFields', function($widget ) {
                    if (!$widget->model instanceof \Cms\Classes\Page) return;
                        $languages = Language::all();

                        foreach ($languages as $language){
                            if($language->default == false){

                                $fields['settings[meta_title_'.$language->lang_key.']'] = [
                                    'label' => 'Meta Title '.strtoupper($language->lang_key),
                                    'tab' => 'Meta '.strtoupper($language->lang_key),
                                ];

                                $fields['settings[meta_description_'.$language->lang_key.']'] = [
                                    'label' => 'Description '.strtoupper($language->lang_key),
                                    'type' => 'textarea',
                                    'tab' => 'Meta '.strtoupper($language->lang_key),
                                ];
                            }
                        }
                        $widget->addFields( $fields, 'primary');
              });

              Event::listen('backend.form.extendFields', function($widget) {
                    if (( ! $widget->getController() instanceof \Pmesolution\Blog\Controllers\Category)) {
                        return;
                    }
                    $languages = Language::all();
                       $available_lang = array();
                                foreach ($languages as $language){
                                    $available_lang[$language->id] = $language->name;
                                }

                    $widget->addFields([
                        'lang_id' => ['label' => 'Language', 'type' => 'dropdown', 'options' => $available_lang ],
                    ]);
              });
              
              Event::listen('backend.form.extendFields', function($widget) {
                    if (( ! $widget->getController() instanceof \Pmesolution\Blog\Controllers\Post)) {
                        return;
                    }
                    $languages = Language::all();
                       $available_lang = array();
                                foreach ($languages as $language){
                                    $available_lang[$language->id] = $language->name;
                                }

                    $widget->addFields([
                        'lang_id' => ['label' => 'Language', 'type' => 'dropdown', 'options' => $available_lang ],
                        'meta_title' => ['label' => 'pmesolution.translate::lang.meta.title_label', 'type' => 'text' ],
                        'meta_description' => ['label' => 'pmesolution.translate::lang.meta.description_label', 'type' => 'text' ],
                    ], 'primary');
              });

    }


    public function pluginDetails()
    {
        return [
            'name'        => 'pmesolution.translate::lang.plugin.name',
            'description' => 'pmesolution.translate::lang.plugin.description',
            'author'      => 'pmesolution',
            'icon'        => 'icon-leaf'
        ];
    }



    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Pmesolution\Translate\Components\Switcher' => 'Switcher',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'pmesolution.translate.some_permission' => [
                'tab' => 'translate',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {

        return [
            'language' => [
                'label'       => 'pmesolution.translate::lang.menu_item.title',
                'url'         => Backend::url('pmesolution/translate/language'),
                'icon'        => 'icon-language',
                'permissions' => ['pmesolution.ocstringtranslate.*'],
                'order'       => 500,
            ],
        ];
    }

    public function registerMarkupTags(){
        return [
            'filters' => [
                'l' =>[$this, 'translateText'] ,
                
            ],
            'functions' => ['getlang' => [$this, 'getlang']],
        ];
    }

    public function getlang(){
        $id = Session::get('lang_id') == null ? 1 : Session::get('lang_id');
        $language = Language::where('id', $id)->first();
        return $language;
    }

    public function translateText($text){

        if($this->checklang()){
            $session= Session::get('lang_id');
            $currentpage = Request::getUri();

            $current_lang = ($session != null)?$session : 1;

            $languages = Language::all();
            $translated = array();

            foreach($languages as $language){
                //get key from database if exists
                
                $r= LangString::where('key', $text)->where('lang_id', $language->id)->first();

                if(!isset($r)){
                    //create new key with default value
                    $string = new LangString;
                    $string->key        = $text;
                    $string->lang_id    = $language->id;
                    $string->lang_key   = $language->lang_key;
                    $string->value      = $text;
                    $string->save();
                    $translated[$language->id] = $text;
                }else {
                    $decoded = json_decode( $r);
                    $translated[$language->id] = $decoded->value;
                }
            }

            return $translated[$current_lang];
        }else {
            return $text;
        }
    }

    public function checklang(){
        //test if any language is installed and activated
        $first = Language::where('id' , 1)->first(); 
        if(isset($first)){
            return true;
        }else{
            return false;
        }
    }
}
