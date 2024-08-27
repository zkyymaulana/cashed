<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->decimal('discount', 5, 2)->default(0); // Menambahkan kolom discount
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
   {
       Schema::table('order_details', function (Blueprint $table) {
           $table->dropColumn('discount'); // Menghapus kolom discount jika rollback
       });
   }
};
