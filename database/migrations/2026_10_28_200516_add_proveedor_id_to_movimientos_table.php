<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('movimientos', 'proveedor_id')) {
            Schema::table('movimientos', function (Blueprint $table) {
                $table->foreignId('proveedor_id')
                    ->nullable()
                    ->constrained('proveedores')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('movimientos', 'proveedor_id')) {
            Schema::table('movimientos', function (Blueprint $table) {
                $table->dropConstrainedForeignId('proveedor_id');
            });
        }
    }
};