<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImputationMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imputation_missions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('mission_id');
            $table->bigInteger('plan_budgetaire_id');
            $table->string('montant');
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
        Schema::dropIfExists('imputation_missions');
    }
}
