<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentPageOptionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('content_page_option', function (Blueprint $table) {
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id', 'option_id_fk_4294491')->references('id')->on('options')->onDelete('cascade');
            $table->unsignedBigInteger('content_page_id');
            $table->foreign('content_page_id', 'content_page_id_fk_4294491')->references('id')->on('content_pages')->onDelete('cascade');
        });
    }
}
