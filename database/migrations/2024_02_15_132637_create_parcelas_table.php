<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcelas', function (Blueprint $table) {
            $table->id();
            $table->date('data_vencimento');
            $table->float('valor_parcela');
            $table->unsignedBigInteger('venda_id');
            $table->foreign('venda_id')->references('id')->on('vendas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parcelas', function (Blueprint $table) {
            $table->dropForeign(['venda_id']);
            $table->dropColumn('venda_id');
        });
        Schema::dropIfExists('parcelas');
    }
}
