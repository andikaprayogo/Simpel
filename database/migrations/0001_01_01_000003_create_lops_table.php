<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lops', function (Blueprint $table) {
            $table->id();
            $table->string('status_proyek');
            $table->string('witel');
            $table->string('site_id_location');
            $table->string('koordinat')->nullable();
            $table->string('kecamatan_lokasi_olt')->nullable();
            
            // OLT Technical Specifications
            $table->string('size_olt')->nullable();
            $table->string('platform')->nullable();
            $table->string('type')->nullable();
            $table->string('hostname')->nullable();
            $table->integer('jumlah_modul')->nullable();
            $table->string('catuan_ac')->nullable();
            
            // STO and Connection
            $table->string('kode_sto')->nullable();
            $table->string('nama_sto_uplink')->nullable();
            $table->string('port_metro')->nullable();
            $table->string('sfp')->nullable();
            $table->integer('odp')->nullable();
            $table->integer('port')->nullable();
            
            // Project Timeline
            $table->date('start_project')->nullable();
            $table->date('toc')->nullable();
            $table->date('tanggal_plan_oa')->nullable();
            $table->string('week_plan_oa')->nullable();
            
            // Contract and Issues
            $table->string('lop_downlink')->nullable();
            $table->string('kontrak_pengadaan')->nullable();
            $table->string('kode_ihld')->nullable();
            $table->string('site_provider')->nullable();
            $table->string('kendala')->nullable();
            $table->string('last_issue')->nullable();
            
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('lops');
    }
}