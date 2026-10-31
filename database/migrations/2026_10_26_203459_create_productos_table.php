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
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 150);
        $table->string('sku', 50)->unique();
        $table->string('categoria', 100);
        $table->string('proveedor', 150);
        $table->decimal('precio', 10, 2);
        $table->unsignedInteger('stock')->default(0);
        $table->unsignedInteger('stock_minimo')->default(5);
        $table->text('descripcion')->nullable();
        $table->string('imagen')->nullable();
        $table->timestamps();
    });
}
};
