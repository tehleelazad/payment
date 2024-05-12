<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paymentdetails', function (Blueprint $table) {
            $table->id();
            $table->string('razorpay_payment_id', 255)->nullable(false);
            $table->string('payment_token', 255)->nullable(false);
            $table->decimal('amount', 10, 2)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentdetails');
    }
};
