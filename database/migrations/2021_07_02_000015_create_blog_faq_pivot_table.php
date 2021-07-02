<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogFaqPivotTable extends Migration
{
    public function up()
    {
        Schema::create('blog_faq', function (Blueprint $table) {
            $table->unsignedBigInteger('faq_id');
            $table->foreign('faq_id', 'faq_id_fk_4293326')->references('id')->on('faqs')->onDelete('cascade');
            $table->unsignedBigInteger('blog_id');
            $table->foreign('blog_id', 'blog_id_fk_4293326')->references('id')->on('blogs')->onDelete('cascade');
        });
    }
}
