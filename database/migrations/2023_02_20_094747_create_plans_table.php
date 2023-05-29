<?php

use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'mongodb';
    public function up()
    {
        Schema::connection($this->connection)->create('plans', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->string('battery_type');
            $table->integer('installments');
            $table->integer('paid_installments')->default(0);
            $table->float('deposit')->nullable();
            $table->float('balance');
            $table->string('battery_number')->unique();
            $table->unsignedBigInteger('client_id');
            $table->string('created_by');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
