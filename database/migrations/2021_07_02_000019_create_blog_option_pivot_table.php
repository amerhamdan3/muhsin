<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogOptionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('blog_option', function (Blueprint $table) {
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id', 'option_id_fk_4294492')->references('id')->on('options')->onDelete('cascade');
            $table->unsignedBigInteger('blog_id');
            $table->foreign('blog_id', 'blog_id_fk_4294492')->references('id')->on('blogs')->onDelete('cascade');
        });
    }
}
