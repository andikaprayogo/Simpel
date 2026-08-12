<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignatureFieldsToForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            // Signature fields - PT ZTE/Huawei
            $table->string('zte_huawei_name')->nullable();
            $table->string('zte_huawei_nik')->nullable();
            $table->string('zte_huawei_signature_path')->nullable();
            
            // Signature fields - PT TELKOMSEL MGR NOP
            $table->string('telkomsel_nop_name')->nullable();
            $table->string('telkomsel_nop_nik')->nullable();
            $table->string('telkomsel_nop_region')->nullable();
            $table->string('telkomsel_nop_signature_path')->nullable();
            
            // Signature fields - PT TELKOMSEL MGR RTPDS
            $table->string('telkomsel_rtpds_name')->nullable();
            $table->string('telkomsel_rtpds_nik')->nullable();
            $table->string('telkomsel_rtpds_region')->nullable();
            $table->string('telkomsel_rtpds_signature_path')->nullable();
            
            // Signature fields - PT TELKOMSEL MGR RTYPE
            $table->string('telkomsel_rtype_name')->nullable();
            $table->string('telkomsel_rtype_nik')->nullable();
            $table->string('telkomsel_rtype_region')->nullable();
            $table->string('telkomsel_rtype_signature_path')->nullable();
            
            // Signature fields - PT TELKOM MGR NDPS TR1
            $table->string('telkom_ndps_name')->nullable();
            $table->string('telkom_ndps_nik')->nullable();
            $table->string('telkom_ndps_signature_path')->nullable();
            
            // Signature fields - PT TIF TIM SURVEY
            $table->string('tif_survey_name')->nullable();
            $table->string('tif_survey_nik')->nullable();
            $table->string('tif_survey_signature_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            // Drop PT ZTE/Huawei fields
            $table->dropColumn('zte_huawei_name');
            $table->dropColumn('zte_huawei_nik');
            $table->dropColumn('zte_huawei_signature_path');
            
            // Drop PT TELKOMSEL MGR NOP fields
            $table->dropColumn('telkomsel_nop_name');
            $table->dropColumn('telkomsel_nop_nik');
            $table->dropColumn('telkomsel_nop_region');
            $table->dropColumn('telkomsel_nop_signature_path');
            
            // Drop PT TELKOMSEL MGR RTPDS fields
            $table->dropColumn('telkomsel_rtpds_name');
            $table->dropColumn('telkomsel_rtpds_nik');
            $table->dropColumn('telkomsel_rtpds_region');
            $table->dropColumn('telkomsel_rtpds_signature_path');
            
            // Drop PT TELKOMSEL MGR RTYPE fields
            $table->dropColumn('telkomsel_rtype_name');
            $table->dropColumn('telkomsel_rtype_nik');
            $table->dropColumn('telkomsel_rtype_region');
            $table->dropColumn('telkomsel_rtype_signature_path');
            
            // Drop PT TELKOM MGR NDPS TR1 fields
            $table->dropColumn('telkom_ndps_name');
            $table->dropColumn('telkom_ndps_nik');
            $table->dropColumn('telkom_ndps_signature_path');
            
            // Drop PT TIF TIM SURVEY fields
            $table->dropColumn('tif_survey_name');
            $table->dropColumn('tif_survey_nik');
            $table->dropColumn('tif_survey_signature_path');
        });
    }
}