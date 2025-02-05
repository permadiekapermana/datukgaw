<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocBelanjaPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_belanja_pegawais', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->string('jenis_dokumen');
            $table->string('tipe_dokumen');
            $table->string('nama_dokumen');
            $table->string('nomor_dokumen');
            $table->string('deskripsi_dokumen', 500);
            $table->string('file', 250);
            $table->uuid('user_id');
            $table->timestamp('created_dt')->useCurrent();
            $table->string('created_by');
            $table->timestamp('updated_dt')->useCurrent();
            $table->string('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_belanja_pegawai');
    }
}
