<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('support_ticket_id')
                ->constrained()
                ->onDelete('cascade');
            $table->json('images')->nullable();
            $table->text('body');
            $table->timestamps();
        });

//        Schema::create('comments', function (Blueprint $table) {
//            $table->id();
//            $table->text('body');
//            $table->json('images')->nullable();
//            $table->unsignedBigInteger('user_id');
//            $table->unsignedBigInteger('support_ticket_id');
//            $table->timestamps();
//
//            $table->foreign('support_ticket_id')
//                ->references('id')
//                ->on('support_tickets')
//                ->onDelete('cascade');
//        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
