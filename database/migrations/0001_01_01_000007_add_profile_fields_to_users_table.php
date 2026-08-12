<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add fields if they don't exist
            if (!Schema::hasColumn('users', 'full_name')) {
                $table->string('full_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik', 20)->nullable()->after('full_name');
            }
            if (!Schema::hasColumn('users', 'company_name')) {
                $table->string('company_name')->nullable()->after('nik');
            }
            if (!Schema::hasColumn('users', 'unit')) {
                $table->string('unit')->nullable()->after('company_name');
            }
            if (!Schema::hasColumn('users', 'position')) {
                $table->string('position')->nullable()->after('unit');
            }
            if (!Schema::hasColumn('users', 'telephone')) {
                $table->string('telephone', 20)->nullable()->after('position');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'nik',
                'company_name',
                'unit',
                'position',
                'telephone'
            ]);
        });
    }
};