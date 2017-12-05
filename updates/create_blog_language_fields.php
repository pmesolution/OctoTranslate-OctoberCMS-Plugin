<?php
use October\Rain\Database\Updates\Migration;

class CreateBlogLanguageFields extends Migration
{

    public function up()
    {
        Schema::table('pmesolution_blog_posts', function ($table) {
            $table->text('lang_id')
                  ->default(null)
                  ->nullable();

            $table->text('language')
                  ->default(null)
                  ->nullable();

            $table->text('meta_title')
                ->default(null)
                ->nullable();
            $table->text('meta_description')
                ->default(null)
                ->nullable();
        });
    }


    public function down()
    {/*
        Schema::table('pmesolution_blog_posts', function ($table) {
            $table->dropColumn('lang_id');
            //$table->dropColumn('language');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
     */
    }
}
