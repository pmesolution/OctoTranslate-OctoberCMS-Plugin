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
<?php namespace Pmesolution\Translate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateLanguagesTable extends Migration
{

    public function up()
    {
        Schema::create('pmesolution_translate_languages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('default')->default(false);
            $table->string('lang_key');
            $table->string('name');
            $table->string('hreflang');
            $table->string('locale');

        });
    }

    public function down()
    {
        Schema::dropIfExists('pmesolution_translate_languages');
    }

}
