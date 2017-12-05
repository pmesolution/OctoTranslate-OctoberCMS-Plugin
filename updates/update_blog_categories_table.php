<?php
use October\Rain\Database\Updates\Migration;

class CreateBlogCategoriesLanguageFields extends Migration
{

    public function up()
    {
        Schema::table('pmesolution_blog_categories', function ($table) {
            $table->text('lang_id')
                  ->default(null)
                  ->nullable();
            $table->text('language')
                ->default(null)
                ->nullable();
        });
    }


    public function down()
    {/*
        Schema::table('pmesolution_blog_categories', function ($table) {
           $table->dropColumn('lang_id');
           $table->dropColumn('language');
        });
     */
    } 

}
