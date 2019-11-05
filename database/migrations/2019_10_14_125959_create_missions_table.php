<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('objet');
            $table->string('date_mission');
            $table->bigInteger('exercice_budgetaire')->nullable();
            $table->bigInteger('categorie_missions_id')->nullable();
            $table->string('numero_autorisation')->nullable();
            $table->string('numero_ccm')->nullable();
            $table->string('destination')->nullable();
            $table->string('itineraire_retenu')->nullable();
            $table->string('moyen_transport')->nullable();
            $table->string('classe_voyage')->nullable();
            $table->string('montant')->nullable();
            $table->string('date_depart')->nullable();
            $table->string('date_retour')->nullable();
            $table->string('duree')->nullable();
            $table->string('mode_paiement')->nullable();
            $table->string('frais_restauration')->nullable();
            $table->string('frais_hebergement')->nullable();
            $table->string('frais_deplacement')->nullable();
            $table->bigInteger('acte_personnel_id')->nullable();
            $table->bigInteger('plan_budgetaire_id')->nullable();
            $table->string('date_visa_cf')->nullable();
            $table->string('decision_cf')->nullable();
            $table->string('signataire')->nullable();
            $table->string('fichier_joint')->nullable();
            $table->foreign('categorie_missions_id')->references('id')->on('categorie_missions')->onDelete('cascade');
            $table->foreign('acte_personnel_id')->references('id')->on('acte_personnels')->onDelete('cascade');
            $table->foreign('exercice_budgetaire_id')->references('id')->on('exercice_budgetaires')->onDelete('cascade');
            $table->foreign('plan_budgetaire_id')->references('id')->on('plan_budgetaires')->onDelete('cascade');
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
        Schema::dropIfExists('missions');
    }
}
