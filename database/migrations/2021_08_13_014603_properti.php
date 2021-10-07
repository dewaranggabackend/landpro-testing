<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Properti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properti', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('category_id');
            $table->boolean('jenis');
            $table->string('nama', 65, 0);
            $table->string('deskripsi', 600, 0);
            $table->string('alamat_gmap');
            $table->string('provinsi', 65, 0);
            $table->string('kabupaten', 65, 0);
            $table->string('kecamatan', 65, 0);
            $table->decimal('kode_pos', 5, 0);
            $table->decimal('luas_tanah', 12, 0);
            $table->decimal('luas_bangunan', 12, 0)->nullable();
            $table->string('sertifikat', 13);
            $table->string('umur_bangunan', 12)->nullable();
            $table->decimal('jumlah_lantai', 3, 0)->nullable();
            $table->decimal('kamar_tidur', 3, 0)->nullable();
            $table->decimal('kamar_mandi', 3, 0)->nullable();
            $table->decimal('kamar_tidur_art', 3, 0)->nullable();
            $table->decimal('kamar_mandi_art', 3, 0)->nullable();
            $table->decimal('daya_listrik', 5, 0)->nullable();
            $table->string('orientasi_bangunan', 12)->nullable();
            $table->decimal('tahun_dibangun', 4, 0)->nullable();
            $table->string('interior', 25)->nullable();
            $table->string('fasilitas', 600)->nullable();
            $table->boolean('pdam', 25)->nullable();
            $table->string('foto_tampak_depan', 600);
            $table->string('foto_tampak_jalan', 600)->nullable();
            $table->string('foto_tampak_ruangan', 600)->nullable();
            $table->string('foto_tampak_lain', 600)->nullable();
            $table->decimal('harga', 12, 0);
            $table->string('cicilan', 12)->nullable();
            $table->boolean('uang_muka', 5)->nullable();
            $table->boolean('nego', 5)->nullable();
            $table->decimal('harga_uang_muka', 12, 0)->nullable();
            $table->string('longitude', 50, 0)->nullable();
            $table->string('latitude', 50, 0)->nullable();
            $table->decimal('whatsapp', 20, 0)->nullable();
            $table->decimal('kontak', 20, 0)->nullable();
            $table->boolean('tayang')->default(0);
            $table->boolean('pet_allowed')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
