<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFaqsTable extends Migration
{
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->unsignedBigInteger('page_id')->nullable();
            $table->foreign('page_id', 'page_fk_4293325')->references('id')->on('content_pages');
        });
    }
}
