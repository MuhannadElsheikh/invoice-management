<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices_detalis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoices_id');
            $table->foreign('invoices_id')->references('id')->on('invoices')->onDelete('CASCADE');
            $table->string('invoice_number');
            $table->string('product');
            $table->string('section');
            $table->string('status');
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->string('user');
            $table->date('bayment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices_detalis');
    }
};
