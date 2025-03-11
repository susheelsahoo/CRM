<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable(); // New column: Address
            $table->string('company')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'qualified', 'lost'])->default('new');
            $table->unsignedBigInteger('assigned_to')->nullable(); // User who manages the lead
            $table->foreign('assigned_to')->references('id')->on('admins')->onDelete('set null');

            // Transaction Details
            $table->date('date_of_purchase')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('card_number')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('cvv')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
