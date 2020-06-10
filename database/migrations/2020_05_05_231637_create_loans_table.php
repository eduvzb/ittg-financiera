<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); //Cliente
            $table->decimal('amount');
            $table->integer('payments_number');
            $table->decimal('fee');
            $table->date('ministry_date');
            $table->date('due_date');
            $table->tinyinteger('finished');
            $table->timestamps();

            //Llave foranea 
            $table->foreign('client_id')
                ->references('id')
                ->on('clients');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
