Ajouter bailleur
<template>
    
<div>
        <div class="container-fluid">
            <h4 v-if="marcheDetail(marcheid)" >Detail Marche : {{marcheDetail(marcheid).objet}}  <button class="btn btn-danger btn-large" v-if="marcheDetail(marcheid).attribue==0">Marché en cours de passation</button>
                <button class="btn btn-success btn-large" v-else>Marché attribué</button></h4>
            <hr />

            <div class="widget-box">
                <div class="widget-content">
                    <div class="widget-content nopadding">
                        <table class="table table-striped table-bordered" v-if="detail_marche">
                            <thead>
                            <tr>
                                <th>Objet marché</th>
                                <th>Reference marché</th>
                                <th>Montant marché</th>
                                <th>Type de marché</th>
                                <th>Unite administrative</th>
                                <th>Exercice Budgetaire</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="detail_marche">
                                
                                <td class="taskDesc">{{detail_marche.objet}}</td>
                                <td class="taskStatus">{{detail_marche.reference_marche}}</td>
                                <td class="taskOptions">
                                    {{detail_marche.montant_marche}}
                                </td>
                                <td class="taskOptions">
                                    {{detail_marche.type_marche.libelle}}
                                </td>
                                <td class="taskOptions">
                                    {{detail_marche.objetUniteAdministrative.libelle}}
                                </td>
                                <td class="taskOptions">
                                    {{detail_marche.exo_id}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <bailleur-ajouter :macheid="detail_marche.exo_id"></bailleur-ajouter>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span3">

                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab01">Bailleur</a></li>
                                <li class=""><a data-toggle="tab" href="#tab1">Offre</a></li>
                                <li class=""><a data-toggle="tab" href="#tab2">Liste des lots</a></li>
                                <li class=""><a data-toggle="tab" href="#tab3">Contratualisation</a></li>
                                <!-- <li class=""><a data-toggle="tab" href="#tab4">Facture</a></li> -->
                            </ul>
                        </div>
                        <div class="widget-content tab-content">


                            <div id="tab01" class="tab-pane active">
                                <div class="span4"></div>
                                <div class="span4"></div>
                                <div class="span4" align="right">
                                    <a href="#addBailleurMarche" data-toggle="modal" class="btn btn-success" align="rigth">Ajouter</a></div>
                                <h4>Liste des bailleurs du marché</h4>

                                <table class="table table-bordered table-striped" v-if="marcheid">
                                    <thead>
                                    <tr>
                                        <th>Bailleur</th>
                                        <th>Type finanncement</th>
                                        <th>Montant</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="odd gradeX" v-for="appelOffre in listeBailleurMarche(marcheid)"
                                        :key="appelOffre.id">
                                        <td @dblclick="editeMarcheBailleur(appelOffre.id)">
                                            {{appelOffre.bailleur.libelle || 'Non renseigné'}}</td>
                                        <td @dblclick="editeMarcheBailleur(appelOffre.id)">
                                            {{appelOffre.typeFinnancement.libelle || 'Non renseigné'}}</td>
                                        <td @dblclick="editeMarcheBailleur(appelOffre.id)">
                                            {{appelOffre.montant || 'Non renseigné'}}</td>
                                        <div class="btn-group">
                                            <button @click.prevent="supprimerMarcheBailleur(appelOffre.id)"  class="btn btn-danger ">
                                                <span class=""><i class="icon-trash"></i></span></button>
                                        </div>

                                    </tr>
                                    </tbody>
                                </table>


                                <div id="addBailleurMarche" class="modal hide" aria-hidden="true" style="display: none;">
                                    <div class="modal-header">
                                        <button data-dismiss="modal" class="close" type="button">×</button>
                                        <h3>Ajouter bailleur </h3>
                                    </div>
                                    <div class="modal-body">

                                        <form action="#" method="get" v-if="marcheid">
                                            <label>Bailleur</label>
                                            <div class="controls">
                                                <select v-model="formBailleur.bailleur_id" class="span" >
                                                    <option v-for="varText in sources_financements" :key="varText.id"
                                                            :value="varText.id">{{varText.libelle}}</option>
                                                </select>
                                            </div>
                                            <label>Type finnancement <code>*</code> </label>
                                            <div class="controls">

                                                <select v-model="formBailleur.type_finnancement_id" class="span">
                                                    <option v-for="varText in types_financements" :key="varText.id"
                                                            :value="varText.id">{{varText.libelle}}</option>
                                                </select>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Montant <code>*</code> :</label>
                                                <div class="controls">
                                                    <input type="text" class="span5" placeholder="Libelle lot" v-model="formBailleur.montant">
                                                </div>
                                                <div class="controls" v-if="detail_marche">
                                                    <code>Reste bailleur : {{parseFloat(detail_marche.montant_marche)-montantBailleurMarcheCompare(marcheid)}}</code>
                                                    <code v-if="montantBailleurMarcheCompare(marcheid)>=parseFloat(detail_marche.montant_marche)">
                                                        Le montant total des bailleurs ne toi etre supperier au montant du marche
                                                    </code>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="modal-footer" v-if="detail_marche">
                                            <button @click.prevent="ajouterBailleur" class="btn btn-primary" v-if="montantBailleurMarcheCompare(marcheid)<=parseFloat(detail_marche.montant_marche)">Valider</button>
                                            <button data-dismiss="modal" class="btn" href="#">Fermer</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="editBailleuMarche" class="modal hide" aria-hidden="true" style="display: none;">
                                    <div class="modal-header">
                                        <button data-dismiss="modal" class="close" type="button">×</button>
                                        <h3>Modification </h3>
                                    </div>
                                    <div class="modal-body">

                                        <form action="#" method="get" v-if="marcheid">
                                            <label>Bailleur</label>
                                            <div class="controls">
                                                <select v-model="edit_bailleur_marche.bailleur_id" class="span" >
                                                    <option v-for="varText in sources_financements" :key="varText.id"
                                                            :value="varText.id">{{varText.libelle}}</option>
                                                </select>
                                            </div>
                                            <label>Type finnancement <code>*</code> </label>
                                            <div class="controls">

                                                <select v-model="edit_bailleur_marche.type_finnancement_id" class="span">
                                                    <option v-for="varText in types_financements" :key="varText.id"
                                                            :value="varText.id">{{varText.libelle}}</option>
                                                </select>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Montant <code>*</code> :</label>
                                                <div class="controls">
                                                    <input type="text" class="span5" placeholder="Libelle lot" v-model="edit_bailleur_marche.montant">
                                                </div>
                                            </div>
                                        </form>
                                        <div class="modal-footer">
                                            <button @click.prevent="modificationBailleurMarche" class="btn btn-primary">Modification</button>
                                            <button data-dismiss="modal" class="btn" href="#">Fermer</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="tab1" class="tab-pane">
                                <div class="span4"></div>
                                <div class="span4"></div>
                                <div class="span4" align="right">
                                    <a href="#myAlert" data-toggle="modal" class="btn btn-success" align="rigth">Ajouter</a></div>
                                   <h4>Liste des offres</h4>
                                <table class="table table-bordered table-striped" v-if="marcheid">
                                    <thead>
                                    <tr>

                                        <th>Reference appel</th>
                                        <th> Type procedure</th>

                                        <!-- <th>Financement</th>
                                        <th>Nom bailleur</th> -->
                                        <th>Date emmission</th>
                                        <th>Date limite</th>
                                        <th>Objet appel</th>
                                        <th>Imputation</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="odd gradeX" v-for="appelOffre in listeAppelOffre(marcheid)"
                                        :key="appelOffre.id">
                                        <td @dblclick="afficherModalModifierActeDepense(appelOffre.id)">
                                            {{appelOffre.ref_appel || 'Non renseigné'}}</td>
                                        <td @dblclick="afficherModalModifierActeDepense(appelOffre.id)">
                                            {{appelOffre.type_appel || 'Non renseigné'}}</td>

                                        <!-- <td @dblclick="afficherModalModifierActeDepense(index)">
                                            {{appelOffre.financement || 'Non renseigné'}}</td> -->

                                        <!-- <td @dblclick="afficherModalModifierActeDepense(index)">
                                            {{appelOffre.nom_bailleurs || 'Non renseigné'}}</td> -->
                                        <td @dblclick="afficherModalModifierActeDepense(index)">

                                        <td @dblclick="afficherModalModifierActeDepense(appelOffre.id)">

                                            {{formaterDate(appelOffre.date_emission) || 'Non renseigné'}}</td>
                                        <td @dblclick="afficherModalModifierActeDepense(appelOffre.id)">
                                            {{formaterDate(appelOffre.date_limite) || 'Non renseigné'}}</td>
                                        <td @dblclick="afficherModalModifierActeDepense(appelOffre.id)">
                                            {{appelOffre.objet_appel || 'Non renseigné'}}</td>
                                        <td @dblclick="afficherModalModifierActeDepense(appelOffre.id)">
                                            {{appelOffre.imputation || 'Non renseigné'}}</td>
                                            <td>
                                        <div class="btn-group">
                                            <button @click.prevent="supprimerAppelOffre(appelOffre.id)"  class="btn btn-danger ">
                                                <span class=""><i class="icon-trash"></i></span></button>

                                        </div>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div id="tab2" class="tab-pane">
                                <div class="widget-box">
                                    <div class="widget-title">
              <span class="icon">
                <i class="icon-th"></i>
              </span>
                                        <h5>Liste des Lots</h5>
                                        <div align="right">
                                            Search:
                                            <input type="search" placeholder v-model="search" />
                                        </div>
                                    </div>
                                    <div class="widget-content nopadding">
                                        <div class="span4"></div>
                                        <div class="span4"></div>
                                        <div class="span4" align="right">
                                            <a href="#addLot" data-toggle="modal"
                                                                            class="btn btn-info">Ajouter lot</a></div>
                                        <table class="table table-bordered table-striped" v-if="marcheid">
                                            <thead>
                                            <tr>
                                                <th>Numero lot </th>
                                                <th>Libellé</th>
                                                <th>Montant</th>
                                                <th>Offre</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="odd gradeX" v-for="(lot_marche, index) in listeLots(marcheid)"
                                                :key="lot_marche.id">
                                                <td @dblclick="afficherModaleModifier(index)">
                                                    {{lot_marche.numero_lot || 'Non renseigné'}}</td>
                                                <td @dblclick="afficherModaleModifier(index)">
                                                    {{lot_marche.libelle_lot || 'Non renseigné'}}</td>
                                                <td @dblclick="afficherModaleModifier(index)">
                                                    {{lot_marche.montant_lot || 'Non renseigné'}}</td>
                                             
                                                <td @dblclick="afficherModaleModifier(index)">
                                                    {{lot_marche.appel_offre.ref_appel || 'Non renseigné'}}
                                                </td>

                                                <div class="btn-group">
                                                    <button @click.prevent="supprimerLot(lot_marche.id)"  class="btn btn-danger ">
                                                        <span class=""><i class="icon-trash"></i></span></button>

                                                </div>

                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>


                            <div id="tab3" class="tab-pane">
                                   
                            <ul class="nav nav-tabs">


                <div class="widget-box">
          <div class="widget-title">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab12">Dossier candidat</a></li>
              <li class=""><a data-toggle="tab" href="#tab21">Lettre invitation</a></li>
              <li class=""><a data-toggle="tab" href="#tab31">Mandate</a></li>
              <li class=""><a data-toggle="tab" href="#tab22">Ouverture</a></li>
              <li class=""><a data-toggle="tab" href="#tab32">Analyse</a></li>
              <li class=""><a data-toggle="tab" href="#tab36">PV</a></li>
               <li class=""><a data-toggle="tab" href="#tab33">Demande ANO</a></li>
                <li class=""><a data-toggle="tab" href="#tab34">Avis DMP</a></li>
                 <li class=""><a data-toggle="tab" href="#tab35">Avis Bailleur</a></li>
                 
                 <li class=""><a data-toggle="tab" href="#tab37" title="">Actes</a></li>

            

            

            </ul>
          </div>

          <div class="widget-content tab-content">


            <div id="tab12" class="tab-pane active">
          <div class="span6"></div>

                <div class="span6" align="right">
                    <button class="btn btn-success" @click="isFormulaireDossierCand" v-if="isButtunAddDossierCandidat">Ajouter dossier candidat</button>
                 <!--   <button class="btn btn-warning" v-if="isOffreTechniqueFinancier">Add Offre technique</button>
                    <button data-toggle="modal" class="btn btn-info" v-if="isOffreTechniqueFinancier">Add Offre financiere</button>-->
                </div>

             <div v-if="isButtunAddDossierCandidat">
                 <h4>Liste des dossiers candidats</h4>
                 <table class="table table-bordered table-striped" v-if="marcheid">
                     <thead>
                     <tr>
                         <th>Numero dossier</th>
                         <th>Type candidat</th>
                         <th>Raison social </th>
                         <th>Date naissance</th>
                         <th>Telephone</th>
                         <th>Adresse</th>
                         <th>Email</th>
                         <th>Appel Offre</th>
                         <th>Procedure</th>
                         <!--<th v-if="selectionAttributionMarche(marcheid)">Decision</th>-->
                         <th>Action</th>
                     </tr>
                     </thead>
                     <tbody>
                     <tr class="odd gradeX" v-for="(appelOffre, index) in dossierCandidature(marcheid)"
                         :key="appelOffre.id">
                         <td @click="afficheBouttonTechFin(index)">
                             {{appelOffre.numero_dossier || 'Non renseigné'}}</td>
                         <td @click="afficheBouttonTechFin(index)">
                             {{afficheCandidat(appelOffre.type_candidat_id) || 'Non renseigné'}}</td>
                         <td @click="afficheBouttonTechFin(index)">
                             {{appelOffre.nom_cand || 'Non renseigné'}}</td>
                         <td @click="afficheBouttonTechFin(index)">
                             {{formaterDate(appelOffre.date_nais_cand) || 'Non renseigné'}}</td>
                         <td @click="afficheBouttonTechFin(index)">
                             {{appelOffre.telephone_cand || 'Non renseigné'}}</td>
                         <td @click="afficheBouttonTechFin(index)">
                             {{appelOffre.adresse_post || 'Non renseigné'}}</td>
                         <td @dblclick="afficheBouttonTechFin(index)">
                             {{appelOffre.email_cand || 'Non renseigné'}}</td>
                         <td @click="afficheBouttonTechFin(index)">
                             {{appelOffre.appel_offre.objet_appel || 'Non renseigné'}}</td>
                         <td @click="afficheBouttonTechFin(index)">
                             {{appelOffre.procdure_passation.libelle || 'Non renseigné'}}</td>

                         <div class="btn-group">
                             <button   class="btn  " title="Detail" @click.prevent="isDetailDossierCandi(appelOffre.id)">
                                 <span class=""><i class="icon-folder-open" ></i></span></button>
                             <a href="#offreT" data-toggle="modal" @click.prevent="modaleOffreTechnique(appelOffre.id)"  class="btn" title="Offre technique">
                                 <span class=""><i class="icon-wrench"></i></span></a>
                             <a href="#offreF" data-toggle="modal" @click.prevent="modaleOffreFinnanciere(appelOffre.id)"  class="btn  " title="Offre financière">
                                 <span class=""><i class=" icon-money"></i></span></a>
                             <button @click.prevent="supprimerDossierCandidat(appelOffre.id)"  class="btn btn-danger " title="Supprimer">
                                 <span class=""><i class="icon-trash"></i></span></button>

                         </div>

                     </tr>
                     </tbody>
                 </table>
             </div>





                <!--ajouter de dossier candidature-->
                <div v-if="isFormulaireDossierCandidature">
                    <h6><button class="btn btn-success" @click="NotisFormulaireDossierCand" v-if="!isButtunAddDossierCandidat">Afficher la liste des candidat</button></h6>
                    <div class="span6" align="left">
                        Selectionner l'entreprise:
                        <model-list-select style="background-color: rgb(255,255,255);"
                                           class="wide"
                                           :list="entreprises"
                                           v-model="search"
                                           option-value="id"
                                           option-text="raison_sociale"
                                            :search-change="recherche()"
                                           placeholder="Selectionner l'entreprise"
                        >

                        </model-list-select>
                        <hr>
                       <!-- <input type="text" placeholder="Recherche ..." v-on:keyup="recherche" class="span6" v-model="search">-->
                    </div>

                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr class="odd gradeX">

                            <td>
                                <div class="control-group">
                                    <label class="control-label">registre de commerce</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Registre de commerce" v-model="formDossierCadidature.reg_com">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Numero de compte contribuable</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Situation Geographique" v-model="formDossierCadidature.numero_cc">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Raison social</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Raison social" v-model="formDossierCadidature.nom_cand">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Email</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Email" v-model="formDossierCadidature.email_cand">
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr class="odd gradeX">
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Telephone</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Telphone" v-model="formDossierCadidature.telephone_cand">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Address </label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Adresse" v-model="formDossierCadidature.adresse_post">
                                    </div>
                                </div>
                            </td>

                            <td>

                                <div class="control-group">
                                    <label class="control-label">Numero de dossier</label>
                                    <div class="controls">
                                        <input type="text" readonly class="" placeholder="Numero dossier" v-model="formDossierCadidature.numero_dossier">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Type candidat</label>
                                    <div class="controls">

                                         <select v-model="formDossierCadidature.type_candidat_id" class="span" >
                                        <option v-for="varText in typeCandidat" :key="varText.id"
                                                :value="varText.id">{{varText.libelle}}</option>
                                    </select>
                                     
                                    </div>
                                </div>
                            </td>



                        </tr>


                        <tr class="odd gradeX">
                            <td>
                                <label>Appel Offre</label>
                                <div class="controls">
                                    <select hidden v-model="formDossierCadidature.appel_offre_id" class="span" disabled>
                                        <option v-for="varText in listeAppelOffre(marcheid)" :key="varText.id"
                                                :value="varText.id">{{varText.ref_appel}}</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Accord groupe</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Accord Groupe" v-model="formDossierCadidature.accord_group">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Cautionnement prov</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Cautionnement" v-model="formDossierCadidature.cautionnement_prov">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Pouv habil signataire</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Pouv Hile Signature" v-model="formDossierCadidature.pouv_habil_signataire">
                                    </div>
                                </div>
                            </td>


                        </tr>


                        <tr class="odd gradeX">

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Attestion banc</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Attestation banc" v-model="formDossierCadidature.attest_banc">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Formulaire proo techn</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Formul propo tech" v-model="formDossierCadidature.formul_propo_tech">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Fiche rsgnt </label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Fiche renseignement" v-model="formDossierCadidature.fiche_rsgnt_cand">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Piece admin</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Piece Admin" v-model="formDossierCadidature.piece_admin">
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr class="odd gradeX">
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Fiche rsgnt nombre groupe</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Fiche renseignement nombre groupe" v-model="formDossierCadidature.fiche_rsgnt_mbre_group">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Atcdent marche non exe</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Atcent marche non exe" v-model="formDossierCadidature.atcdent_marche_non_exe">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Org travau site</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Org travau" v-model="formDossierCadidature.org_travau_site">
                                     </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Metch real travau</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Meth real travau" v-model="formDossierCadidature.meth_real_travau">
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <tr class="odd gradeX">

                            <td>
                                <label>Procedure de passation</label>
                                <div class="controls">
                                    <select v-model="formDossierCadidature.procedure_passation_id" class="span" disabled>
                                        <option v-for="varText in procedurePassations" :key="varText.id"
                                                :value="varText.id">{{varText.libelle}}</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Date de naissance</label>
                                    <div class="controls">
                                          <input type="date" class="" placeholder="" v-model="formDossierCadidature.date_nais_cand">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Capacite financiere</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Capacite financiere" v-model="formDossierCadidature.capacite_financiere">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <div class="controls">
                                        <label class="control-label">Prog mobilisation</label>
                                        <input type="Text" class="" placeholder="Programme mobilisation" v-model="formDossierCadidature.prog_mobilisation">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">CAA moyen acc entre</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="CAA moyen ac entre" v-model="formDossierCadidature.caa_moyen_ac_entre">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Capacite finanancier</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Capacite financement" v-model="formDossierCadidature.capacite_financement">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Capacite techn exp</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Capacite tech exp" v-model="formDossierCadidature.capacite_tech_exp">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Montant offre financiere</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Mont offre financiere" v-model="formDossierCadidature.mt_offre_financiere">
                                    </div>
                                </div>
                            </td>
                        </tr>



                        <a @click.prevent="ajouterDossierCandidature" class="btn btn-primary"
                           href="#">Enregistre dossier candidature</a>
                        </tbody>
                    </table>
                </div>

                <!--Detail dossier candidat  -->
                <div v-if="isDetailDossierCandidature">
                    <h6 v-if="detail_dossier_candidature">
                      </h6>


                    <div class="widget-box" v-if="detail_dossier_candidature">
                        <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                            <h5>Nom du candidat : {{detail_dossier_candidature.nom_cand}} {{detail_dossier_candidature.prenom_cand}}  Numero dossier :{{detail_dossier_candidature.numero_dossier}} </h5>
                            <button class="btn" title="Affiche la liste des candidats" @click="NotisFormulaireDossierCand" v-if="!isButtunAddDossierCandidat"><span class=""><i class="icon-eye-open"></i></span></button></div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Numero dossier</th>
                                    <th>Type candidat</th>
                                    <th>Telephone </th>
                                    <th>adresse </th>
                                    <th>Situation geographique</th>
                                    <th>Email</th>
                                    <th>Meth reat traveau</th>
                                    <th>Accord groupe</th>
                                    <th>Pauv habil signataire</th>
                                    <th>Caution</th>
                                    <th>Registe de commerce</th>
                                </tr>
                                </thead>

                                <tr>
                                    <td>{{detail_dossier_candidature.numero_dossier || "Non renseigne"}}</td>
                                    <td>{{afficheCandidat(detail_dossier_candidature.type_candidat_id) || "Non renseigne"}}</td>
                                    <td>{{detail_dossier_candidature.telephone_cand || "Non renseigne"}}</td>
                                    <td>{{detail_dossier_candidature.adresse_post || "Non renseigne"}}</td>
                                    <td>{{detail_dossier_candidature.situation_geo || "Non renseigne"}}</td>
                                    <td>{{detail_dossier_candidature.email_cand || "Non renseigne"}}</td>
                                    <td>{{detail_dossier_candidature.meth_real_travau || "Non renseigne"}}</td>
                                    <td>{{detail_dossier_candidature.accord_group || "Non renseigne"}}</td>
                                    <td>{{detail_dossier_candidature.pouv_habil_signataire || "Non renseigne"}}</td>
                                    <td>{{detail_dossier_candidature.cautionnement_prov || "Non renseigne"}}</td>
                                    <td>{{detail_dossier_candidature.reg_com || "Non renseigne"}}</td>

                                </tr>


                            </table>
                        </div>
                    </div>
                    <div class="widget-box" v-if="detail_offre_technique">
                        <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                            <h5>Offre technique du candidat</h5>
                            </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Programme mobilisation</th>
                                    <th>Capacite financiere </th>
                                    <th>CAA Moyenn</th>
                                    <!-- <th>Capacite financement</th> -->
                                    <th>Capacite technique exper </th>
                                    <th>Meth reat traveau</th>
                                    <th>Accord groupe</th>
                                    <th>Pauv habil signataire</th>
                                    <th>Caution</th>
                                    <th>Registe de commerce</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tr>
                                    <td>{{detail_offre_technique.prog_mobilisation || "Non renseigne"}}</td>
                                    <td>{{detail_offre_technique.capacite_financiere || "Non renseigne"}}</td>
                                    <td>{{detail_offre_technique.caa_moyen_ac_entre || "Non renseigne"}}</td>
                                    <!-- <td>{{detail_offre_technique.capacite_financement || "Non renseigne"}}</td> -->
                                    <td>{{detail_offre_technique.capacite_tech_exp || "Non renseigne"}}</td>
                                    <td>{{detail_offre_technique.meth_real_travau || "Non renseigne"}}</td>
                                    <td>{{detail_offre_technique.accord_groupe || "Non renseigne"}}</td>
                                    <td>{{detail_offre_technique.pouv_habil_signataire || "Non renseigne"}}</td>
                                    <td>{{detail_offre_technique.cautionnement_prov || "Non renseigne"}}</td>
                                    <td>{{detail_offre_technique.reg_com || "Non renseigne"}}</td>
                                    <td><button @click.prevent="supprimerOffreTechnique(detail_offre_technique.id)"  class="btn btn-danger " title="Supprimer">
                                        <span class=""><i class="icon-trash"></i></span></button></td>
                                </tr>


                            </table>
                        </div>
                    </div>

                    <div class="widget-box" v-if="detail_offre_finnancier">
                        <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                            <h5>Offre financiere</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Designation</th>
                                  
                                    <th>Quantite</th>
                                    <th>Prix unitaire</th>
                                    <th>Montant total ht </th>
                                    <th>Montant total ttc </th>
                                    <th>Action </th>
                                </tr>
                                </thead>

                                <tr>
                                    <td>{{detail_offre_finnancier.designation || "Non renseigne"}}</td>
                                    <!-- <td>{{detail_offre_finnancier.unite || "Non renseigne"}}</td> -->
                                    <td>{{detail_offre_finnancier.quantite || "Non renseigne"}}</td>
                                    <td>{{detail_offre_finnancier.prix_unitaire || "Non renseigne"}}</td>
                                    <td>{{detail_offre_finnancier.montant_total_ht || "Non renseigne"}}</td>
                                    <td>{{detail_offre_finnancier.montant_total_ttc || "Non renseigne"}}</td>
                                    <td><button @click.prevent="supprimerOffreFinancier(detail_offre_finnancier.id)"  class="btn btn-danger " title="Supprimer">
                                        <span class=""><i class="icon-trash"></i></span></button></td>
                                </tr>


                            </table>
                        </div>
                    </div>
                </div>
                <!--fin dossier candidat-->







              </div>

              

              <!--- debut de formulaire de modification  de dossier de candidat-->

               <div id="modificationDossierCandidatModal" class="modal hide tlDossierCandidat">
                   <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modification dossier candidat</h3>
                 </div>
                  <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr class="odd gradeX">

                            <td>
                                <div class="control-group">
                                    <label class="control-label">registre de commerce</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Registre de commerce" v-model="editDossierCadidature.reg_com">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Numero de compte contribuable</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Situation Geographique" v-model="editDossierCadidature.numero_cc">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Raison social</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Raison social" v-model="editDossierCadidature.nom_cand">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Email</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Email" v-model="editDossierCadidature.email_cand">
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr class="odd gradeX">
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Telephone</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Telphone" v-model="editDossierCadidature.telephone_cand">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Address </label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Adresse" v-model="editDossierCadidature.adresse_post">
                                    </div>
                                </div>
                            </td>

                            <td>

                                <div class="control-group">
                                    <label class="control-label">Numero de dossier</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Numero dossier" v-model="editDossierCadidature.numero_dossier">
                                    </div>
                                </div>
                            </td>
                             <td>
                                <div class="control-group">
                                    <label class="control-label">Type candidat</label>
                                    <div class="controls">

                                         <select  v-model="editDossierCadidature.type_candidat_id" class="span" >
                                        <option v-for="varText in typeCandidat" :key="varText.id"
                                                :value="varText.id">{{varText.libelle}}</option>
                                    </select>
                                       
                                    </div>
                                </div>
                            </td>




                        </tr>


                        <tr class="odd gradeX">
                            <td>
                                <label>Appel Offre</label>
                                <div class="controls">
                                    <select hidden v-model="editDossierCadidature.appel_offre_id" class="span" disabled>
                                        <option v-for="varText in listeAppelOffre(marcheid)" :key="varText.id"
                                                :value="varText.id">{{varText.ref_appel}}</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Accord groupe</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Accord Groupe" v-model="editDossierCadidature.accord_group">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Cautionnement prov</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Cautionnement" v-model="editDossierCadidature.cautionnement_prov">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Pouv habil signataire</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Pouv Hile Signature" v-model="editDossierCadidature.pouv_habil_signataire">
                                    </div>
                                </div>
                            </td>


                        </tr>


                        <tr class="odd gradeX">

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Attestion banc</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Attestation banc" v-model="editDossierCadidature.attest_banc">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Formulaire proo techn</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Formul propo tech" v-model="editDossierCadidature.formul_propo_tech">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Fiche rsgnt </label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Fiche renseignement" v-model="editDossierCadidature.fiche_rsgnt_cand">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Piece admin</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Piece Admin" v-model="editDossierCadidature.piece_admin">
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr class="odd gradeX">
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Fiche rsgnt nombre groupe</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Fiche renseignement nombre groupe" v-model="editDossierCadidature.fiche_rsgnt_mbre_group">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Atcdent marche non exe</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Atcent marche non exe" v-model="editDossierCadidature.atcdent_marche_non_exe">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Org travau site</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Org travau" v-model="editDossierCadidature.org_travau_site">
                                     </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <label class="control-label">Metch real travau</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Meth real travau" v-model="editDossierCadidature.meth_real_travau">
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <tr class="odd gradeX">

                            <td>
                                <label>Procedure de passation</label>
                                <div class="controls">
                                    <select v-model="editDossierCadidature.procedure_passation_id" class="span" disabled>
                                        <option v-for="varText in procedurePassations" :key="varText.id"
                                                :value="varText.id">{{varText.libelle}}</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Date de naissance</label>
                                    <div class="controls">
                                          <input type="date" class="" placeholder="" v-model="editDossierCadidature.date_nais_cand">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Capacite financiere</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Capacite financiere" v-model="editDossierCadidature.capacite_financiere">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="control-group">
                                    <div class="controls">
                                        <label class="control-label">Prog mobilisation</label>
                                        <input type="Text" class="" placeholder="Programme mobilisation" v-model="editDossierCadidature.prog_mobilisation">
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">CAA moyen acc entre</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="CAA moyen ac entre" v-model="editDossierCadidature.caa_moyen_ac_entre">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Capacite finanancier</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Capacite financement" v-model="editDossierCadidature.capacite_financement">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Capacite techn exp</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Capacite tech exp" v-model="editDossierCadidature.capacite_tech_exp">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label">Montant offre financiere</label>
                                    <div class="controls">
                                        <input type="text" class="" placeholder="Mont offre financiere" v-model="editDossierCadidature.mt_offre_financiere">
                                    </div>
                                </div>
                            </td>
                        </tr>


                        
                        </tbody>
                    </table>
                  </div>
                        
                     <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary" @click.prevent="modificationDossierCandidatLocal" href="#">Modifier</a>
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>    
               </div>

              <!-- fin de formulaire de modification de dossier de candidat --->






     <!--- debut ajout fournisseur que information n'exist pas dans la base  --->



              <!--  fin ajout founisseur --->





            <div id="tab21" class="tab-pane">
<div align="right">
                <div class="widget-content">

                    <a href="#ajouterLettreInvitation" data-toggle="modal" class="btn btn-warning">Ajouter</a>

                </div>

</div>
       <h4> Liste des lettres invitations</h4>
                <table class="table table-bordered table-striped" v-if="marcheid">
                    <thead>
                    <tr>

                        <th>Date lettre</th>
                        <th>Ref lettre </th>
                        <th>Destinataire</th>
                        <th>Objet de la lettre</th>
                        <th>Fichier</th>
                        <th>Date cojo</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="appelOffre in lettreInvitationAMarche(marcheid)"
                        :key="appelOffre.id">
                        <td @click="afficheBouttonTechFinInvitation(appelOffre.id)">
                           {{formaterDate(appelOffre.date_lettre) || 'Non renseigné'}}</td>
                        <td @click="afficheBouttonTechFinInvitation(appelOffre.id)">
                            {{appelOffre.ref_lettre || 'Non renseigné'}}</td>
                        <td @click="afficheBouttonTechFinInvitation(appelOffre.id)">
                            {{appelOffre.destination || 'Non renseigné'}}</td>

                         <td @click="afficheBouttonTechFinInvitation(appelOffre.id)">
                            {{appelOffre.objet_lettre || 'Non renseigné'}}</td>
                        <td>
                            <a v-if="appelOffre.fichier" :href="appelOffre.fichier" class="btn btn-default" target="_blank">
                                <span class=""><i class="icon-book"></i>
                                </span>
                            </a>
                        </td>
                        <td @click="afficheBouttonTechFinInvitation(appelOffre.id)">
                            {{formaterDate(appelOffre.date_cojo )|| 'Non renseigné'}}
                        </td>
                        <div class="btn-group">
                            <button @click.prevent="supprimerLettreInvitation(appelOffre.id)"  class="btn btn-danger " title="Supprimer">
                                <span class=""><i class="icon-trash"></i></span></button>
                        </div>

                    </tr>
                    </tbody>
                </table>
            </div>

            <div id="tab31" class="tab-pane">
                <div align="right">
                    <div class="widget-content">

                        <a href="#ajouterMantater" data-toggle="modal" class="btn btn-warning">Ajouter</a>

                    </div>

                </div>
                <h4> liste des mandates</h4>
                <table class="table table-bordered table-striped" v-if="marcheid">
                    <thead>
                    <tr>

                        <th>Date </th>
                        <th>Matricule </th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="(appelOffre, index) in listeMantater(marcheid)"
                        :key="appelOffre.id">
                        <td @click="afficheBouttonTechFinMandater(index)">
                            {{formaterDate(appelOffre.date_id) || 'Non renseigné'}}</td>
                        <td @click="afficheBouttonTechFinMandater(index)">
                            {{appelOffre.matricule_m || 'Non renseigné'}}</td>
                        <td @click="afficheBouttonTechFinMandater(index)">
                            {{appelOffre.nom_mandat || 'Non renseigné'}}</td>
                        <td @click="afficheBouttonTechFinMandater(index)">
                            {{appelOffre.prenom_nom || 'Non renseigné'}}</td>
                        <div class="btn-group">
                            <button @click.prevent="supprimerMandater(appelOffre.id)"  class="btn btn-danger " title="Supprimer">
                                <span class=""><i class="icon-trash"></i></span></button>

                        </div>

                    </tr>
                    </tbody>
                </table>

              </div>

              <div id="tab22" class="tab-pane">
                  <div align="right">
                      <div class="widget-content">

                          <a href="#ajouterCojo" data-toggle="modal" class="btn btn-warning" >Ajouter </a>

                      </div>

                  </div>
                  <h4> Infomation sur la cojo</h4>
                  <table class="table table-bordered table-striped" v-if="marcheid">
                      <thead>
                      <tr>
                          <th>Date Composition</th>
                          <th>Date invitation</th>
                          <th>Numero dossier Appel Offre</th>
                          <th>Nmbr particiapnt</th>
                          <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr class="odd gradeX" v-for="(appelOffre, index) in listeCojo(marcheid)"
                          :key="appelOffre.id">
                          <!--<td listeMembreCojo @click="afficheBouttonTechCojo(index)">
                              {{appelOffre.controleur_finnancier || 'Non renseigné'}}</td>
                          <td @click="afficheBouttonTechCojo(index)">
                              {{appelOffre.dmp || 'Non renseigné'}}</td>
                          <td @click="afficheBouttonTechCojo(index)">
                              {{appelOffre.autorite_contractante || 'Non renseigné'}}</td>-->
                          <td @click="afficheBouttonTechCojo(index)">
                              {{formaterDate(appelOffre.date_composition) || 'Non renseigné'}}
                          </td>
                          <td @click="afficheBouttonTechCojo(index)">
                              {{formaterDate(appelOffre.date_invitation) || 'Non renseigné'}}</td>
                          <td @click="afficheBouttonTechCojo(index)">
                              {{appelOffre.num_dossier_appel_offre || 'Non renseigné'}}</td>
                          <td @click="afficheBouttonTechCojo(index)">
                              {{appelOffre.nbr_participant || 'Non renseigné'}}</td>

                          <td @click="afficheBouttonTechCojo(index)">
                              {{appelOffre.lettre_invitation.ref_lettre || 'Non renseigné'}}</td>
                          <div class="btn-group">
                              <button @click.prevent="supprimerCojo(appelOffre.id)"  class="btn btn-danger " title="Supprimer">
                                  <span class=""><i class="icon-trash"></i></span></button>

                          </div>

                      </tr>
                      </tbody>
                  </table>
                  <div class="">
                      <div class="span9" >
                         <h4>Liste des membres de la cojo</h4>
                      </div>
                      <div class="span3" align="right">
                          <a href="#ajouter_membre_cojo" data-toggle="modal" class="btn btn-warning" >Ajouter un autre membre </a>
                      </div>
                      <table class="table table-bordered table-striped" v-if="marcheid">
                          <thead>
                          <tr>
                              <th>Matricule</th>
                              <th>Nom et prenom</th>
                              <th>Role</th>
                              <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr class="odd gradeX" v-for="appelOffre in listeMembreCojo"
                              :key="appelOffre.id">
                              <td @click="afficheModaleMembreCojo(appelOffre.id)">
                                  {{appelOffre.matricule|| 'Non renseigné'}}
                              </td>
                              <td @click="afficheModaleMembreCojo(appelOffre.id)">
                                  {{appelOffre.nom_prenom || 'Non renseigné'}}</td>
                              <td @click="afficheModaleMembreCojo(appelOffre.id)">
                                  {{appelOffre.role || 'Non renseigné'}}</td>
                              <div class="btn-group">
                                  <button @click.prevent="supprimerMembreCojo(appelOffre.id)"  class="btn btn-danger " title="Supprimer">
                                      <span class=""><i class="icon-trash"></i></span></button>
                              </div>

                          </tr>
                          </tbody>
                      </table>
                  </div>
            </div>


            <div id="tab32" class="tab-pane">

                <div align="right">
                    <div class="widget-content">

                        <a href="#ajouterMP" data-toggle="modal" class="btn btn-warning">Ajouter</a>

                    </div>

                </div>
                <h4>Liste des dossiers analyses</h4>
                <table class="table table-bordered table-striped" v-if="marcheid">
                    <thead>
                    <tr>
                        <th>Numero dossier</th>
                        <th>Dossier candidat </th>
                        <th>Date Analyse </th>
                        <th>Rang d'analyse</th>
                        <th>Note</th>
                        <th>Type d'analyse</th>
                        <th>Controller finnancier</th>
                        <!--<th>Avis</th>-->

                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="(appelOffre, index) in listeAnalyseDossier(marcheid)"
                        :key="appelOffre.id">
                        <td @click="afficheAnnalyseDossier(index)">
                            {{appelOffre.dossier_candidature.numero_dossier || 'Non renseigné'}}</td>
                        <td @click="afficheAnnalyseDossier(index)">
                            {{appelOffre.dossier_candidature.nom_cand || 'Non renseigné'}}</td>
                        <td @click="afficheAnnalyseDossier(index)">
                            {{formaterDate(appelOffre.date_analyse) || 'Non renseigné'}}</td>
                        <td @click="afficheAnnalyseDossier(index)">
                            {{appelOffre.rang_analyse || 'Non renseigné'}}</td>
                            <td @click="afficheAnnalyseDossier(index)">
                            {{appelOffre.note_analyse || 'Non renseigné'}}</td>
                        <td @click="afficheAnnalyseDossier(index)">
                            {{appelOffre.type_analyse.libelle || 'Non renseigné'}}</td>
                        <td @click="afficheAnnalyseDossier(index)">
                            {{appelOffre.cojo.controleur_finnancier || 'Non renseigné'}}</td>
                        <!--<td @click="afficheAnnalyseDossier(index)">
                            <button class="btn btn-info btn-mini" v-if="avisPv(appelOffre.reference_pv)==null">En attende</button>
                            <button class="btn btn-success btn-mini" v-else-if="avisPv(appelOffre.reference_pv)== 1">Non Objection</button>
                            <button class="btn btn-danger btn-mini" v-else>Objection</button>
                        </td>-->
                        <div class="btn-group">
                            <button @click.prevent="supprimerAnalyseDossier(appelOffre.id)"  class="btn btn-danger " title="Supprimer">
                                <span class=""><i class="icon-trash"></i></span></button>

                        </div>

                    </tr>
                    </tbody>
                </table>
              </div>








       <div id="tab33" class="tab-pane">
                <div align="right">
                    <div class="widget-content">

                        <a href="#ajouterDemandeAno" data-toggle="modal" class="btn btn-warning" v-if="listePVDemandePV(marcheid)">Ajouter</a>
                        <button class="btn btn-warning" title="La procedure n'est pas envore termine ou il n'y a pas de pv disponible" disabled v-else>Ajouter</button>
                    </div>

                </div>
                <h4> Liste des demandes d'ANO</h4>
                <table class="table table-bordered table-striped" v-if="marcheid">
                    <thead>
                    <tr>
                        <th>Numéro courrier</th>
                        <th>Reference marché</th>
                        <th>Reférence d'offre </th>
                        <th>Reference PV</th>
                        <th>Date demande</th>
                        <th>Fichier</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr class="odd gradeX" v-for="demande in demandeAno(marcheid)"
                        :key="demande.id" >
                        <td @click="afficheDemandeDAO(demande.id)">
                            {{demande.num_courrier || 'Non renseigné'}}</td>
                        <td @click="afficheDemandeDAO(demande.id)">
                            {{demande.ref_marche || 'Non renseigné'}}</td>
                        <td @click="afficheDemandeDAO(demande.id)">
                            {{demande.proce_verbal_offre.appel_offre.ref_appel || 'Non renseigné'}}</td>
                        <td @click="afficheDemandeDAO(demande.id)">
                            {{demande.proce_verbal_offre.reference || 'Non renseigné'}}</td>
                        <td @click="afficheDemandeDAO(demande.id)">
                            {{formaterDate(demande.date_demande) || 'Non renseigné'}}</td>

                        <td>
                            <a v-if="demande.fichier" :href="demande.fichier" class="btn btn-default" target="_blank">
                                <span class=""><i class="icon-book"></i>
                                </span>
                            </a>
                        </td>
                        <div class="btn-group">
                            <button @click.prevent="supprimerDemandeAno(demande.id)"  class="btn btn-danger " title="Supprimer">
                                <span class=""><i class="icon-trash"></i></span>
                            </button>
                        </div>


                    </tr>
                    </tbody>
                </table>

              </div>


<!--  debut modal ajout demande ano   -->

            <div id="tab34" class="tab-pane">
                <div align="right">
                    <div class="widget-content">
                        <a href="#ajouterDmp" data-toggle="modal" class="btn btn-warning">Ajouter</a>
                    </div>

                </div>
                <h4>Liste Analyse DMP</h4>
                <table class="table table-bordered table-striped" v-if="marcheid">
                    <thead>
                    <tr>
                        <th>Numero du courrier</th>
                        <th>Référence PV</th>
                        <th>Date avis</th>
                        <th>Decision </th>
                        <th>Observation</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="document in listeAnalyseDPM(marcheid)"
                        :key="document.id">

                        <td @click="afficheAnalyseDMP(document.id)">
                            {{document.demande_ano.num_courrier || 'Non renseigné'}}</td>

                        <td @click="afficheAnalyseDMP(document.id)">
                            {{document.demande_ano.proce_verbal_offre.reference || 'Non renseigné'}}
                        </td>
                        <td @click="afficheAnalyseDMP(document.id)">
                            {{formaterDate(document.date_avis_bail) || 'Non renseigné'}}</td>
                        
                        <td @click="afficheAnalyseDMP(document.id)">

                            <button class="btn btn-success btn-mini" v-if="document.avis_bail==1">Non objection</button>
                            <button class="btn btn-danger btn-mini" v-else>Objection</button>
                        </td>

                        <td @click="afficheAnalyseDMP(document.id)">
                            {{document.observation || 'Non renseigné'}}</td>

                        <!-- <td @click="afficheAnalyseDMP(document.id)">
                            {{document.document_procedure.libelle_doc || 'Non renseigné'}}</td> -->
                        <div class="btn-group">
                            <button @click.prevent="supprimerAnalyseDMP(document.id)"  class="btn btn-danger " title="Supprimer">
                                <span class=""><i class="icon-trash"></i></span></button>

                        </div>

                    </tr>
                    </tbody>
                </table>

              </div>


<!--- debut analyse dmp  --->








<!-- fin analyse dmp  -->

<!--- debut analyse dmp   --->

<!--  fin modification analyse dmp ---->







               <div id="tab35" class="tab-pane">
                <div align="right">
                    <div class="widget-content">

                        <a href="#ajouterAnoDMPBAILLEURModal" data-toggle="modal" class="btn btn-warning">Ajouter</a>

                    </div>

                </div>
                
                <h4> Liste avis bailleur</h4>
                <table class="table table-bordered table-striped" v-if="marcheid">
                    <thead>
                    <tr>
                      <th>Reference offre</th>
                        <th>Reference courrier</th>
                        <th>Date avis</th>
                        <th>Avis</th>
                        <th>Observation</th>
                        <th>Fichier</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="anoBailleur in listeAnoDMPBailleur(marcheid)"
                        :key="anoBailleur.id">

                         <td @click="afficheAnoDPMBailleurModale(anoBailleur.id)">
                            {{anoBailleur.annalyse_d_m_p.demande_ano.proce_verbal_offre.appel_offre.ref_appel || 'Non renseigné'}}</td>

                         <td @click="afficheAnoDPMBailleurModale(anoBailleur.id)">
                            {{anoBailleur.numero_courie || 'Non renseigné'}}</td>
                        <td @click="afficheAnoDPMBailleurModale(anoBailleur.id)">
                            {{formaterDate(anoBailleur.date_ano_dmp) || 'Non renseigné'}}</td>
                         <td @click="afficheAnoDPMBailleurModale(anoBailleur.id)">
                            <button class="btn btn-success btn-mini" v-if="anoBailleur.avis_bail== 1">Non objection</button>
                            <button class="btn btn-danger btn-mini" v-else>Objection</button>
                        </td>  
                             <td @click="afficheAnoDPMBailleurModale(anoBailleur.id)">
                            {{anoBailleur.observations_bailleur || 'Non renseigné'}}</td>

                        <td>
                            <a v-if="anoBailleur.fichier" :href="anoBailleur.fichier" class="btn btn-default" target="_blank">
                                <span class=""><i class="icon-book"></i>
                                </span>
                            </a>
                        </td>
                        <div class="btn-group">
                            <button @click.prevent="supprimerAnoDMPBailleur(anoBailleur.id)"  class="btn btn-danger " title="Supprimer">
                                <span class=""><i class="icon-trash"></i></span></button>

                        </div>

                    </tr>
                    </tbody>
                </table>

              </div>






                <div id="tab36" class="tab-pane">
                <div align="right">
                    <div class="widget-content">

                        <a href="#ajouterObservationBailleur" data-toggle="modal" class="btn btn-success">Ajouter</a>

                    </div>

                </div>


                <h4> liste de PV</h4>
                <table class="table table-bordered table-striped" v-if="marcheid">
                    <thead>
                    <tr>

                        <!-- <th>ANO DMP bailleur</th>  -->
                        <th>Reference Offre</th>
                        <th>Reference PV</th>
                        <th>Fichier</th>
                        <th>Avis</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="pv in listePV(marcheid)"
                        :key="pv.id">
                        <!-- <td @click="afficheAnoDPMBailleurModale(anoBailleur.id)">
                            {{anoBailleur.annalyse_d_m_p.demande_ano.annalyse_dossier.dossier_candidature.numero_dossier || 'Non renseigné'}}</td> -->
                        <td @dblclick="afficherModificationPV(pv.id)">
                            {{pv.appel_offre.ref_appel || 'Non renseigné'}}</td>
                        <td @dblclick="afficherModificationPV(pv.id)">
                            {{pv.reference || 'Non renseigné'}}</td>
                        <td >
                            <a v-if="pv.fichier" :href="pv.fichier" class="btn btn-default" target="_blank">
                                <span class=""><i class="icon-book"></i>
                                </span>
                            </a>
                        </td>


                        <td>
                            <button class="btn btn-info btn-mini" v-if="pv.avie==null">En attende</button>
                            <button class="btn btn-success btn-mini" v-else-if="pv.avie== 1">Non Objection</button>
                            <button class="btn btn-danger btn-mini" v-else>Objection</button>
                        </td>


                        <td>
                        <div class="btn-group">

                            <a href="#infoPV" @click.prevent="infoPVAffiche(pv.reference)" data-toggle="modal" class="btn"><span class=""><i class="icon-folder-open" ></i></span></a>
                            <button @click.prevent="supprimerProceVerbal(pv.id)"  class="btn btn-danger " title="Supprimer">
                                <span class=""><i class="icon-trash"></i></span></button>

                        </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

              </div>

             



<!--- debut modal ajout observation bailleur -->


 <div id="ajouterObservationBailleur" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter le PV</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">

                    <!--  <div class="control-group">
                        <label class="control-label">Reference PV</label>
                        <div class="controls">
                            <input type="text" v-model="formPv.ref_pv" class="span">
                        </div>
                    </div>-->

                     <div class="control-group">
              <label class="control-label">Fichier joint:</label>
              <div class="controls">
                <input type="file"   @change="OnchangeFichier" />
              </div>
            </div>
                   

                    

                </form>
            </div>
            <div class="modal-footer">
                <a
                        @click.prevent="ajouterPV"
                        class="btn btn-primary"
                        href="#"

                >Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>

              <div id="modificationPV" class="modal hide">
                  <div class="modal-header">
                      <button data-dismiss="modal" class="close" type="button">×</button>
                      <h3>Modification de PV</h3>
                  </div>
                  <div class="modal-body">
                      <form class="form-horizontal">

                            <div class="control-group">
                              <label class="control-label">Reference PV</label>
                              <div class="controls">
                                  <input type="text" v-model="edite_pv.reference" class="span">
                              </div>
                          </div>

                          <div class="control-group">
                              <label class="control-label">Fichier joint:</label>
                              <div class="controls">
                                  <input type="file"   @change="OnchangeFichier" />
                              </div>
                          </div>


                      </form>
                  </div>
                  <div class="modal-footer">
                      <a
                              @click.prevent="modificationProceVerbal"
                              class="btn btn-primary"
                              href="#"

                      >Valider</a>
                      <a data-dismiss="modal" class="btn" href="#">Fermer</a>
                  </div>
              </div>

              <div id="infoPV" class="modal hide grdirModalActeEffet">
                  <div class="modal-header">
                      <button data-dismiss="modal" class="close" type="button">×</button>
                      <h3>PROCES-VERBAL DE JUGEMENT DES OFFRES</h3>
                  </div>
                  <div class="modal-body" v-if="resultaAnalysePv">
                      <h4 class="text-center">ATTRIBUTION DU MARCHE</h4>
                      <div>
                          Suivant les résultats de l’évaluation des offres présentés par le rapporteur dans le
                          tableau ci-dessus, il apparaît que le soumissionnaire <b v-if="resultaAnalysePv.length>0">{{resultaAnalysePv[0].dossier_candidature.nom_cand }}</b> propose
                          l’offre conforme la moins-disante.
                      </div>
                      <h4 class="text-center">TABLEAU RECAPITULATIF DE LA COMPARAISON DES OFFRES</h4>
                      <table class="table table-bordered table-striped">
                          <thead>
                          <tr>
                              <th>Nom des Soumissionnaires </th>
                              <th>Note</th>
                              <th>Classement</th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr class="odd gradeX" v-for="(item, index) in resultaAnalysePv"
                              :key="item.id">
                              <!-- <td @click="afficheAnoDPMBailleurModale(anoBailleur.id)">
                                  {{anoBailleur.annalyse_d_m_p.demande_ano.annalyse_dossier.dossier_candidature.numero_dossier || 'Non renseigné'}}</td> -->
                              <td >
                                  {{item.dossier_candidature.nom_cand || 'Non renseigné'}}</td>
                              <td >
                                  {{item.note_analyse || 'Non renseigné'}}</td>
                              <td >
                                  <p v-if="index==0">
                                      {{index + 1}} er
                                  </p>
                                  <p v-else>
                                      {{index + 1}} eme
                                  </p>

                              </td>

                          </tr>
                          </tbody>
                      </table>
                  </div>
                  <div class="modal-footer">

                      <a data-dismiss="modal" class="btn" href="#">Fermer</a>
                  </div>
              </div>
<!-- fin obseravtion bailleur -->



<!--- debut modification observation bailleur  -->

<div id="modifierObservationBailleur" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modifier obseravtion bailleur</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                        <div class="control-group">
                        <label class="control-label">Document Procedure</label>
                        <div class="controls">
                          <select v-model="editObservation1.document_procedure_id" class="span">
                                <option v-for="varText in documentProcedures" :key="varText.id"
                                        :value="varText.id">{{varText.libelle_doc}}</option>
                            </select>
                        
                        </div>
                    </div>
                     <div class="control-group">
                        <label class="control-label">ANO DMP bailleur </label>
                        <div class="controls">
                           <select v-model="editObservation1.ano_dmp_bailleur_id" class="span">
                                <option v-for="varText in listeAnoDMPBailleur(marcheid)" :key="varText.id"
                                        :value="varText.id"><!--{{varText.annalyse_d_m_p.demande_ano.annalyse_dossier.dossier_candidature.numero_dossier}}--></option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Date </label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="editObservation1.date_avis_baill"
                                    class="span"
                                    placeholder="Saisir le libelle_type"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Avis</label>
                        <div class="controls">
                            <select v-model="editObservation1.avis_bail" class="span">
                                <option value="1">Non objection</option>
                                <option value="2">Objection</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Observation</label>
                        <div class="controls">
                            <textarea  v-model="editObservation1.observations_bailleur"
                                    class="span"
                                    placeholder="Saisir l'observation"
                            ></textarea>
                        </div>
                    </div>

                   

                </form>
            </div>
            <div class="modal-footer">
                <a
                        @click.prevent="modifierObservationBailleurLocal"
                        class="btn btn-primary"
                        href="#"

                >Modifier</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>

<!---fin modification observation bailleur   -->






            <div id="tab37" class="tab-pane">
                <div align="right">
                    <div class="widget-content">
                        <a href="#ajouterActeEffetFinancier" data-toggle="modal" class="btn btn-warning">Ajouter</a>
                    </div>



                </div>
                <h4> Liste acte effet financier </h4>
                <table class="table table-bordered table-striped" v-if="marcheid">
                    <thead>
                    <tr>

                        <th>Reference acte</th>
                        <th>Libelle acte</th>
                        <th>Montant acte</th>
                        <th>Type acte</th>
                        <th>Objet marche.</th>
                        <th>text juridique</th>
                        <th>Imputation</th>
                        <th>Entreprise</th>
                       
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for=" effetFinancier in listeActeEffectFinnancier(marcheid)"
                        :key="effetFinancier.id">
                        
                              <td @click="afficherModalModifierActeEffetFinancier(effetFinancier.id)">
                            {{effetFinancier.reference_act || 'Non renseigné'}}</td>
                            <td @click="afficherModalModifierActeEffetFinancier(effetFinancier.id)">
                            {{effetFinancier.libelle_act || 'Non renseigné'}}</td>
                             <td @click="afficherModalModifierActeEffetFinancier(effetFinancier.id)">
                            {{formatageSomme(parseFloat(effetFinancier.montant_act ))|| 'Non renseigné'}}</td>
                              <td @click="afficherModalModifierActeEffetFinancier(effetFinancier.id)">
                            {{effetFinancier.type_acte_effet.libelle || 'Non renseigné'}}</td>
                             <td @click="afficherModalModifierActeEffetFinancier(effetFinancier.id)">
                            {{effetFinancier.marche.objet || 'Non renseigné'}}</td>
                             <td @click="afficherModalModifierActeEffetFinancier(effetFinancier.id)">
                            {{effetFinancier.text_juridique.objet_text || 'Non renseigné'}}</td>
                             <td @click="afficherModalModifierActeEffetFinancier(effetFinancier.id)">
                            {{effetFinancier.marche.imputation || 'Non renseigné'}}</td>
                              <td @click="afficherModalModifierActeEffetFinancier(effetFinancier.id)">
                            {{effetFinancier.varObjetEntreprise.raison_sociale || 'Non renseigné'}}</td>
<td>
      <div class="btn-group">
                            <button @click.prevent="supprimerActeEffetFinancier(effetFinancier.id)"  class="btn btn-danger " title="Supprimer">
                                <span class=""><i class="icon-trash"></i></span>
                            </button>
                        </div>
</td>
                    </tr>
                    </tbody>
                </table>

              </div>



<!-- debut ajout acte effet financier --->



<div id="ajouterActeEffetFinancier" class="modal hide grdirModalActeEffet">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter acte effet financier</h3>
            </div>
            <div class="modal-body">

                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>
                        <div class="control-group">
                        <label class="control-label">Type acte effet financier.</label>
                        <div class="controls">
                          <select v-model="formEffetFinancier.type_act_effet_id" class="span">
                                <option v-for="varText in typeActeEffetFinanciers" :key="varText.id"
                                        :value="varText.id">{{varText.libelle}}</option>
                            </select>
                        
                        </div>
                    </div>
                            </td>
                                    <td>
                     <div class="control-group" v-if="selectionAttributionMarche(marcheid)">
                        <label class="control-label">Entreprise vainqueur </label>
                        <div class="controls" >
                            <input :value="selectionAttributionMarche(marcheid).dossier_candidature.nom_cand" readonly/>
                        </div>

                    </div>
                                        <div class="control-group" v-else>
                                            <code>{{message_setion_vainqueur}}</code>

                                        </div>
                            </td>

                            <td>


                        <div class="control-group">
                        <label class="control-label">Text juridique </label>
                        <div class="controls">
                           <select v-model="formEffetFinancier.text_juridique_id" class="span">
                                <option v-for="varText in text_juridiques" :key="varText.id"
                                        :value="varText.id">{{varText.objet_text}}</option>
                            </select>
                        </div>
                    </div>
                            </td>

                              <td>
                        <div class="control-group">
                        <label class="control-label">Ano bailleur dmp.</label>
                        <div class="controls">
                       <input :value="info_avis_bailleur" readonly>
                        
                        </div>
                    </div>
                            </td>
                           
                       
                           </tr>
                           <tr>
                                   <td>
                    <div class="control-group">
                        <label class="control-label">Autorité approbatrice</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="formEffetFinancier.autorite_approbation"
                                    class="span"
                                    placeholder=" "
                            />
                        </div>
                    </div>

                            </td>


                                           <td>
                    <div class="control-group">
                        <label class="control-label"> date d'approbation</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="formEffetFinancier.autorite_approbation"
                                    class="span"
                                    placeholder=""
                            />
                        </div>
                    </div>

                            </td>

                                  <td>
                    <div class="control-group">
                        <label class="control-label">Numero du marche/contract</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="formEffetFinancier.numero_marche"
                                    class="span"
                                    placeholder="Saisir le numero "
                            />
                        </div>
                    </div>

                            </td>
                             <td>

                    <div class="control-group">
                        <label class="control-label">Code acte </label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="formEffetFinancier.code_act"
                                    class="span"
                                    placeholder="Saisir le code acte"
                            />
                        </div>
                    </div>
                            </td>

                           </tr>
                        <tr>
                   
                      
                          <td colspan="4" width="550">
                     <div class="control-group">
          <label class="control-label">Libellé acte:</label>
            <div class="controls">
              <textarea   v-model="formEffetFinancier.libelle_act"   class="textarea_editor span12" rows="3" placeholder="Entrer le libellé ..."></textarea>
            </div>
          
        </div>
                            </td>
                   
                           
                          
                        </tr>
                        <tr>
                            <td>
                    <div class="control-group">
                        <label class="control-label">Reference acte</label>
                        <div class="controls">
                            <input type="text" v-model="formEffetFinancier.reference_act"
                                    class="span"
                                    placeholder="refence acte"
                            />
                        </div>
                    </div>
                            </td>
                            <td>
                     <div class="control-group">
                        <label class="control-label">Incidence financière</label>
                        <div class="controls">
                            <select  v-model="formEffetFinancier.incidence_financiere" class="span">
                               <option value="0">Oui</option>
                               <option value="1">Non</option>
                            </select>
                                    
                                  
                            
                        </div>
                    </div>
                            </td>
                            <td>

                     <div class="control-group">
                        <label class="control-label">Montant acte/réel du marché</label>
                        <div class="controls">
                            <input type="text" v-model="formEffetFinancier.montant_act"
                                    class="span"
                                    placeholder="Saisir le montant "
                            />
                        </div>
                    </div>
                            </td>
                            <td>

                            <div class="control-group">
                        <label class="control-label" >Date de signature attributaire</label>
                        <div class="controls">
                            <input type="date" v-model="formEffetFinancier.date_attributaire"
                                    class="span"
                                    placeholder=""
                            />
                        </div>
                    </div>
                            </td>
                        </tr>
                        <tr>

                    
                     <td>
                     <div class="control-group">
                        <label class="control-label">Date ordre de service demarrage</label>
                        <div class="controls">
                            <input type="date" v-model="formEffetFinancier.date_odre_service"
                                    class="span"
                                    placeholder=""
                            />
                        </div>
                    </div>
                            </td>


                                         <td>
                     <div class="control-group">
                        <label class="control-label" title=" ">Date fin exécution</label>
                        <div class="controls">
                            <input type="date" :min="formEffetFinancier.date_odre_service" :readonly="getDateFinExécutionValue" v-model="formEffetFinancier.date_fin_exe"
                                    class="span"
                                    placeholder=""
                            />
                        </div>
                    </div>
                            </td>
                        
                        

                                           <td>
                     <div class="control-group">
                        <label class="control-label" title=" ">Durée d'exécution(jrs)</label>
                        <div class="controls">
                            <input type="text"  readonly :value="nombreDejourCalcule"
                                    class="span"
                                   
                            />
                        </div>
                    </div>
                            </td>


                                             <td>
                     <div class="control-group">
                        <label class="control-label" title=" ">Date de reception definitive</label>
                        <div class="controls">
                            <input type="date" v-model="formEffetFinancier.date_reception"
                                    class="span"
                                    placeholder=""
                            />
                        </div>
                    </div>
                            </td>
                        </tr>

                    </table>  

                   

                
            </div>
            <div class="modal-footer">
                <a v-if="selectionAttributionMarche(marcheid)" @click.prevent="ajouterModalActeEffetFinancierLocal(selectionAttributionMarche(marcheid).dossier_candidature.reg_com)"
                        class="btn btn-primary"
                        href="#"
                >Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>
<!--- fin ajout acte effet financier  -->








<!-- debut modifier acte effet financier --->



<div id="modifierActeEF" class="modal hide grdirModalActeEffet">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modifier acte effet financier</h3>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-striped">
                    <tr>
                        <td>
                            <div class="control-group">
                                <label class="control-label">Type acte effet financier.</label>
                                <div class="controls">
                                    <select v-model="editActeEffetFinancier.type_act_effet_id" class="span">
                                        <option v-for="varText in typeActeEffetFinanciers" :key="varText.id"
                                                :value="varText.id">{{varText.libelle}}</option>
                                    </select>

                                </div>
                            </div>
                        </td>


                        <td>
                            <div class="control-group" v-if="selectionAttributionMarche(marcheid)">
                                <label class="control-label">Entreprise vainqueur </label>
                                <div class="controls" >
                                    <input :value="selectionAttributionMarche(marcheid).dossier_candidature.nom_cand" readonly/>
                                </div>

                            </div>
                            <div class="control-group" v-else>
                                <code>{{message_setion_vainqueur}}</code>

                            </div>
                        </td>


                        <td>
                            <div class="control-group">
                                <label class="control-label">Text juridique </label>
                                <div class="controls">
                                    <select v-model="editActeEffetFinancier.text_juridique_id" class="span">
                                        <option v-for="varText in text_juridiques" :key="varText.id"
                                                :value="varText.id">{{varText.objet_text}}</option>
                                    </select>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="control-group">
                                <label class="control-label">Ano bailleur dmp.</label>
                                <div class="controls">
                                    <input :value="info_avis_bailleur" readonly>

                                </div>
                            </div>
                        </td>


                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <label class="control-label">Autorité approbatrice</label>
                                <div class="controls">
                                    <input
                                            type="text"
                                            v-model="editActeEffetFinancier.autorite_approbation"
                                            class="span"
                                            placeholder=" "
                                    />
                                </div>
                            </div>

                        </td>


                        <td>
                            <div class="control-group">
                                <label class="control-label"> date d'approbation</label>
                                <div class="controls">
                                    <input
                                            type="date"
                                            v-model="editActeEffetFinancier.autorite_approbation"
                                            class="span"
                                            placeholder=""
                                    />
                                </div>
                            </div>

                        </td>


                        <td>

                            <div class="control-group">
                                <label class="control-label">Code acte </label>
                                <div class="controls">
                                    <input
                                            type="text"
                                            v-model="editActeEffetFinancier.code_act"
                                            class="span"
                                            placeholder="Saisir le code acte"
                                    />
                                </div>
                            </div>
                        </td>

                    </tr>
                    <tr>


                        <td colspan="3" width="250">
                            <div class="control-group">
                                <label class="control-label">Libellé acte:</label>
                                <div class="controls">
                                    <textarea   v-model="editActeEffetFinancier.libelle_act"   class="textarea_editor span12" rows="3" placeholder="Entrer le libellé ..."></textarea>
                                </div>

                            </div>
                        </td>



                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <label class="control-label">Reference acte</label>
                                <div class="controls">
                                    <input type="text" v-model="editActeEffetFinancier.reference_act"
                                           class="span"
                                           placeholder="refence acte"
                                    />
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="control-group">
                                <label class="control-label">Incidence financière</label>
                                <div class="controls">
                                    <select  v-model="editActeEffetFinancier.incidence_financiere" class="span">
                                        <option value="0">Oui</option>
                                        <option value="1">Non</option>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>

                            <div class="control-group">
                                <label class="control-label">Montant acte/réel du marché</label>
                                <div class="controls">
                                    <input type="text" v-model="editActeEffetFinancier.montant_act"
                                           class="span"
                                           placeholder="refence acte"
                                    />
                                </div>
                            </div>
                        </td>
                        <td>

                            <div class="control-group">
                                <label class="control-label" >Date de signature attributaire</label>
                                <div class="controls">
                                    <input type="date" v-model="editActeEffetFinancier.date_attributaire"
                                           class="span"
                                           placeholder=""
                                    />
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>


                        <td>
                            <div class="control-group">
                                <label class="control-label">Date ordre de service demarrage</label>
                                <div class="controls">
                                    <input type="date" v-model="formEffetFinancier.date_odre_service"
                                           class="span"
                                           placeholder=""
                                    />
                                </div>
                            </div>
                        </td>


                        <td>
                            <div class="control-group">
                                <label class="control-label" title=" ">Date fin exécution</label>
                                <div class="controls">
                                    <input type="date" :min="formEffetFinancier.date_odre_service" :readonly="getDateFinExécutionValue" v-model="formEffetFinancier.date_fin_exe"
                                           class="span"
                                           placeholder=""
                                    />
                                </div>
                            </div>
                        </td>



                        <td>
                            <div class="control-group">
                                <label class="control-label" title=" ">Durée d'exécution(jrs)</label>
                                <div class="controls">
                                    <input type="text" readonly :value="nombreDejourCalcule"
                                           class="span"
                                    />
                                </div>
                            </div>
                        </td>


                        <td>
                            <div class="control-group">
                                <label class="control-label" title=" ">Date de reception definitive</label>
                                <div class="controls">
                                    <input type="date" v-model="editActeEffetFinancier.date_reception"
                                           class="span"
                                           placeholder=""
                                    />
                                </div>
                            </div>
                        </td>
                    </tr>

                </table>


              


            </div>
             <div class="modal-footer">
                <a
                        @click.prevent="modifierModalActeEffetFinancierLocal"
                        class="btn btn-primary"
                        href="#"

                >Modifier</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>

<!--- fin modifier acte effet financier  -->








<!--modification ano  -->


 <div id="ajouterAnoDMP" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">×</button>
        <h3>Modifier ano dmp</h3>
      </div>
      <div class="modal-body">
       <form class="form-horizontal">
          <div class="control-group">
            <label class="control-label">Date ano</label>
            <div class="controls">
              <input
                type="date"
                v-model="editAno.date_ano_dmp"
                class="span"
                placeholder=""
              />
            </div>
          </div>
            <div class="control-group">
            <label class="control-label">reference ano dmp</label>
            <div class="controls">
              <input
                type="text"
                v-model="editAno.ref_ano_dmp"
                class="span"
                placeholder="Saisir le ref ano dmp"
              />
            </div>
          </div>
         
           <div class="control-group">
            <label class="control-label">Numero courrier</label>
            <div class="controls">
              <input
                type="text"
                v-model="editAno.numero_courie"
                class="span"
                placeholder="Saisir le numero du courrier"
              />
            </div>
          </div>
         </form>
      </div>
      <div class="modal-footer">
        <a
          @click.prevent="ModifierAnoDmpLocal"
          class="btn btn-primary"
          href="#"
         
        >Modifier</a>
        <a data-dismiss="modal" class="btn" href="#">Fermer</a>
      </div>
    </div>

<!--  fin modification ano --->


          </div>
        </div>



                            </ul>
                      
                             




                            </div>


                      <!-- debut item de facture  --->

                               <div id="tab4" class="tab-pane">

                            </div>




                        </div>
                        <div class="modal-footer">
        
        <a data-dismiss="modal" class="btn btn-danger" @click.prevent="retourListeEntreprise" href="#">Voir Tableau Marché</a>
       
      </div>
  
                    </div>

                </div>
            </div>
        </div>

<!-- Ajouter appel offres --->
        <div id="myAlert" class="modal hide tlg" aria-hidden="true" style="display: none;">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter  offre</h3>
            </div>
            
            <div class="modal-body">
                <div class="widget-box">
                    <form action="#" method="get">
                        <table class="table table-bordered table-striped" >
                            <tr>
                            <td>
                        <div class="control-group">
                            <label class="control-label">Type de procedure <code>*</code> :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Type appel" v-model="formData.type_appel" disabled>
                            </div>
                        </div>
                            </td>

                            <td colspan="2" width="250">
                        <div class="control-group">
                            <label class="control-label">Reference  offre <code>*</code> :</label>
                            <div class="controls">
                                <input type="text" class="span5" placeholder="Reference d'appel" v-model="formData.ref_appel">
                            </div>
                        </div>
                            </td>
                            </tr>

                            <tr>
                            <td colspan="3" width="">
                        <div class="control-group">
                            <label class="control-label">Objet  offre :</label>
                            <div class="controls">
                                 <textarea  v-model="formData.objet_appel"  class="textarea_editor span8" rows="3" placeholder="Entre le  text ..."></textarea>
                    
                            </div>
                        </div>
                            </td>
                            </tr>

                            <tr>
                                <td>
                        <div class="control-group">
                            <div class="controls">
                                <label>Date emission <code>*</code></label>
                                <input type="date" class="span" placeholder="Date emision" v-model="formData.date_emission">
                            </div>
                        </div>
                                </td>
                                <td>

                        <div class="control-group">
                            <div class="controls">
                                <label>Date limite <code>*</code></label>
                                <input type="date" class="span" placeholder="Date limite" v-model="formData.date_limite" :min="formData.date_emission">
                            </div>
                        </div>
                        </td>
                        <td >

                        <div class="control-group">
                            <label class="control-label">Imputation :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Imputation" v-model="formData.imputation" disabled>
                            </div>
                        </div>
                        </td>
                        </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="modal-footer">  <a @click.prevent="ajouter" class="btn btn-primary"
                                           href="#">Valider</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>

        <!-- Fin ajouter appel offres --->

        <!--<fab :actions="fabActions" @cache="afficherModalAjouterActeDepense" main-icon="apps" bg-color="green"></fab>-->
        <notifications  />
        <button style="display:none;" v-shortkey.once="['ctrl', 'e']" @shortkey="ExporterEnExel()">Open</button>
        <button style="display:none;" v-shortkey.once="['ctrl', 'f']" @shortkey="afficherModalAjouterActeDepense()">Open</button>

        <!-- Modification appel offres --->

        <div id="modificationModal" class="modal hide taillemodal">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modification  offre</h3>
            </div>
            <div class="modal-body">
                <div class="widget-box">
                    <form action="#" method="get">
                 <table class="table table-bordered table-striped" > 

                    <tr>

                       <td>
                        <div class="control-group">
                            <label class="control-label">Type de procedure  :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="" v-model="edite_appel_offre.type_appel">
                            </div>
                        </div>
                            </td>

                                <td colspan="2" width="250">
                        <div class="control-group">
                            <label class="control-label">Reference  offre  :</label>
                            <div class="controls">
                                <input type="text" class="span5" placeholder="Reference d'appel" v-model="edite_appel_offre.ref_appel">
                            </div>
                        </div>
                            </td>
                    </tr>


                                   <tr>
                            <td colspan="3" width="">
                        <div class="control-group">
                            <label class="control-label">Objet  offre :</label>
                            <div class="controls">
                                 <textarea   v-model="edite_appel_offre.objet_appel"  class="textarea_editor span7" rows="3" placeholder="Entre le  text ..."></textarea>
                    
                            </div>
                        </div>
                            </td>
                            </tr>

                            <tr>
                             <td>
                        <div class="control-group">
                            <div class="controls">
                                <label>Date emission </label>
                                <input type="date" class="span" placeholder="Date emision" v-model="edite_appel_offre.date_emission">
                            </div>
                        </div>
                                </td>


                                 <td colspan="">

                                 <td >


                        <div class="control-group">
                            <div class="controls">
                                <label>Date limite </label>
                                <input type="date" class="span" placeholder="Date limite" v-model="edite_appel_offre.date_limite">
                            </div>
                        </div>
                        </td>

                         <td>
                        
                        <div class="control-group">
                            <label>Imputation</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Imputation" v-model="edite_appel_offre.imputation">
                            </div>
                        </div>
         </td>

                               

                            </tr>

                            
<!-- 
<tr>


          <td>

      

              
                        <div class="control-group">
                             <label>Financement</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Financement" v-model="edite_appel_offre.financement">
                            </div>
                        </div>
         </td>
         <td>
                        <div class="control-group">
                          <label>Nom bailleur</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Nom bailleurs" v-model="edite_appel_offre.nom_bailleurs">
                            </div>
                        </div>

         </td> 
         
        


         
         


                            </tr> -->


                 </table>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" @click.prevent="modfications()">Modifier</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>
        

        

        <!--Gestion de Lot-->

        <div id="addLot" class="modal hide" aria-hidden="true" style="display: none;">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter lot </h3>
            </div>
            <div class="modal-body">
                <div class="widget-box">
                    <form action="#" method="get" v-if="marcheid">

                 <table class="table table-bordered table-striped"> 
                     <tr>
                         <td>
                        <div class="control-group">
                        <label>Offre</label>
                        <div class="controls">
                            <select v-model="formLot.appel_offre_id" class="span" disabled>
                                <option v-for="varText in listeAppelOffre(marcheid)" :key="varText.id"
                                        :value="varText.id">{{varText.ref_appel}}</option>
                            </select>
                        </div>
                        </div>
                         </td>

                         <td>

                         <div class="control-group">
            
                            <label class="control-label">Numero lot <code>*</code> :</label>
                           <div class="control-group">
                       <input type="text" class="span" placeholder="Numero lo" v-model="formLot.numero_lot">
                            </div>
                        </div>

                         
                         </td>
                     </tr>
                     <tr>
                         
                         <td colspan="2">

                        <div class="control-group">

                            <label class="control-label">Libellé lot <code>*</code> :</label>

                            <div class="controls">
                                <input type="text" class="span5" row="2" placeholder="Libellé lot"  v-model="formLot.libelle_lot">
                            </div>
                        </div>
                         </td>
                     </tr>
                     <tr>
                         <td colspan="3">
                        <div class="control-group">

                        
                            <label class="control-label">Montant lot <code>*</code> :</label>

                            <div class="controls">
                                <input type="text" class="span5" placeholder="Montant lot" v-model="formLot.montant_lot">
                            </div>
                        </div>
                         </td>
                     </tr>
                 </table>

                        
                       

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" @click.prevent="ajouterL()">Ajouter</a>
                <a data-dismiss="modal" class="btn btn-inverse" href="#">Cancel</a>
            </div>
        </div>
        <!--Fin gestion de lot-->

        <div id="modificationModal1" class="modal hide taillemodal">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modification de lot</h3>
            </div>
            <div class="modal-body">
                <div class="widget-box">
                    <form action="#" method="get">

                     <table class="table table-bordered table-striped"> 

                         <tr>
                         

                       <td>
                        <div class="control-group">
                        <label>Offre</label>
                        <div class="controls">
                            <select v-model="edite_lot.appel_offre_id" class="span" disabled>
                                <option v-for="varText in listeAppelOffre(marcheid)" :key="varText.id"
                                        :value="varText.id">{{varText.ref_appel}}</option>
                            </select>
                        </div>
                        </div>
                         </td>



                            <td>
                        <div class="control-group">
                            <label class="control-label">Numero lot :</label>
                            <div class="controls">
                                <input type="text" class="span5" placeholder="Numero lo" v-model="edite_lot.numero_lot">
                            </div>
                        </div>
                            </td>
                         </tr>
                         <tr>
                             <td colspan="2">
                        <div class="control-group">
                            <label class="control-label">Libellé lot :</label>
                            <div class="controls">
                                <input type="text" class="span5" placeholder="Libellé lot" v-model="edite_lot.libelle_lot">
                            </div>
                        </div>
                             </td>
                         </tr>
                         <tr>
                             <td colspan="3">
                        <div class="control-group">
                            <label class="control-label">Montant lot :</label>
                            <div class="controls">
                                <input type="text" class="span5" placeholder="Montant lot" v-model="edite_lot.montant_lot">
                            </div>
                        </div>
                             </td>
                         </tr>
                     </table>
                        
                        <!-- <label>Mode de passation</label>
                        <div class="controls">
                            <select v-model="edite_lot.mode_passation_id" class="span">
                                <option v-for="varText in modePassations" :key="varText.id"
                                        :value="varText.id">{{varText.libelle}}</option>
                            </select>
                        </div> -->

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" @click.prevent="modficationsLot()">Modifier</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>


        <!--contratualisation-->
        <!--dossier candidature-->
        <div id="offreT" class="modal hide tailleModalOffre2">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter l'offre technique</h3>
            </div>
            <div class="modal-body">
                <div class="widget-box">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>
 <div class="control-group">
                            <label>Liste lot</label>
                            <div class="controls">
                                <select v-model="formOffreTechnique.numero_lot" class="span">
                                    <option v-for="varText in listeLots(marcheid)" :key="varText.numero_lot"
                                            :value="varText.id">{{varText.numero_lot}}-{{varText.libelle_lot}}</option>
                                </select>
                            </div>
                        </div>
                            </td>
                            <td>
                                  <div class="control-group">
                            <label class="control-label">Accord groupe :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Accord groupe" v-model="formOffreTechnique.accord_groupe">
                            </div>
                        </div>
                            </td>
                            <td>
                                 <div class="control-group">
                            <label class="control-label">Cautionnement prov :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Cautionnement prov" v-model="formOffreTechnique.cautionnement_prov">
                            </div>
                        </div>
                            </td>
                            <td>
                                 <div class="control-group">
                            <label class="control-label">Attest banc:</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Pouv habil" v-model="formOffreTechnique.attest_banc">
                            </div>
                        </div>
                            </td>
                            <td>
                                  <div class="control-group">
                            <label class="control-label">Formil propo tech :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Piece Admin" v-model="formOffreTechnique.formil_propo_tech">
                            </div>
                        </div>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                             <tr>
                            <td>
<div class="control-group">
                            <label class="control-label">Fiche rsgnt nombre groupe :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Attest banc" v-model="formOffreTechnique.fiche_rsgnt_mbre_groupe">
                            </div>
                        </div>
                            </td>
                            <td>
                                 
                        <div class="control-group">
                            <label class="control-label">Atcdent marche non exe :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Org travau" v-model="formOffreTechnique.atcdent_marche_non_exe">
                            </div>
                        </div>
                            </td>
                            <td>
                                <div class="control-group">
                            <label class="control-label">Org travau site :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Meth real travau" v-model="formOffreTechnique.org_travau_site">
                            </div>
                        </div>
                            </td>
                            <td>
                                 <div class="control-group">
                            <label class="control-label">Meth real travau:</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Prog mobilisation" v-model="formOffreTechnique.meth_real_travau">
                            </div>
                        </div>
                            </td>
                            <td>
                               <div class="control-group">
                            <label class="control-label">Prog mobilisation :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Prog mobilisation" v-model="formOffreTechnique.prog_mobilisation">
                            </div>
                        </div> 
                            </td>
                           
                        </tr>
                        <tr>
                             <td>
                                <div class="control-group">
                            <label class="control-label">Capacite financiere :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Capacite financiere" v-model="formOffreTechnique.capacite_financiere">
                            </div>
                        </div>
                            </td>
                            <td>
                                 <div class="control-group">
                            <label class="control-label">CAA moyen ac entre :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Caa moyen ac" v-model="formOffreTechnique.caa_moyen_ac_entre">
                            </div>
                        </div>
                            </td>
                            <td>
                                <div class="control-group">
                            <label class="control-label">Capacite techn expe :</label>
                            <div class="controls">
                                <input type="text" class="span" placeholder="Capacite techn exp" v-model="formOffreTechnique.capacite_techn_exp">
                            </div>
                        </div>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button @click.prevent="ajouterOffreT" class="btn btn-primary">Ajouer</button>
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>
        <div id="offreF" class="modal hide modaloffreFin">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter l'offre financière</h3>
            </div>
            <div class="modal-body">
                   <table class="table table-bordered table-striped">
         
            <tr>
              <td>
                <div class="control-group">
              
                  <label>Liste lot</label>
                                <div class="controls">
                                    <select v-model="formOffreFinanciere.numero_lot" class="span">
                                        <option v-for="varText in listeLots(marcheid)" :key="varText.numero_lot"
                                                :value="varText.id">{{varText.numero_lot}}</option>
                                    </select>
                                </div>
                </div>
              </td>
              <td colspan="2">
                <div class="control-group">
                    <label class="control-label">Designation :</label>
                            <div class="controls">
                                <input type="text"  readonly   class="span6" placeholder="Designation" :value="libelleLot">
                            </div>
                </div>
              </td>
               
            </tr>
            <tr>
                <td>
              
              <div class="control-group">
                            <label class="control-label">Quantite :</label>
                            <div class="controls">
                                <input type="number" class="span" placeholder="quantite" v-model="formOffreFinanciere.quantite">
                            </div>
                        </div>
              
              </td>
              <td>
              
                <div class="control-group">
                            <label class="control-label">Prix unitaire :</label>
                            <div class="controls">
                                <input type="number" class="span" placeholder="prix unitaire" v-model="formOffreFinanciere.prix_unitaire">
                            </div>
                        </div>
              </td>
              <td>
                  <div class="control-group">
                            <label class="control-label">Taux</label>
                            <div class="controls">
                                <input type="text" readonly  class="span" :value="affcherTauxEnCours">
                                 <input
                    type="hidden"
                    :value="tauxArrondit"
                   
                    class="span3"
                   
                  />
                            </div>
                        </div>
              </td>
              
              
            </tr>
            <tr>
              <td>
                  <div class="control-group">
                  <label class="control-label">Tva</label>
                  <div class="controls">
                    <input type="number" readonly :value="montantTva" class="span" />
                  </div>
                </div>
              </td>
              <td>
                <div class="control-group">
                            <label class="control-label">Montant total ht :</label>
                            <div class="controls">
                                <input type="text"   readonly  class="span" placeholder="Montant total HT" :value="montantHT">
                            </div>
                        </div>
              </td>
              <td>
                <div class="control-group">
                            <label class="control-label">Montant totat ttc :</label>
                            <div class="controls">
                                <input type="text"  readonly  class="span" placeholder="Montant total ttc" :value="montantHTt">
                            </div>
                        </div>
              </td>
              
            </tr>
          
        </table>
                
            </div>
            <div class="modal-footer">
                <button @click.prevent="ajouterOffreF()" class="btn btn-primary">Ajouer</button>
                <!--<a data-dismiss="modal" class="btn btn-primary" href="#" @click.prevent="ajouterOffreF()"> Ajouter</a>-->
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>
        <!--Fin dossier candidature ajouterMantater-->

           <!--Lettre d'invitation-->
        <div id="ajouterLettreInvitation" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter lettre d'invitation</h3>
            </div>
            <div class="modal-body">
           
                <form class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Offre</label>
                        <div class="controls">
                            <select v-model="formLettre.appel_offre_id" class="span" disabled>
                                <option v-for="plans in listeAppelOffre(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.ref_appel}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Date lettre</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="formLettre.date_lettre"
                                    class="span"
                                    placeholder="Saisir le nom_bailleur"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Refernece lettre</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="formLettre.ref_lettre"
                                    class="span"
                                    placeholder="Saisir l"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Destinataire</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="formLettre.destination"
                                    class="span"
                                    placeholder="Saisir "
                            />
                        </div>
                    </div>


                      <div class="control-group">
          <label class="control-label">Objet de lettre:</label>
            <div class="controls">
              <textarea  v-model="formLettre.objet_lettre"  class=" span" rows="" placeholder="Enter text ..."></textarea>
            </div>
          
        </div>



                    <div class="control-group">
                        <label class="control-label">Date cojo</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="formLettre.date_cojo"
                                    class="span"
                                    placeholder="Saisir email bailleur"
                            />
                        </div>
                    </div>

                   <div class="control-group">
                   <label class="control-label">Fichier joint:</label>
                    <div class="controls">
                     <input type="file"   @change="OnchangeFichier" />
              </div>
            </div>
                </form>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary" @click.prevent="ajouterLettreInv()" href="#">Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>
        <div id="modificationLettreInvitation" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modification lettre invitation</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">


                    <div class="control-group">
                        <label class="control-label">Offre</label>
                        <div class="controls">
                            <select v-model="edite_lettre_invitation.appel_offre_id" class="span" disabled>
                                <option v-for="plans in listeAppelOffre(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.ref_appel}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Date lettre</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="edite_lettre_invitation.date_lettre"
                                    class="span"
                                    placeholder="Saisir le nom_bailleur"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Refernece lettre</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="edite_lettre_invitation.ref_lettre"
                                    class="span"
                                    placeholder="Saisir l"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Destination</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="edite_lettre_invitation.destination"
                                    class="span"
                                    placeholder="Saisir "
                            />
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Date cojo</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="edite_lettre_invitation.date_cojo"
                                    class="span"
                                    placeholder=""
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Fichier</label>
                        <div class="controls">
                            <input type="file"   @change="OnchangeFichier" />
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary" @click.prevent="modificationLettreInvitation()" href="#">Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>
        <!--Fin lettre d'invitation-->

        <!--Mandater-->
        <div id="ajouterMantater" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter mandater</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">


                    <div class="control-group">
                        <label class="control-label">Lettre Invitation</label>
                        <div class="controls">
                            <select v-model="formMandater.lettre_invitation_id" class="span">
                                <option v-for="plans in lettreInvitationAMarche(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.ref_lettre}}</option>
                            </select>
                        </div>
                    </div>

                    <!--
                    54ABN5
                    AMP45
                    54ABN5
                    AR458
                    -->
                    <div class="control-group">
                        <label class="control-label">Matricule</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="formMandater.matricule_m"
                                    class="span"
                                    placeholder="Matricule" v-on:keyup="rechercheMandater()"
                            />
                            <code v-if="message_mandater">{{message_mandater}}</code>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nom</label>
                        <div class="controls">
                            <input type="text"
                                    v-model="formMandater.nom_mandat"
                                    class="span"
                                    placeholder="Nom mandater"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Prenom</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="formMandater.prenom_nom"
                                    class="span"
                                    placeholder="Prenom "
                            />
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Date</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="formMandater.date_id"
                                    class="span"

                            />
                        </div>
                    </div>



                </form>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary" @click.prevent="ajouterMandaterA()" href="#">Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>
        <div id="modificationMantater" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modification de mandater</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">


                    <div class="control-group">
                        <label class="control-label">Lettre Invitation</label>
                        <div class="controls">
                            <select v-model="editer_mandater.lettre_invitation_id" class="span">
                                <option v-for="plans in lettreInvitationAMarche(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.ref_lettre}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Matricule :</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="editer_mandater.matricule_m"
                                    class="span"
                                    placeholder="Matricule"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nom mandater :</label>
                        <div class="controls">
                            <input type="text"
                                   v-model="editer_mandater.nom_mandat"
                                   class="span"
                                   placeholder="Nom mandater"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Prenom :</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="editer_mandater.prenom_nom"
                                    class="span"
                                    placeholder="Prenom "
                            />
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Date</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="editer_mandater.date_id"
                                    class="span"

                            />
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary" @click.prevent="modificationMandater()" href="#">Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>
        <!--Fin mandater-->

        <!--Mandater-->
        <div id="ajouterCojo" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter Cojo</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Numero dossier APPEL OFFRE</label>
                        <div class="controls">
                            <input disabled
                                   type="text"
                                   v-model="formDataCojo.num_dossier_appel_offre"
                                   class="span"
                            />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Lettre Invitation</label>
                        <div class="controls">
                            <select v-model="formDataCojo.lettre_invitation_id" class="span" disabled>
                                <option v-for="plans in lettreInvitationAMarche(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.ref_lettre}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Date invitation</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="formDataCojo.date_invitation"
                                    class="span"
                                       disabled
                            />
                        </div>
                    </div>
                    <div class="control-group">
                          <label class="control-label">Controleur finnancier</label>
                        <div class="controls">
                            <input disabled
                                    type="text"
                                    v-model="formDataCojo.controleur_finnancier"
                                    class="span"
                                    placeholder="Controller Finnancier"
                            />
                        </div>
                    </div>
                   <!-- <div class="control-group">
                        <label class="control-label">Condition</label>
                        <div class="controls">
                            <select v-model="formDataCojo.condition_id" class="span">
                                <option v-for="plans in conditions" :key="plans.id"
                                        :value="plans.id">{{plans.libelle}}</option>
                            </select>
                        </div>
                    </div>-->


                    <div class="control-group">
                        <label class="control-label">Date composition</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="formDataCojo.date_composition"
                                    class="span"
                 :min="formDataCojo.date_invitation"
                            />
                        </div>
                    </div>




                    <div class="control-group">
                        <label class="control-label">NBR participant</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="formDataCojo.nbr_participant"
                                    class="span"
                            />
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary" @click.prevent="ajouterCojoMarche()" href="#">Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>

        <div id="modificationCojo" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modification de cojo</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">


                    <div class="control-group">
                        <label class="control-label">Numero dossier APPEL OFFRE</label>
                        <div class="controls">
                            <input disabled
                                    type="text"
                                    v-model="edite_cojo.num_dossier_appel_offre"
                                    class="span"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Lettre Invitation</label>
                        <div class="controls">
                            <select v-model="edite_cojo.lettre_invitation_id" class="span" disabled>
                                <option v-for="plans in lettreInvitationAMarche(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.ref_lettre}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Date invitation</label>
                        <div class="controls">
                            <input disabled
                                   type="date"
                                   v-model="edite_cojo.date_invitation"
                                   class="span"

                            />
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Date composition</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="edite_cojo.date_composition"
                                    class="span"

                            />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">NBR participant</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="edite_cojo.nbr_participant"
                                    class="span"
                            />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary" @click.prevent="modificationCojo()" href="#">Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>
        <!--Fin mandater-->

        <!--Analyse dossier-->
        <div id="ajouterMP" class="modal hide grdirModalAnalyse">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter dossier analyse</h3>
            </div>

                <table class="table table-bordered table-striped">
                        <tr>
                            <td>
                        <div class="control-group">
                        <label class="control-label">Reference offre</label>
                        <div class="controls">
                            <select v-model="formAnalyseDossier.appel_offre_id" class="span" disabled>
                                <option v-for="plans in listeAppelOffre(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.ref_appel}}</option>
                            </select>
                        </div>
                        </div>
                            </td>
                            <td>
                     <div class="control-group">
                        <label class="control-label">Dossier candidat</label>
                        <div class="controls">
                            <select v-model="formAnalyseDossier.dossier_candidat_id" class="span">
                                <option v-for="plans in dossierCandidature(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.nom_cand}}</option>
                            </select>
                        </div>
                    </div>
                            </td>


                     <td>
                       
                    <div class="control-group">
                        <label class="control-label">Controleur financier</label>
                        <div class="controls">
                            <select v-model="formAnalyseDossier.cojo_id" class="span">
                                <option v-for="plans in listeCojo(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.controleur_finnancier}}</option>
                            </select>
                        </div>
                    </div>
                            </td>

                              <td>
                        <div class="control-group">
                        <label class="control-label">Type analyse</label>
                        <div class="controls">
                            <select v-model="formAnalyseDossier.type_analyse_id" class="span">
                                <option v-for="plans in typeAnalyses" :key="plans.id"
                                        :value="plans.id">{{plans.libelle}}</option>
                            </select>
                        </div>
                    </div>
                            </td>
                           
                       
                           </tr>
                           
                        <tr>
                   
                            <td>
                     <div class="control-group">
                        <label class="control-label">Note</label>
                        <div class="controls">
                            <input type="text"
                                   v-model="formAnalyseDossier.note_analyse"
                                   class="span"
                                   placeholder="Saisir la note"
                            />
                        </div>
                    </div>

                            </td>
                        
                   
                            <td>

                    <div class="control-group">
                        <label class="control-label">Rang</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="formAnalyseDossier.rang_analyse"
                                    class="span"
                                    placeholder="Rang d'analyse"
                            />
                        </div>
                    </div>
                            </td>
                            <td colspan="2">
                    <div class="control-group">
                        <label class="control-label">Date</label>
                        <div class="controls">
                            <input type="date"
                                   v-model="formAnalyseDossier.date_analyse"
                                   class="span5"
                                   placeholder="date"
                            />
                        </div>
                    </div>
                            </td>

                                  <!-- <td>
                    <div class="control-group">
                        <label class="control-label">Decision</label>
                        <div class="controls">
                            <select v-model="formAnalyseDossier.decision" >
                                <option value="1">Non objection</option>
                                <option value="2">Objection</option>
                            </select>
                        </div>
                    </div>
                            </td> -->
                        </tr>
                        <!-- <tr>
                      
                            <td colspan="4">
                     <div class="control-group">
          <label class="control-label">Obseravtion:</label>
            <div class="controls">
              <textarea  v-model="formAnalyseDossier.motif" :readonly="afficherMotifAnalyse"  class="textarea_editor span10" rows="4" placeholder="Entrer le text ..."></textarea>
            </div>
          
        </div>
                            </td>
                           
                      
                        </tr> -->

                    </table>
            
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary" @click.prevent="ajouterAnalyseD()" href="#">Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>


        <div id="modificationAajouterAnalys01" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modification du dossier Analyse</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">


                    <div class="control-group">
                        <label class="control-label">Dossier candidat</label>
                        <div class="controls">
                            <select v-model="edite_analyse_dossier.dossier_candidat_id" class="span">
                                <option v-for="plans in dossierCandidature(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.nom_cand}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Controleur financier</label>
                        <div class="controls">
                            <select v-model="edite_analyse_dossier.cojo_id" class="span">
                                <option v-for="plans in listeCojo(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.controleur_finnancier}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Type analyse</label>
                        <div class="controls">
                            <select v-model="edite_analyse_dossier.type_analyse_id" class="span">
                                <option v-for="plans in typeAnalyses" :key="plans.id"
                                        :value="plans.id">{{plans.libelle}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Rang analyse :</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="edite_analyse_dossier.rang_analyse"
                                    class="span"
                                    placeholder="Rang d'analyse"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Date :</label>
                        <div class="controls">
                            <input type="date"
                                   v-model="edite_analyse_dossier.date_analyse"
                                   class="span"
                                   placeholder=""
                            />
                        </div>
                    </div>

                     <div class="control-group">
                        <label class="control-label">Note</label>
                        <div class="controls">
                            <input type="text"
                                   v-model="edite_analyse_dossier.note_analyse"
                                   class="span"
                                   placeholder=""
                            />
                        </div>
                    </div>


                    <!-- <div class="control-group">
                        <label class="control-label">Decision</label>
                        <div class="controls">
                            <select   v-model="edite_analyse_dossier.decision" >
                                <option value="1">Non objection</option>
                                <option value="2">Objection</option>
                            </select>
                        </div>
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary" @click.prevent="modificationDossierAnalyse()" href="#">Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
        </div>
        <!--Fin cojo-->

        <!--  debut modal ajout demande ano   -->


        <div id="ajouterDemandeAno" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter demande ANO</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">


                 <div class="control-group">
                        <label class="control-label">reference offre</label>
                        <div class="controls">
                            <input disabled
                                    type="text"
                                    v-model="formDemande.ref_marche	"
   Ajouter avis bailleur                                 class="span"
                                    placeholder="Saisir le ref marche"
                            />
                        </div>
                    </div>


                     <div class="control-group">
                        <label class="control-label">PV</label>
                        <div class="controls" v-if="listePVDemandePV(marcheid)">
                            <select v-model="formDemande.proce_verbal_jugement_offre_id" class="span">
                                <option :value="listePVDemandePV(marcheid).id">{{listePVDemandePV(marcheid).reference}}</option>
                            </select>
                        </div>
                    </div>


                     <div class="control-group">
                        <label class="control-label">Numero du courrier</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="formDemande.num_courrier"
                                    class="span"
                                    placeholder="Saisir le numero du courrier"
                            />
                        </div>
                    </div>

                    <div class="control-group">

                        <label class="control-label">Date de demande</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="formDemande.date_demande"
                                    class="span"
                                    placeholder="Saisir le libelle_type"
                            />
                        </div>
                    </div>

                    <!-- <div class="control-group">

                        <label class="control-label">Avis</label>
                        <div class="controls">
                           <select v-model="formDemande.avis_ano" class="span">

                               <option value="1"> Objection</option>
                               <option value="2"> Non objection</option>
                           </select>
                        </div>
                    </div> -->
<!-- 
                  <div class="control-group">
          <label class="control-label">Observation:</label>
            <div class="controls">

              <textarea  v-model="formDemande.observations_ano" :readonly="motifDemandeAno"  class="textarea_editor" rows="" placeholder="Entrer  le text ..."></textarea>
            </div>
          
        </div> -->

         <div class="control-group">
              <label class="control-label">Fichier joint:</label>
              <div class="controls">
                <input type="file" @change="OnchangeFichierDemandeAno" />
              </div>
            </div>

                </form>
            </div>
            <div class="modal-footer">
                <a
                        @click.prevent="ajouterDemandeAnoLocal()"
                        class="btn btn-primary"
                        href="#"

                >Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>


        <div id="modifDemandeAno" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modification ANO</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">

                     <div class="control-group">
                        <label class="control-label">reference marché</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="edite_demande_dao.ref_marche	"
                                    class="span"
                                    placeholder="Saisir le ref marche"
                            />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">PV</label>
                        <div class="controls" v-if="edite_demande_dao">
                          <input :value="edite_demande_dao.proce_verbal_offre.reference" readonly/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Numero du courrier</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="edite_demande_dao.num_courrier"
                                    class="span"
                                    placeholder="Saisir le numero du courrier"
                            />
                        </div>
                    </div>

                    <div class="control-group">

                        <label class="control-label">Date de demande</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="edite_demande_dao.date_demande"
                                    class="span"
                                    placeholder="Saisir le libelle_type"
                            />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Fichier joint:</label>
                        <div class="controls">
                            <input type="file" @change="OnchangeFichierDemandeAno" />
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <a
                        @click.prevent="editDemandeDAO()"
                        class="btn btn-primary"
                        href="#"

                >Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>
        <!---  fin modal ajout demande ano  -->

        <!--Annalyse DMP-->
        <div id="ajouterDmp" class="modal hide tailDMP">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter avis dmp</h3>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
         
            <tr>
              <td>
                 <div class="control-group">
                        <label class="control-label">Reference d'offre</label>
                        <div class="controls">
                        <input type="text" :value="afficherIdMarche(detail_marche.id)" class="span4" readonly>
                        </div>
                    </div>
              </td>
               <td>
                <div class="control-group">
                        <label class="control-label">Reference courrier ano</label>
                        <div class="controls" v-if="demandeAnoAnalyseDMP(marcheid)">
                        <input type="text" :value="demandeAnoAnalyseDMP(marcheid).num_courrier" class="span4" readonly>
                        </div>
                    </div>
              </td>
            </tr>

            <tr>
                <td>
                    <div class="control-group">
                        <label class="control-label">PV</label>
                        <div class="controls" v-if="demandeAnoAnalyseDMP(marcheid)">
                            <input type="text" :value="demandeAnoAnalyseDMP(marcheid).proce_verbal_offre.reference" class="span4" readonly>
                        </div>
                    </div>
                </td>
              <td>
                <div class="control-group">
                  <label class="control-label">Avis</label>
                  <div class="controls">
                    <select v-model="formAnalyseDMP.avis_bail" class="span4">
                      <option value="0" >Objection</option>
                       <option value="1" >Non objection</option>
                    </select>
                  </div>
                </div>
              </td>
             

            </tr>
            <tr>
                <td>
                    <div class="control-group">
                        <label class="control-label">Date avis</label>
                        <div class="controls">
                            <input type="date" v-model="formAnalyseDMP.date_avis_bail" class="span4">
                        </div>
                    </div>
                </td>
            <td >
                <div class="control-group">
                        <label class="control-label">Observation</label>
                        <div class="controls">
                       
                        <textarea v-model="formAnalyseDMP.observation" rows="2" class="span4" :readonly="verrouObjection">

                        </textarea>
                        </div>
                    </div>
              </td>
            </tr>
                </table>
            </div>
            <div class="modal-footer">
                <a @click.prevent="ajouterAnalyseDMPB"
                        class="btn btn-primary"
                        href="#"
                >Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>

        <div id="editeDMP" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modifie Analyse DMP</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">

                    <!-- <div class="control-group">
                        <label class="control-label">Reference Dmp</label>
                        <div class="controls">
                        <input type="text" v-model="edite_analyse_dpm.ref_dmp" class="span">
                        </div>
                    </div>-->

                     <div class="control-group" v-if="edite_analyse_dpm">
                        <label class="control-label">Courier ano</label>
                        <div class="controls" >
                            <select v-model="edite_analyse_dpm.demande_ano_id" class="span" disabled>
                                <option v-for="varText in demandeAno(marcheid)" :key="varText.id"
                                        :value="varText.id">{{varText.num_courrier}}</option>
                            </select>
                        </div>
                    </div>

                      <div class="control-group">
                        <label class="control-label">Decision</label>
                        <div class="controls">
                          <select v-model="edite_analyse_dpm.avis_bail" class="span">
                                <option value="0">Objection</option>
                                <option value="1">Non objection</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Date avis</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="edite_analyse_dpm.date_avis_bail"
                                    class="span"
                                    placeholder="Saisir le libelle_type"
                            />  
                        </div>
                    </div>
                  

                    <div class="control-group">
                        <label class="control-label">Observation</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="edite_analyse_dpm.observation"
                                    class="span"
                                    placeholder="Saisir le libelle_type"
                            />
                        </div>
                    </div>
                   
                    <!-- <div class="control-group">
                        <label class="control-label">document procedure</label>
                        <div class="controls">
                            <select v-model="edite_analyse_dpm.document_procedure_id" class="span">
                                <option v-for="varText in documentProcedures" :key="varText.id"
                                        :value="varText.id">{{varText.libelle_doc}}</option>
                            </select>
                        </div>
                    </div> -->   

                </form>
            </div>
            <div class="modal-footer">
                <a @click.prevent="modficationsAnalyseDMP"
                   class="btn btn-primary"
                   href="#"
                >Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>
        <!--Fin annalyse-->

        <!--- debut ano -->


        <div id="ajouterAnoDMPBAILLEURModal" class="modal hide tlAviBailleur">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Ajouter avis bailleur</h3>
            </div>
                <table class="table table-bordered table-striped">
                        <tr>
                            <td>
                        <div class="control-group">
                        <label class="control-label">Reference offre</label>
                        <div class="controls">
                            <select v-model="formAno.appel_offre_id" class="span" disabled>
                                <option v-for="plans in listeAppelOffre(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.ref_appel}}</option>
                            </select>
                        </div>
                    </div>
                            </td>
                          <!--  analyseDMPValider-->
                            <td>
                      <div class="control-group">
                        <label class="control-label">Avis DMP</label>
                        <div class="controls">
                            <input type="text" :value="avis_dmp" readonly class="span">
                        </div>
                     </div>
                            </td>

                            <td>
                     <div class="control-group">
                        <label class="control-label">Reference du  courrier </label>
                        <div class="controls">
                            <input
                                    type="text"
                                  v-model="formAno.numero_courie"  
                                    class="span"
                                    placeholder="saisir la reference du courrier"
                            />
                        </div>
                    </div>
                            </td>
                           
                       
                           </tr>
                           
                        <tr>
                            <td>
                                <div class="control-group" v-if="analyseDMPValider(marcheid)">
                                    <label class="control-label">Reference PV</label>
                                    <div class="controls">
                                        <input type="text" :value="analyseDMPValider(marcheid).demande_ano.proce_verbal_offre.reference" readonly class="span">
                                    </div>
                                </div>
                            </td>


                            <td>
                      <div class="control-group">
                       <label class="control-label">Avis bailleur</label>
                       <div class="controls">
                       <select v-model="formAno.avis_bail" class="span">
                           <option value="1">Non objection</option>
                            <option value="2">Objection</option>
                           </select> 
                       </div>
                         </div>
                            </td>
                   
                            <td>

                      <div class="control-group">
                        <label class="control-label">Date avis</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="formAno.date_ano_dmp"
                                    class="span"
                                    placeholder=""
                            />
                        </div>
                        </div>
                            </td>

                      

                     
                        </tr>
                        <tr>
                            <td>

                                <div class="control-group">
                                    <label class="control-label">Fichier joint:</label>
                                    <div class="controls">
                                        <input type="file"  @change="OnchangeFichier" />
                                    </div>
                                </div>
                            </td>
                            <td colspan="2">
                     <div class="control-group">
          <label class="control-label">Observation:</label>
            <div class="controls">
              <textarea  v-model="formAno.observations_bailleur" :readonly="afficherMotifBailleur"  class="textarea_editor span7" rows="3" placeholder="Entrer le text ..."></textarea>
            </div>
          
        </div>
                            </td>
                           
                      
                        </tr>

                    </table>


            <div class="modal-footer">
                <a
                        @click.prevent="ajouterAnoDMPBailleurLocal"
                        class="btn btn-primary"
                        href="#"

                >Valider</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>

        <!--- fin ano  -->

        <!---->
        
        <div id="editeAnoDmpBailleurModal" class="modal hide tlAviBailleur">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Modification avis bailleur</h3>
            </div>
                    <table class="table table-bordered table-striped">
                        <tr>

                               <td>
                        <div class="control-group" v-if="edite_ano_bailleur_dmp">
                        <label class="control-label">Reference offre</label>
                        <div class="controls">
                            <select v-model="edite_ano_bailleur_dmp.annalyse_d_m_p.demande_ano.proce_verbal_offre.appel_offre_id" class="span" disabled>
                                <option v-for="plans in listeAppelOffre(marcheid)" :key="plans.id"
                                        :value="plans.id">{{plans.ref_appel}}</option>
                            </select>
                        </div>
                    </div>
                            </td>

                            <td>

                     <div class="control-group">
                        <label class="control-label">Avi dmp</label>
                        <div class="controls">
                            <input
                                    type="text"
                                    v-model="edite_ano_bailleur_dmp.ref_ano_dmp	"
                                    class="span"
                                    placeholder="Saisir le ref marche"
                            />
                        </div>
                    </div>
                            </td>
                   
                
                      <td colspan="2">


                     <div class="control-group">
                        <label class="control-label">Reference du courrier</label>
                        <div class="controls">
                            <input
                                    type="text" v-model="edite_ano_bailleur_dmp.numero_courie"
                                    
                                    class="span5"
                                    placeholder="Saisir le numero du courrier"
                            />
                        </div>
                    </div>
                            </td>
                        </tr>
                        <tr>
                           <td>
                      <div class="control-group">
                       <label class="control-label">Avis bailleur</label>
                       <div class="controls">
                       <select v-model="edite_ano_bailleur_dmp.avis_bail" class="span">
                           <option value="1">Non objection</option>
                            <option value="2">Objection</option>
                           </select> 
                       </div>
                    </div>

                            </td>
                            <td>

                     <div class="control-group">
                        <label class="control-label">Date avis</label>
                        <div class="controls">
                            <input
                                    type="date"
                                    v-model="edite_ano_bailleur_dmp.date_ano_dmp"
                                    class="span"
                                    placeholder="Saisir le libelle_type"
                            />
                        </div>
                    </div>
                            </td>
                                 <td>
                                
                 <div class="control-group">
              <label class="control-label">Fichier joint:</label>
              <div class="controls">
                <input type="file"  @change="OnchangeFichier" />
              </div>
            </div>
                            </td>
                        </tr>
                         <tr>
                      
                            <td colspan="4">
                     <div class="control-group">
            <label class="control-label">Motif:</label>
            <div class="controls">
              <textarea  v-model="edite_ano_bailleur_dmp.observations_bailleur"   class="textarea_editor span10" rows="4" placeholder="Enter text ..."></textarea>
              </div>
          
        </div>
                            </td>
                           
                      
                        </tr>
                    </table>   
            <div class="modal-footer">
                <a
                 @click.prevent="editeAnoDMPBailleurLocal"
                        class="btn btn-primary"
                        href="#"

                >Modifier</a>
                <a data-dismiss="modal" class="btn" href="#">Fermer</a>
            </div>
        </div>



    <div id="ajouter_membre_cojo" class="modal hide" aria-hidden="true" style="display: none;">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>Ajouter un autre membre de la cojo </h3>
        </div>
        <div class="modal-body">
            <div class="widget-box">
                <form action="#" method="get" v-if="marcheid">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label>Matricule</label>
                                    <div class="controls">
                                        <input type="text" class="span" placeholder="Matricule " v-model="formDataMembreCojo.matricule" v-on:keyup="rechercheMembreCojo()" >
                                        <code v-if="message_mandater">{{message_mandater}}</code>
                                    </div>
                                </div>
                            </td>

                            <td>

                                <div class="control-group">

                                    <label class="control-label">Nom et prenom <code>*</code> :</label>
                                    <div class="control-group">
                                        <input type="text" class="span" placeholder="Numero lo" v-model="formDataMembreCojo.nom_prenom">


                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>

                            <td colspan="2">

                                <div class="control-group">

                                    <label class="control-label span5">Role <code>*</code> :</label>

                                    <div class="controls">
                                        <select class="span4" v-model="formDataMembreCojo.role">
                                            <option></option>
                                            <option value="Autorité contractante">Autorité contractante</option>
                                            <option value="DMP">Direction des marchés publique</option>
                                            <option value="Béneficiare">Béneficiaire</option>
                                            <option value="Rapporteur">Rapporteur</option>
                                            <option value="Service technique">Service technique</option>
                                            <option value="Autre">Autre</option>
                                        </select>

                                    </div>
                                </div>
                            </td>
                        </tr>

                    </table>




                </form>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" @click.prevent="ajouterMembreCojoM()">Ajouter</a>
            <a data-dismiss="modal" class="btn btn-inverse" href="#">Cancel</a>
        </div>
    </div>

    <div id="modification_membre_cojo" class="modal hide" aria-hidden="true" style="display: none;">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>modification  </h3>
        </div>
        <div class="modal-body">
            <div class="widget-box">
                <form action="#" method="get" v-if="marcheid">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label>Matricule</label>
                                    <div class="controls">
                                        <input type="text" class="span" placeholder="Matricule " v-model="edite_membre_cojo.matricule"  >
                                        <code v-if="message_mandater">{{message_mandater}}</code>
                                    </div>
                                </div>
                            </td>

                            <td>

                                <div class="control-group">

                                    <label class="control-label">Nom et prenom <code>*</code> :</label>
                                    <div class="control-group">
                                        <input type="text" class="span" placeholder="Numero lo" v-model="edite_membre_cojo.nom_prenom">


                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>

                            <td colspan="2">

                                <div class="control-group">

                                    <label class="control-label span5">Role <code>*</code> :</label>

                                    <div class="controls">
                                        <select class="span4" v-model="edite_membre_cojo.role">
                                            <option></option>
                                            <option value="Controller finnancier">Controller finnancier</option>
                                            <option value="Autorité contractante">Autorité contractante</option>
                                            <option value="DMP">Direction des marchés publique</option>
                                            <option value="Béneficiare">Béneficiaire</option>
                                            <option value="Rapporteur">Rapporteur</option>
                                            <option value="Service technique">Service technique</option>
                                            <option value="Autre">Autre</option>
                                        </select>

                                    </div>
                                </div>
                            </td>
                        </tr>

                    </table>




                </form>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" @click.prevent="editeMembreCojoM()">Ajouter</a>
            <a data-dismiss="modal" class="btn btn-inverse" href="#">Cancel</a>
        </div>
    </div>

        <!---->
        <!--Fin contratualisation-->
 
</div>

</template>

<script>
    import { mapGetters, mapActions } from "vuex";
    import moment from 'moment';
    import bailleurAjouter from '../dossierComponent/bailleurAjouter'
    //import {getterDossierCandidats} from "../../../vuex/modules/fabrice/bienService/Getters";
    import {  ModelListSelect } from 'vue-search-select'
    import 'vue-search-select/dist/VueSearchSelect.css'
import { formatageSomme } from "../../../../src/Repositories/Repository";
    export default {
        name: 'compte',
        components:{
            bailleurAjouter,
            
            ModelListSelect,

        },
        data() {
            return {
                fabActions: [
                    {
                        name: "cache",
                        icon: "add"
                    }

                ],
                demande:{},
                acteEffetActive:"",
                formFournisseur : {
                    numero_cc: "",
                    numero_rc: "",
                    raison_sociale: "",
                    telephone:"",
                    email:"",
                    adresse:"",
                },
                formAnalyseDMP:{
                    //document_procedure_id:"",
                    demande_ano_id:"",
                    observation:"",
                    avis_bail:"",
                    ref_dmp:"",
                    date_avis_bail:""
                },
                edite_analyse_dossier:"",
                edite_cojo:"",
                editer_mandater:"",
                edite_lettre_invitation:"",
                detail_dossier_candidature:"",
                detail_offre_technique:"",
                detail_offre_finnancier:"",
                detail_marche:"",
                marcheid:"",
                appel_offre_marche:"",
                edite_demande_dao:"",
                edite_analyse_dpm:"",
               formLot:{
                   numero_lot:"",
                   libelle_lot:"",
                   montant_lot:"",
                   marche_id:"",
                   appel_offre_id:"",
                  // mode_passation_id:""
               }
                ,
                formBailleur:{
                    type_finnancement_id:"",
                    montant:0,
                    marche_id:"",
                    bailleur_id:"",

                },
                edit_bailleur_marche:""
               ,formMandater:{
                    lettre_invitation_id:"",
                    date_id:"",
                    fichier_joint:"",
                    nom_mandat:"",
                    prenom_nom:"",
                    matricule_m:""
                },
                edite_pv:"",
                formAnalyseDossier:{
                    date_analyse:"",
                    appel_offre_id:"",
                    note_analyse:"",
                    rang_analyse:"",
                   // decision:"",
                    dossier_candidat_id:"",
                    type_analyse_id: "",
                    cojo_id:"",
                   // motif:""

                },
                affiche_bouton_ajouter_cojo:false,
                idcojo:"",
                formDataCojo:{
                    lettre_invitation_id:"",
                    condition_id:'',
                    controleur_finnancier:"",
                    dmp:"",
                    autorite_contractante:"",
                    date_invitation:"",
                    date_composition:"",
                    num_dossier_appel_offre:"",
                    nbr_participant:"",
                    matricule:""
                },
            isFormulaireDossierCandidature:false,
                isDetailDossierCandidature:false,
                isButtunAddDossierCandidat:true,
          formDossierCadidature:{
              secteur_activite_id:"",
              type_candidat_id:"",
              numero_cc:"",
              type_candidat:"",
              nom_cand:"",
              prenom_cand:"",
              date_nais_cand:"",
              telephone_cand:"",
              adresse_post:"",
              situation_geo:"",
              email_cand:"",
              procedure_passation_id:"",
              appel_offre_id:"",
              accord_group:"",
              cautionnement_prov:"",
              pouv_habil_signataire:"",
              piece_admin:"",
              reg_com:"",
              attest_banc:"",
              formul_propo_tech:"",
              fiche_rsgnt_cand:"",
              fiche_rsgnt_mbre_group:"",
              atcdent_marche_non_exe:"",
              org_travau_site:"",
              meth_real_travau:"",
              prog_mobilisation:"",
              capacite_financiere:"",
              caa_moyen_ac_entre:"",
              capacite_tech_exp:"",
              mt_offre_financiere:"",
              numero_dossier:"",
              capacite_financement:"",

          },


          editDossierCadidature:{

               secteur_activite_id:"",
               type_candidat_id:"",
              numero_cc:"",
              type_candidat:"",
              nom_cand:"",
              prenom_cand:"",
              date_nais_cand:"",
              telephone_cand:"",
              adresse_post:"",
              situation_geo:"",
              email_cand:"",
              procedure_passation_id:"",
              appel_offre_id:"",
              accord_group:"",
              cautionnement_prov:"",
              pouv_habil_signataire:"",
              piece_admin:"",
              reg_com:"",
              attest_banc:"",
              formul_propo_tech:"",
              fiche_rsgnt_cand:"",
              fiche_rsgnt_mbre_group:"",
              atcdent_marche_non_exe:"",
              org_travau_site:"",
              meth_real_travau:"",
              prog_mobilisation:"",
              capacite_financiere:"",
              caa_moyen_ac_entre:"",
              capacite_tech_exp:"",
              mt_offre_financiere:"",
              numero_dossier:"",
              capacite_financement:"",


          },
         formOffreTechnique:{
             numero_lot:"",
             accord_groupe:"",
             cautionnement_prov:"",
             pouv_habil_signataire:"",
             peice_admin:"",
             reg_com:"",
             attest_banc:"",
             formil_propo_tech:"",
             fiche_rsgnt_mbre_groupe:"",
             atcdent_marche_non_exe:"",
             org_travau_site:"",
             meth_real_travau:"",
             prog_mobilisation:"",
             capacite_financiere:"",
             caa_moyen_ac_entre:"",
             capacite_techn_exp:"",
             dossier_candidat_id:"",
         },

         formEffetFinancier:{
             code_act:"",
             libelle_act:"",
             reference_act:"",
             objet_act:"",
             incidence_financiere:"",
             montant_act:"",
             date_attributaire:"",
             date_reception:"",
             duree:"",
             date_fin_exe:"",
             date_odre_service:"",
             autorite_approbation:"",
             date_approbation:"",
             livrable_id:"",
             text_juridique_id:"",
             type_act_effet_id:"",
             analyse_dossier_id:"",
             entreprise_id:"",
             marche_id:"",
             numero_marche:"",
             ano_bailleur_id:""
         },

         formDataFacture:{
             prix_propose_ttc:"",
             prix_propose_ht:"",
             prix_unitaire:"",
             montant_facture:"",
             ligne_budgetaire:"",
             objet_facture:"",
             id_type_facture:"",
             code_acte_depense:"",
             numero_facture:"",

         },



         editActeEffetFinancier:{
              code_act:"",
             libelle_act:"",
             reference_act:"",
             objet_act:"",
             incidence_financiere:"",
             montant_act:"",
             date_attributaire:"",
             date_reception:"",
             duree:"",
             date_fin_exe:"",
             date_odre_service:"",
             autorite_approbation:"",
             date_approbation:"",
             livrable_id:"",
             text_juridique_id:"",
             type_act_effet_id:"",
             analyse_dossier_id:"",
             //entreprise_id:"",
             marche_id:"",
             numero_marche:"",
             ano_bailleur_id:""

         },
formOffreFinanciere:{
      numero_lot:"",
    designation:"",
    unite:"",
    quantite:"",
    prix_unitaire:"",
    montant_total_ht:"",
    montant_total_ttc:"",
    dossier_candidat_id:"",
},
formDemande:{
date_demande:"",
ref_marche:"",
num_courrier:"",
    analyse_dossier_id:"",
    proce_verbal_jugement_offre_id:""

},

                editMarche: {
                    id:"",
                    attribue:"",
                    numero_marche:""
                },
editDemandeAno:{
date_demande:"",
ref_marche:"",
num_courrier:""


},


formObservation:{
    date_avis_baill:"",
    avis_bail:"",
    observations_bailleur:"",
    ano_dmp_bailleur_id:"",
    document_procedure_id:""
},

editObservation1:{
    date_avis_baill:"",
    avis_bail:"",
    observations_bailleur:"",
    ano_dmp_bailleur_id:"",
    document_procedure_id:""
},

                edite_membre_cojo:"",

formAno:{
date_ano_dmp:"",
observations_bailleur:"",
avis_bail:"",
ref_ano_dmp:"",
numero_courie:"",
	appel_offre_id:"",
    analyse_dmp_id:""
},
avis_dmp:"",
editAno:{
date_ano_dmp:"",
ref_ano_dmp:"",
numero_courie:""
},

editDemamnde:{
    date_demande:"",
ref_marche:"",
num_courrier:""

},
formPv:{
    ref_pv:"",
    fichier_joint_pv:"",
},
          editDossier:{
              type_candidat:"",
                      nom_cand:"",
                      prenom_cand:"",
                      date_nais_cand:"",
                      telephone_cand:"",
                      adresse_post:"",
                          situation_geo:"",
                              email_cand:"",
                                  procedure_passation_id:"",
                                  	appel_offre_id:"",


          },
                edite_ano_bailleur_dmp:"",
                edite_offre_technique:"",
                edite_offre_financiere:"",
                formData: {
                    ref_appel:"",
                    type_appel:"",
                    financement:"",
                    nom_bailleurs:"",
                    date_emission:"",
                    date_limite:"",
                    objet_appel:"",
                    imputation:"",
                    marche_id:"",
                },
                formDataMembreCojo: {
                    matricule:"",
                    type_appel:"",
                    nom_prenom:"",
                    role:"",
                    cojo_id:"",
                },
                // detail_marche:{},
                formLettre: {
                    appel_offre_id:"",
                    objet_lettre:"",
                    date_lettre:"",
                    ref_lettre:"",
                    destination:"",
                    date_cojo:""
                },
                edite_appel_offre: "",
                search: "",
                edite_lot:{
                    numero_lot:"",
                    libelle_lot:"",
                    montant_lot:"",
                    marche_id:"",
                    appel_offre_id:"",
                    //mode_passation_id:""
                },
                message_mandater:'',
                isOffreTechniqueFinancier:false,
                namePDF: "",
                fichierPDF: "",
                imagePDF:"",
                selectedFile:"",
                resultaAnalysePv:[],
                resultaFinalCandidat:[],
                entreprise_vainqueur:"",
                registrecc_vainqueur:"",
                identreprise_vainqueur:"",
                message_setion_vainqueur:"",
                info_avis_bailleur:"",
                namePDFDemandeAno: "",
                fichierPDFDemandeAno: "",
                imagePDFDemandeAno:"",
                selectedFileDemandeAno:"",
            };
        },
created() {
            this.marcheid=this.$route.params.id
   this.detail_marche = this.getMarchePersonnaliser.find(
       idmarche => idmarche.id == this.$route.params.id
   )
  /*  this.appel_offre_marche=this.appelOffres.filter( idmarche => idmarche.marche.id == this.$route.params.id)
    console.log(this.appel_offre_marche)*/
},
        computed: {

            ...mapGetters("bienService", [ "typeCandidat",'acteDepense',"getMarchePersonnaliser","appelOffres","lots",
                "modePassations", "procedurePassations","getterDossierCandidats","marches",
                "getterOffreFinanciers","gettersOffreTechniques","getterLettreInvitation",
                "getterMandate","getterCojos","conditions","getterAnalyseDossiers","typeAnalyses","getterDemandeAno",
                "documentProcedures","getterAnalyseDMP","getterAnoDMPBailleur" ,"getterObseravtionBailleurs","obseravtionBailleurs",
                 "typeActeEffetFinanciers", "analyseDossiers","text_juridiques", "livrables",
                "getActeEffetFinancierPersonnaliser", "acteEffetFinanciers", "personnaliseGetterMarcheBailleur","getterMembreCojo","getterProceVerballe"]),
            ...mapGetters('personnelUA', ['acteur_depenses']),


                ...mapGetters("gestionMarche", ['secteur_activites', 'entreprises']),
            ...mapGetters('parametreGenerauxSourceDeFinancement', ['sources_financements',
                'types_financements']) ,
                
    ...mapGetters("parametreGenerauxAdministratif", ["exercices_budgetaires","type_Unite_admins","grandes_natures","taux","sections"]),
            
    //            afficheRef() {
    //   return id => {
    //     if (id != null && id != "") {
    //        const qtereel = this.appelOffres.find(qtreel => qtreel.id == id);

    //   if (qtereel) {
    //     return qtereel.ref_appel;
    //   }
    //   return 0
    //     }
    //   };
    // },
afficheCandidat() {
      return id => {
        if (id != null && id != "") {
           const qtereel = this.typeCandidat.find(qtreel => qtreel.id == id);

      if (qtereel) {
        return qtereel.libelle;
      }
      return 0
        }
      };
    },

// calculons le nombre de jours pour acteur depense

nombreDejourCalcule(){
                let vM=this;
    const acteAffet = vM.formEffetFinancier
    if(acteAffet.date_odre_service == acteAffet.date_fin_exe &&  acteAffet.date_fin_exe !=="" && acteAffet.date_odre_service !=="") return 1
     if(acteAffet.date_fin_exe =="" && acteAffet.date_odre_service =="") return null

       var dateF = new Date(acteAffet.date_fin_exe).getTime()
        var dateO = new Date(acteAffet.date_odre_service).getTime()
           var resultat = dateF - dateO

             var diffJour =  resultat / (1000 * 3600 * 24)

               if(isNaN(diffJour)) return null

               if(parseFloat(diffJour) < 0 ) return "durée invalide"
    vM.formEffetFinancier.duree=diffJour
                  return  diffJour;
   
},

getDateFinExécutionValue(){
    return !this.formEffetFinancier.date_odre_service !=""
},


// modifier le calcul lors de la modificatin
// nombreModifDejourCalcule(){

//               let vM=this;
//     const acteEdit = vM.editActeEffetFinancier
//     if(acteEdit.date_odre_service == acteEdit.date_fin_exe &&  acteEdit.date_fin_exe !=="" && acteEdit.date_odre_service !=="") return 1
//      if(acteEdit.date_fin_exe =="" && acteEdit.date_odre_service =="") return null

//        var dateF = new Date(acteEdit.date_fin_exe).getTime()
//         var dateO = new Date(acteEdit.date_odre_service).getTime()
//            var resultat = dateF - dateO

//              var diffJour =  resultat / (1000 * 3600 * 24)

//                if(isNaN(diffJour)) return null

//                if(parseFloat(diffJour) < 0 ) return "durée invalide"
//     vM.editActeEffetFinancier.duree=diffJour
//                   return  diffJour;


// },

// getDateFinExécutionModifValue(){
//     return !this.editActeEffetFinancier.date_odre_service !=""
// },





            verrouObjection(){

return this.formAnalyseDMP.avis_bail == "1";
            },
            
             recupererNumeroCourier() {
      
      const norme = this.getterDemandeAno.find(normeEquipe => normeEquipe.ref_marche == this.detail_marche.reference_marche);

      if (norme) {
        return norme.num_courrier;
      }
      return ""
    },


    // affichage de l'avis DMP
    recuperationDeAvisDmp(){
        

        let numero = this.getterAnalyseDMP.find(numeroDmp => numeroDmp.avis_bail == 1)
        if(numero) {
            if(numero.avis_bail==1){
              return "non objection"
            }else{
            return "objection"
            }
           
        }
        return null
    },

// afficher le moti de demande ano
//  motifDemandeAno(){
//      return this.formDemande.avis_ano == 1
//  },


      afficherIdMarche() {
      return id => {
        if (id != null && id != "") {
           const qtereel = this.marches.find(qtreel => qtreel.id == id);

      if (qtereel) {
        return qtereel.reference_marche;
      }
      return 0
        }
      };
    },
            
            marcheDetail(){
                return  marche_id=>{
                    if (marche_id!="") {
                        const vM=this;
                       // console.log("Marche detail")
                        let Objet=this.marches.find(idmarche => idmarche.id == marche_id)
                        if(Objet!=undefined){
                           vM.formData.type_appel=Objet.procedure_passation.type_procedure.libelle;
                            vM.formData.imputation=Objet.imputation;
                            vM.formDossierCadidature.procedure_passation_id=Objet.procedure_passation.id;
                            vM.formDemande.ref_marche=Objet.reference_marche
                        }
                        return  this.marches.find(idmarche => idmarche.id == marche_id
                        )
                    }
                }

            },
 libelleLot() {
      const typeUniteA = this.lots.find(typeUa=> typeUa.id == this.formOffreFinanciere.numero_lot);

      if (typeUniteA) {
        return typeUniteA.libelle_lot;
        
      }
      return ""
    },

affcherTauxEnCours() {
      
      const norme = this.taux.find(normeEquipe => normeEquipe.encours == 1);

      if (norme) {
        return norme.libelle;
      }
      return 0
    },
tauxArrondit() {
      
      const norme = this.taux.find(normeEquipe => normeEquipe.encours == 1);

      if (norme) {
        return norme.arrondit;
      }
      return 0
    },
montantHT() {
      const val =  parseFloat(this.formOffreFinanciere.prix_unitaire) * parseFloat(this.formOffreFinanciere.quantite);
      
       if (val) {
        return parseInt(val).toFixed(0);
      }
      
      return 0
    },
    montantTva() {
      const val =   parseFloat(this.montantHT) * parseFloat(this.tauxArrondit);
      
       if (val) {
        return parseInt(val).toFixed(0);
      }
      
      return 0
    },


 montantHTt() {
      const val = parseFloat(this.montantHT) + parseFloat(this.montantTva);
      
       if (val) {
        return parseInt(val).toFixed(0);
      }
      
      return 0
    },



            //afficher le motif avis bailleur 
            afficherMotifBailleur(){
                return this.formAno.avis_bail =="1";
            },

            listeBailleurMarche(){
                return  marche_id=>{
                    if (marche_id!="") {
                       // console.log("MarcheBailleur")
                        return this.personnaliseGetterMarcheBailleur.filter( idmarche => idmarche.marche_id == marche_id)
                    }
                }


            },
            montantBailleurMarcheCompare(){
                return  marche_id=>{
                    if (marche_id!="") {
                        let initialValue = 0;
                        let vM=this;
                      //  let montantSaisie=parseFloat(vM.formBailleur.montant)
                        let ObjetMontant =this.personnaliseGetterMarcheBailleur.filter( idmarche => idmarche.marche_id == marche_id).reduce(function (total, currentValue) {
                                 return total + parseFloat(currentValue.montant) ;
                        }, initialValue);
                        let montantConbiner=parseFloat(vM.formBailleur.montant) + parseFloat(ObjetMontant)

                        return parseFloat(montantConbiner);
                    }
                }


            }
            ,
            listeAppelOffre(){
                return  marche_id=>{
                    if (marche_id!="") {
                        //console.log("Marche appel offre")
                       const vM=this;
                        let Objet=this.appelOffres.find( idmarche => idmarche.marche_id == marche_id)
                       // console.log("Marche appel offre 10")
                        if(Objet!=undefined){
                            vM.formDossierCadidature.appel_offre_id=Objet.id;
                            vM.formAnalyseDossier.appel_offre_id = Objet.id;
                            vM.formLot.appel_offre_id=Objet.id;
                            vM.formAno.appel_offre_id = Objet.id
                            vM.formLettre.appel_offre_id=Objet.id;
                            vM.formDataCojo.num_dossier_appel_offre=Objet.ref_appel;
                        }
                       // console.log(Objet)
                    return this.appelOffres.filter( idmarche => idmarche.marche_id == marche_id)
                    }
                }

            },

            // afficher le champ motif dynanmique
// afficherMotifAnalyse(){
//     return this.formAnalyseDossier.decision  =="1"
// },

            listeLots(){
                return  marche_id=>{
                    if (marche_id!="") {
                        //console.log("Marche lots")
                       // let listeLotMarche =this.lots.filter( idmarche => idmarche.marche.id == marche_id)
                       // const searchTerm = this.search.toLowerCase();
                        //return this.lots.filter( idmarche => idmarche.marche.id == marche_id)
                        return this.lots.filter( idmarche => idmarche.marche_id == marche_id)
                    }
                }

                
            },
             listePV(){
               return marche_id=>{
                   if(marche_id!=""){
                       let objet=this.getterProceVerballe.filter(item=>item.appel_offre.marche_id==marche_id);
                      // console.log("PV est en cour10")
                       return objet
                   }
               }
             },
            listePVDemandePV(){
                return marche_id=>{
                    if(marche_id!=""){
                        return this.getterProceVerballe.find(item=>{
                            if(item.appel_offre.marche_id==marche_id && item.avie==null ){
                                let vM=this;
                                vM.formDemande.proce_verbal_jugement_offre_id=item.id
                                return item;
                            }
                        });
                    }
                }
            },
            avisPv(){
                return reference=>{
                    if(reference!=""){

                        let info=this.getterProceVerballe.find(item=>item.reference==reference);
                        if(info.avie==null){
                            return null
                        }else{
                            return info.avie
                        }
                    }
                    return null;
                }
            }
            ,
            dossierCandidature: function () {
                return marcheid => {
                    if (marcheid != "") {
                      //  console.log("Marche dossier candidat")
                        return this.getterDossierCandidats.filter(idmarche => idmarche.appel_offre.marche_id == marcheid)
                    }
                }
            },
            lettreInvitationAMarche: function () {
                return marcheid => {
                    if (marcheid != "") {
                        //console.log("Marche lettre inviation marche")
                        return this.getterLettreInvitation.filter(idmarche => idmarche.appel_offre.marche_id == marcheid)
                    }
                }
            },
            listeMantater: function () {
                return marcheid => {
                    if (marcheid != "") {
                       let vM =this;
                        let Objet =this.getterMandate.find(idmarche => idmarche.lettre_invitation.appel_offre.marche_id == marcheid);
                      console.log("Ok c'est la vie")
                        if(Objet!=undefined){
                            vM.formDataCojo.lettre_invitation_id=Objet.lettre_invitation_id
                            vM.formDataCojo.controleur_finnancier=Objet.nom_mandat+" "+Objet.prenom_nom
                            vM.formDataCojo.matricule=Objet.matricule_m
                            vM.formDataCojo.date_invitation=Objet.lettre_invitation.date_lettre
                        }
                        return this.getterMandate.filter(idmarche => idmarche.lettre_invitation.appel_offre.marche_id == marcheid)
                    }
                }
            }
            ,
            listeCojo: function () {
                return marcheid => {
                    if (marcheid != "") {
                      let Objet=  this.getterCojos.find(idmarche => idmarche.lettre_invitation.appel_offre.marche_id == marcheid);
                        let vM=this;
                        if(Objet!=undefined){
                            vM.idcojo=Objet.id
                        }
                        return this.getterCojos.filter(idmarche => idmarche.lettre_invitation.appel_offre.marche_id == marcheid)
                    }
                }
            },
             listeMembreCojo: function (){
                let vM=this;
                if( vM.idcojo!=""){
                    return this.getterMembreCojo.filter(idmem=>idmem.cojo_id==vM.idcojo);
                }
                return null;
             },
        listeAnalyseDossier: function () {
            return marcheid => {
                if (marcheid != "") {

                    return this.getterAnalyseDossiers.filter(idmarche => idmarche.dossier_candidature.appel_offre.marche_id == marcheid)
                }
            }
        },

            demandeAno: function () {
                return marcheid => {
                    if (marcheid != "") {
                        let obje=this.getterDemandeAno.filter(idmarche => idmarche.proce_verbal_offre.appel_offre.marche_id == marcheid)

                        return obje
                    }
                }
            },
            demandeAnoAnalyseDMP: function () {
                return marcheid => {
                    if (marcheid != "") {
                       // console.log("Marche demande ano AnalyseDmp marche_id")

                        let obje=this.getterDemandeAno.find(idmarche => {
                            if(idmarche.proce_verbal_offre.appel_offre.marche_id == marcheid && idmarche.proce_verbal_offre.avie==null){
                                let vM=this;
                                vM.formAnalyseDMP.demande_ano_id=idmarche.id;
                                return idmarche;
                            }
                        })
                       // console.log("Marche demande 41000000")
                        return obje
                    }
                }
            },
            listeAnalyseDPM: function () {
                return marcheid => {
                    if (marcheid != "") {
                       // console.log("Marche liste analyse dpm")
                        let objet=this.getterAnalyseDMP.filter(idmarche => idmarche.demande_ano.proce_verbal_offre.appel_offre.marche_id == marcheid)
                      // console.log("ok c'est la vie 010101")
                        return objet;
                    }
                }

            },
            analyseDMPValider(){
             return marcheid=>{
                 if(marcheid != ""){
                     let objet=this.getterAnalyseDMP.find(item=>{
                         if(item.demande_ano.proce_verbal_offre.appel_offre.marche_id == marcheid && item.avis_bail==1 ){
                             let vM=this;
                         // console.log("OK AnalyseDMP")
                             vM.formAno.analyse_dmp_id=item.id;
                             vM.avis_dmp="Non objection"
                              return item;
                         }
                     })
                     return objet;
                 }
             }
            },


            listeAnoDMPBailleur: function () {
                return marcheid => {
                    if (marcheid != "") {
                      //  console.log("Marche dmp bailleur")
                        let objet=this.getterAnoDMPBailleur.filter(idmarche => idmarche.annalyse_d_m_p.demande_ano.proce_verbal_offre.appel_offre.marche_id == marcheid)
                        //console.log("Marche dmp bailleru 7474")
                        return objet
                    }
                }
            },


            selectionAttributionMarche: function () {
                return marcheid => {
                    if (marcheid != "") {
                       let vM=this;

                        let marcherEnAction=this.getterAnoDMPBailleur.filter(idmarche => idmarche.annalyse_d_m_p.demande_ano.proce_verbal_offre.appel_offre.marche_id == marcheid)

                        let marcherFavaroble=marcherEnAction.find(idmarche=>idmarche.avis_bail==1);
                        let marcherObjetction=marcherEnAction.find(idmarche=>idmarche.avis_bail==0);
                        console.log(marcherFavaroble)
                        if (marcherFavaroble!=undefined){
                            vM.entreprise_vainqueur=""
                            console.log("1411111")


                            vM.info_avis_bailleur="Non objection";
                            vM.formEffetFinancier.ano_bailleur_id=marcherFavaroble.id
                            let resulta=this.getterAnalyseDossiers.filter(item=>item.reference_pv==marcherFavaroble.annalyse_d_m_p.demande_ano.proce_verbal_offre.reference);
                            console.log(resulta)
                            //vM.resultaFinalCandidat=resulta
                            let entreprise;
                            if (resulta.length>0){
                                resulta.sort(function (a, b) {
                                    return a.note_analyse - b.note_analyse;
                                }).reverse()
                                 entreprise=resulta.find(item=>item.reference_pv==marcherFavaroble.annalyse_d_m_p.demande_ano.proce_verbal_offre.reference)
                                console.log("111111")
                                console.log(entreprise)
                                console.log("222222")
                                return entreprise;
                            }

                            return null


                        }
                        if(marcherObjetction!=undefined){
                            vM.message_setion_vainqueur="Le dossier a été rejete"
                        }else{
                            vM.message_setion_vainqueur="Assuré vous d'avoir terminé tous les étape précedente"
                        }
                        return null

                    }
                }
            },


            listeActeEffectFinnancier: function () {
                return marcheid => {
                    if (marcheid != "") {
                      // console.log("Marche leste acte effect finnancier")
                        return this.getActeEffetFinancierPersonnaliser.filter(idmarche => idmarche.marche_id == marcheid)
                    }
                }
            },



        },
        methods: {
            ...mapActions("bienService", [
                'ajouterAppelOffre','modifierAppelOffre',"supprimerAppelOffre","modifierAppelOffre",
                "ajouterLot","modifierLot","supprimerLot","ajouterDossierCandidat","getDossierCandidat",
                "modifierDossierCandidat","supprimerDossierCandidat","ajouterOffreTechnique","modifierOffreTechnique",
                "supprimerOffreTechnique","ajouterOffreFinancier","modifierOffreFinancier","supprimerOffreFinancier",
                "ajouterLettreInvitation",
                "modifierLettreInvitation","supprimerLettreInvitation","getMandater","ajouterMandater",
                "modifierMandater","supprimerMandater","ajouterCojo","modifierCojo","supprimerCojo","ajouterAnalyseDossier",
                "modifierAnalyseDossier","supprimerAnalyseDossier","ajouterDemandeAno",
                "modifierDemandeAno","supprimerDemandeAno","ajouterAnalyseDMP","modifierAnalyseDMP",
                "supprimerAnalyseDMP","ajouterAnoDMPBailleur","modifierAnoDMPBailleur","supprimerAnoDMPBailleur"
                , "modifierObservationBaileur","ajouterObseravtionBailleur" , "supprimerObseravtionBailleur",
                 "ajouterFournisseur", "ajouterActeEffetFinancier", "modifierActeEffetFinancier",
                 "supprimerActeEffetFinancier","modifierMarche","supprimerFacture","modifierFacture",
                  "ajouterFacture"
                , "modifierObservationBaileur","ajouterObseravtionBailleur","supprimerObseravtionBailleur",
                 "ajouterFournisseur", "ajouterActeEffetFinancier",
                "modifierActeEffetFinancier","supprimerActeEffetFinancier","modifierMarche","modificationMarcheBailleur",
                "ajouterMarcherBailleur","supprimerMarcheBailleur","ajouterMembreCojo",
                "modificationMembreCojo","supprimerMembreCojo","getProceVerbal",
                "ajouterProceVerbal","supprimerProceVerbal","modificationProceVerbalOffre","getAnalyseDossier","getDemandeAno","getAnalyseDMP","getAnoDMPBailleur","getActeEffetFinancier"

            ]),
            ...mapActions('gestionMarche', ['getEntreprise',"ajouterEntreprise","supprimerEntreprise","modifierEntreprise","ajouterSanction"]),
            // 
            ajouterBudgetaireLocal(){
                 this.$("#myModal").modal({
                    backdrop: "static",
                    keyboard: false
                });
            },
formatageSomme: formatageSomme,
ajouterStockLocal(){
    this.ajouterFacture(this.formDataFacture)
    this.formDataFacture ={
        prix_propose_ttc:"",
             prix_propose_ht:"",
             prix_unitaire:"",
             montant_facture:"",
             ligne_budgetaire:"",
             objet_facture:"",
             id_type_facture:"",
             code_acte_depense:"",
             numero_facture:"",


    }

},
            infoPVAffiche(ref){
                this.resultaAnalysePv=[]
                let resulta=this.getterAnalyseDossiers.filter(item=>item.reference_pv==ref);
                this.resultaAnalysePv=this.resultaAnalysePv.concat(resulta)

                if (this.resultaAnalysePv.length>0){
                    this.resultaAnalysePv.sort(function (a, b) {
                        return a.note_analyse - b.note_analyse;
                    }).reverse()
                }

                //console.log(this.resultaAnalysePv)
            },

    onFichierChange(e){
      this.formLettre.fichier_joint = e.target.files[0]
     // console.log(onFichierChange);
    },

            afficheModaleMembreCojo(index){
                this.$('#modification_membre_cojo').modal({
                    backdrop: "static",
                    keyboard:false
                })
                this.edite_membre_cojo = this.getterMembreCojo.find(item=>item.id==index);
            },
            editeMembreCojoM(){
    this.modificationMembreCojo(this.edite_membre_cojo)
    this.$('#modification_membre_cojo').modal('hide');
},
modifierFactureLocal(){

    this.$('#modififacture').modal('hide');
},
           rechercheMandater(){
            // console.log(this.formMandater.matricule_m)
              let objetMandater=this.acteur_depenses.filter(item=>item.acteur_depense.matricule==this.formMandater.matricule_m)
              // console.log(objetMandater)
               if(objetMandater!=undefined){
                   if (objetMandater.length==1){
                       let acteur= this.acteur_depenses.find(item=>item.acteur_depense.matricule==this.formMandater.matricule_m)
                       this.formMandater.prenom_nom=acteur.acteur_depense.prenom
                       this.formMandater.nom_mandat=acteur.acteur_depense.nom
                       this.message_mandater=""
                   }
                   else{
                       this.message_mandater="Cette n'existe pas dans notre base de donnée "
                   }
               }
             if(this.formMandater.matricule_m==""){
                 this.formMandater.prenom_nom=""
                 this.formMandater.nom_mandat=""
                 this.message_mandater=""
             }
           },
            rechercheMembreCojo(){
                // console.log(this.formMandater.matricule_m)

                let objetMandater=this.acteur_depenses.filter(item=>item.acteur_depense.matricule==this.formDataMembreCojo.matricule)
                // console.log(objetMandater)
                if(objetMandater!=undefined){
                    if (objetMandater.length==1){
                        let acteur= this.acteur_depenses.find(item=>item.acteur_depense.matricule==this.formDataMembreCojo.matricule)
                        this.formDataMembreCojo.nom_prenom=acteur.acteur_depense.nom +" "+acteur.acteur_depense.prenom
                        this.message_mandater=" "

                    }
                    else{
                        this.message_mandater="Cette n'existe pas dans notre base de donnée "
                        this.formDataMembreCojo.nom_prenom=""
                    }
                }
                if(this.formDataMembreCojo.matricule==""){
                    this.formDataMembreCojo.nom_prenom=""
                    this.message_mandater=" "
                }
            }
            ,
            recherche() {

              // console.log(this.search)
                let entre=this.entreprises.find(item=>item.id==this.search);
                if (entre!=undefined){
                    if(this.search!=""){
                        this.formDossierCadidature.telephone_cand=entre.telephone
                        this.formDossierCadidature.adresse_post=entre.adresse
                        this.formDossierCadidature.nom_cand=entre.raison_sociale
                        this.formDossierCadidature.reg_com=entre.numero_rc
                        this.formDossierCadidature.email_cand=entre.email
                        this.formDossierCadidature.numero_cc=entre.numero_cc
                        this.formDossierCadidature.secteur_activite_id=entre.secteur_activite_id
                    }
                }


            },
            retourListeEntreprise(){
                 this.$router.push({ name: 'marche' })
            },
            //afiicher modal ajouter
            afficherModalAjouterActeDepense() {
                this.$("#exampleModal").modal({
                    backdrop: "static",
                    keyboard: false
                });
            },
            ajouterMembreCojoM(){
                this.formDataMembreCojo.cojo_id=this.idcojo
              this.ajouterMembreCojo(this.formDataMembreCojo)
                this.formDataMembreCojo= {
                       matricule:"",
                        type_appel:"",
                        nom_prenom:"",
                        role:"",
                        cojo_id:"",
                }
            },
            ajouterBailleur(){
                this.formBailleur.marche_id=this.marcheid
               this.ajouterMarcherBailleur(this.formBailleur)
                this.formBailleur={
                      type_finnancement_id:"",
                        montant:0,
                        marche_id:"",
                        bailleur_id:"",
                }
            },
            // fonction pour vider l'input ajouter
            ajouter(){
                this.formData.marche_id=this.marcheid
                this.ajouterAppelOffre(this.formData)
                this.formData = {
                    ref_appel:"",
                    type_appel:"",
                    financement:"",
                    nom_bailleurs:"",
                    date_emission:"",
                    date_limite:"",
                    objet_appel:"",
                    imputation:"",
                    marche_id:"",

                }
            },
            ajouterL(){
                this.formLot.marche_id=this.marcheid
                this.ajouterLot(this.formLot)
                this.formLot={
                    numero_lot:"",
                        libelle_lot:"",
                        montant_lot:"",
                        marche_id:"",
                        appel_offre_id:"",
                        //mode_passation_id:""
                }
            },
            ajouterLettreInv(){
                const formData = new FormData();
                formData.append('fichier', this.selectedFile, this.selectedFile.name);
                formData.append('appel_offre_id', this.formLettre.appel_offre_id);
                formData.append('destination', this.formLettre.destination);
                formData.append('ref_lettre', this.formLettre.ref_lettre);
                formData.append('date_lettre', this.formLettre.date_lettre);
                formData.append('date_cojo', this.formLettre.date_cojo);
                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }
                this.ajouterLettreInvitation(formData,config)
                this.formLettre= {
                    appel_offre_id:"",
                    fichier_joint:"",
                    date_lettre:"",
                    ref_lettre:"",
                    destination:"",
                    date_cojo:""
                }
            },
            ajouterAnalyseD(){
              this.ajouterAnalyseDossier(this.formAnalyseDossier)
                this.formAnalyseDossier={
                        date_analyse:"",
                        appel_offre_id:"",
                        rang_analyse:"",
                      //  decision:"",
                       // motif:"",
                        note_analyse:"",
                        dossier_candidat_id:"",
                        type_analyse_id: "",
                        cojo_id:""
                }
            },
            ajouterOffreT(){
                this.formOffreTechnique.dossier_candidat_id=this.edite_offre_technique.id
              this.ajouterOffreTechnique(this.formOffreTechnique)
                this.formOffreTechnique={
                    numero_lot:"",
                        accord_groupe:"",
                        cautionnement_prov:"",
                        pouv_habil_signataire:"",
                        peice_admin:"",
                        reg_com:"",
                        attest_banc:"",
                        formil_propo_tech:"",
                        fiche_rsgnt_mbre_groupe:"",
                        atcdent_marche_non_exe:"",
                        org_travau_site:"",
                        meth_real_travau:"",
                        prog_mobilisation:"",
                        capacite_financiere:"",
                        caa_moyen_ac_entre:"",
                        capacite_techn_exp:"",
                        dossier_candidat_id:"",
                }
            },
            ajouterOffreF(){


                 var nouvelObjet = {
      ...this.formOffreFinanciere,
      montant_total_ht :this.montantHT,
       montant_total_ttc :this.montantHTt,
        	taux :this.affcherTauxEnCours,
         	tva :this.montantTva,
designation:this.libelleLot,
dossier_candidat_id : this.edite_offre_financiere.id
       };
                // console.log(this.edite_offre_financiere.id)
                // this.formOffreFinanciere.dossier_candidat_id=this.edite_offre_financiere.id
                this.ajouterOffreFinancier(nouvelObjet)
                this.formOffreFinanciere={
                        numero_lot:"",
                        designation:"",
                        unite:"",
                        quantite:"",
                        prix_unitaire:"",
                        montant_total_ht:"",
                        montant_total_ttc:"",
                }
            },
            ajouterMandaterA(){

               this.ajouterMandater(this.formMandater)
                this.formMandater={
                        lettre_invitation_id:"",
                        date_id:"",
                        fichier_joint:"",
                        nom_mandat:"",
                        prenom_nom:"",
                    matricule_m:""
                }
            },
            ajouterCojoMarche(){
              this.ajouterCojo(this.formDataCojo)
                this.formDataCojo={
                        lettre_invitation_id:"",
                        condition_id:'',
                        controleur_finnancier:"",
                        dmp:"",
                        autorite_contractante:"",
                        date_invitation:"",
                        date_composition:"",
                        num_dossier_appel_offre:"",
                        nbr_participant:""
                }
            },
            ajouterDossierCandidature(){
                this.formFournisseur.raison_sociale=this.formDossierCadidature.nom_cand
                this.formFournisseur.numero_cc= this.formDossierCadidature.numero_cc
                this.formFournisseur.numero_rc=this.formDossierCadidature.reg_com
                this.formFournisseur.telephone=this.formDossierCadidature.telephone_cand
                this.formFournisseur.adresse=this.formDossierCadidature.adresse_post
                this.formFournisseur.email=this.formDossierCadidature.email_cand
                this.formFournisseur.complet=0

           // console.log(this.formFournisseur)
              let ent=  this.entreprises.find(item=>item.numero_rc==this.formFournisseur.numero_rc)

                if(ent==undefined){
                    this.ajouterEntreprise(this.formFournisseur)
                }
                this.ajouterDossierCandidat(this.formDossierCadidature)

                this.formDossierCadidature={
                    type_candidat:"",
                        numero_cc:"",
                        nom_cand:"",
                        prenom_cand:"",
                        date_nais_cand:"",
                        telephone_cand:"",
                        adresse_post:"",
                        situation_geo:"",
                        email_cand:"",
                        procedure_passation_id:"",
                        appel_offre_id:"",
                        accord_group:"",
                        cautionnement_prov:"",
                        pouv_habil_signataire:"",
                        piece_admin:"",
                        reg_com:"",
                        attest_banc:"",
                        formul_propo_tech:"",
                        fiche_rsgnt_cand:"",
                        fiche_rsgnt_mbre_group:"",
                        atcdent_marche_non_exe:"",
                        org_travau_site:"",
                        meth_real_travau:"",
                        prog_mobilisation:"",
                        capacite_financiere:"",
                        caa_moyen_ac_entre:"",
                        capacite_tech_exp:"",
                        mt_offre_financiere:"",

                }

                this.NotisFormulaireDossierCand()
            },


// vider l'input 

   // modification de dossier candidat

            modificationDossierCandidatLocal(){
                this.formFournisseur.raison_sociale=this.editDossierCadidature.nom_cand
                this.formFournisseur.numero_cc= this.editDossierCadidature.numero_cc
                this.formFournisseur.numero_rc=this.editDossierCadidature.reg_com
                this.formFournisseur.telephone=this.editDossierCadidature.telephone_cand
                this.formFournisseur.adresse=this.editDossierCadidature.adresse_post
                this.formFournisseur.email=this.editDossierCadidature.email_cand
                this.formFournisseur.complet=0

                let entre = this.entreprises.find(item =>item.numero_rc==this.formFournisseur.numero_rc)
                  if(entre==undefined){
                      this.modifierEntreprise(this.formFournisseur)
                  }
                  this.modifierDossierCandidat(this.editDossierCadidature)
                  this.$('#modificationDossierCandidatModal').modal('hide');

            },


ajouterModalActeEffetFinancierLocal(rcm){
       /* var nouvelObjet = {
            ...this.formEffetFinancier,
            duree: this.nombreDejourCalcule
        }*/
    let entreprisePremier=this.entreprises.find(item=>item.numero_rc==rcm)
              //  console.log(this.formEffetFinancier)
    this.formEffetFinancier.marche_id=this.marcheid
    this.formEffetFinancier.entreprise_id=entreprisePremier.id
    this.ajouterActeEffetFinancier(this.formEffetFinancier)
    let marcheObjet=this.marches.find(marche=>marche.id==this.marcheid)
    marcheObjet.attribue=1
    marcheObjet.numero_marche=this.formEffetFinancier.numero_marche
   // console.log(marcheObjet)
    this.modifierMarche(marcheObjet)
    this.formEffetFinancier = {
             code_act:"",
             libelle_act:"",
             reference_act:"",
             objet_act:"",
             incidence_financiere:"",
             montant_act:"",
              date_attributaire:"",
             date_reception:"",
             duree:"",
             date_fin_exe:"",
             date_odre_service:"",
             livrable_id:"",
        autorite_approbation:"",
        date_approbation:"",
             text_juridique_id:"",
             type_act_effet_id:"",
             analyse_dossier_id:"",
             entreprise_id:"",
             marche_id:"",
             numero_marche:""

    }
},


afficherModalModifierActeEffetFinancier(index){
    this.$('#modifierActeEF').modal({
        backdrop: 'static',
        keyboard: false
    });
    this.editActeEffetFinancier = this.acteEffetFinanciers.find(item=>item.id==index)
},

   afficherModificationPV(index){
       this.$('#modificationPV').modal({
           backdrop: 'static',
           keyboard: false
       });
       this.edite_pv = this.getterProceVerballe.find(item=>item.id==index);
   }  ,
            modificationProceVerbal(){
                const formData = new FormData();
                formData.append('reference', this.edite_pv.reference);
                formData.append('id', this.edite_pv.id);
                formData.append('appel_offre_id', this.edite_pv.appel_offre_id);
                console.log(formData)
                if ( this.selectedFile!==""){
                    formData.append('fichier', this.selectedFile, this.selectedFile.name);
                }
                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }
                this.modificationProceVerbalOffre(formData,config)
                this.$('#modificationPV').modal('hide');
                this.getAnalyseDossier()
                this.getDemandeAno()
                this.getAnalyseDMP()
                this.getAnoDMPBailleur()
            },

            modificationBailleurMarche(){
                this.modificationMarcheBailleur(this.edit_bailleur_marche)
                this.$('#editBailleuMarche').modal('hide');
            },
            editeMarcheBailleur(index){
                this.$('#editBailleuMarche').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                this.edit_bailleur_marche = this.personnaliseGetterMarcheBailleur.find(item=>item.id==index)
              //  console.log(this.edit_bailleur_marche)
            },

// vider l'input 
modifierModalActeEffetFinancierLocal(){

   // this.editActeEffetFinancier.entreprise_id=entreprise_id



    this.modifierActeEffetFinancier(this.editActeEffetFinancier)
    this.$('#modifierActeEF').modal('hide');
},

            // afficherModalAjoutObservationBailleur(){
            //     this.$('#ajouterObservationBailleur')
            // },

            ajoutObservationBailleurLocal(){
                this.ajouterObseravtionBailleur(this.formObservation)
                this.formObservation = {
                    date_avis_bail:"",
               avis_bail:"",
              observations_bail:"",
           ano_dmp_bailleur_id:"",
             document_procedure_id:""

                }

              


            },



            afficherModalObservationBailleur(index){
                 this.$('#modifierObservationBailleur').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                  this.editObservation1 = this.getterObseravtionBailleurs[index]

            },
            // vider l'input
            modifierObservationBailleurLocal(){
                this.modifierObservationBaileur(this.editObservation1)
                this.$('#modifierObservationBailleur').modal('hide');
            },

        

        ajouterAnalyseDMPB(){
     /*        var nouvelObjet = {
        ...this.formAnalyseDMP,
        ref_dmp: this.detail_marche.id,
        ref_courier: this.recupererNumeroCourier,
      };*/
                console.log(this.formAnalyseDMP)
            this.ajouterAnalyseDMP(this.formAnalyseDMP)
            this.formAnalyseDMP={
                     ref_dmp:"",
                    demande_ano_id:"",
                    observation:"",
                    avis_bail:"",
                    date_avis_bail:""
            }
        },
            modaleOffreTechnique(index){
               let objet= this.getterDossierCandidats.find(item=>item.id=index);
                this.formOffreTechnique={
                    numero_lot:"",
                    accord_groupe:objet.accord_group,
                    cautionnement_prov:objet.cautionnement_prov,
                    pouv_habil_signataire:objet.pouv_habil_signataire,
                    peice_admin:objet.piece_admin,
                    reg_com:objet.reg_com,
                    attest_banc:objet.attest_banc,
                    formil_propo_tech:objet.formil_propo_tech,
                    fiche_rsgnt_mbre_groupe:objet.fiche_rsgnt_mbre_groupe,
                    atcdent_marche_non_exe:objet.atcdent_marche_non_exe,
                    org_travau_site:objet.org_travau_site,
                    meth_real_travau:objet.meth_real_travau,
                    prog_mobilisation:objet.prog_mobilisation,
                    capacite_financiere:objet.capacite_financiere,
                    caa_moyen_ac_entre:objet.caa_moyen_ac_entre,
                    capacite_techn_exp:objet.capacite_tech_exp,
                    dossier_candidat_id:objet.id,
                }
              this.edite_offre_technique=this.getterDossierCandidats.find(item=>item.id=index);
            },

            modaleOffreFinnanciere(index){
                this.edite_offre_financiere=this.getterDossierCandidats.find(item=>item.id=index);
            },
            isFormulaireDossierCand(){
                this.isFormulaireDossierCandidature=true
                this.isButtunAddDossierCandidat=false
                this.isDetailDossierCandidature=false
            },
            NotisFormulaireDossierCand(){
                this.isFormulaireDossierCandidature=false
                this.isButtunAddDossierCandidat=true
                this.isDetailDossierCandidature=false
            },
            isDetailDossierCandi(id){
                this.isDetailDossierCandidature=true,
                    this.isButtunAddDossierCandidat=false
                this.isButtunAddDossierCandidat=false

                this.detail_dossier_candidature=this.getterDossierCandidats.find(dossier=>dossier.id==id)
                this.detail_offre_finnancier=this.getterOffreFinanciers.find(offre => offre.dossier_candidature.id ==id)
                this.detail_offre_technique =this.gettersOffreTechniques.find(offre =>offre.dossier_candidature.id ==id)
               // console.log(this.detail_offre_finnancier)

            },
            // afficher modal de modification

            afficherModalModifierActeDepense(index){
                this.$('#modificationModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                this.edite_appel_offre = this.appelOffres.find(item=>item.id==index);
            },
            afficheDemandeDAO(index){

                this.$('#modifDemandeAno').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                this.edite_demande_dao=this.getterDemandeAno.find(
                    demandeAno => demandeAno.id == index
                )
                console.log(this.edite_demande_dao)
            },
            afficheAnalyseDMP(index){

                this.$('#editeDMP').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                this.edite_analyse_dpm=this.getterAnalyseDMP.find(
                    annalyseDP => annalyseDP.id == index
                )
                console.log(this.edite_analyse_dpm)
            },



// vider l'input de nnouveau fournisseur
ajouterNouveauFournisseurLocal(registeCommerce){
                this.formFournisseur.numero_rc=registeCommerce
    /*this.ajouterEntreprise(this.formFournisseur)
    this.formFournisseur = {
         numero_cc: "",
                    numero_rc: "",
                    raison_sociale: "",
                    sigle: "",
                    secteur_activite_id: "",
                    activite_principale: "",
                    pays: "",
                    ville: "",
                    forme_juridique:"",
                    centre_impot:"",
                    regime_imposition:"",
                    capitale_sociale:"",
                    immatriculation_cnps:"",
                    date_enregistrement_cnps:"",
                    telephone:"",
                    email:"",
                    nbre_travailleur_permanent:"",
                    nbre_travailleur_journalier:"",
                    service_assiette_impot:"",
                    adresse:"",
                    banque:""

    }*/
},




            afficheAnoDPMBailleurModale(index){
                this.$('#editeAnoDmpBailleurModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                this.edite_ano_bailleur_dmp=this.getterAnoDMPBailleur.find(
                    resp => resp.id == index
                )
                 },
            afficheAnnalyseDossier(index){
                this.$('#modificationAajouterAnalys01').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                this.edite_analyse_dossier = this.listeAnalyseDossier(this.marcheid)[index];
            },

            afficherModaleModifier(index){
                this.$('#modificationModal1').modal({
                    backdrop: 'static',
                    keyboard: false
                });

             this.edite_lot = this.listeLots(this.marcheid)[index];
                //this.edite_lot.appel_offre_id=this.edite_lot.
            },
            afficheBouttonTechCojo(index){
        this.$('#modificationCojo').modal({
            backdrop: 'static',
            keyboard: false
        });

        this.edite_cojo = this.getterCojos[index];
        //this.edite_lot.appel_offre_id=this.edite_lot. modifierDemandeAno
    },
            afficheBouttonTechFinMandater(index){
                this.$('#modificationMantater').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                this.editer_mandater = this.getterMandate[index];
            },
            modificationMandater(){
                this.modifierMandater(this.editer_mandater)
                this.$('#modificationMantater').modal('hide');
            },



            modificationDossierAnalyse(){
                this.modifierAnalyseDossier(this.edite_analyse_dossier)
                this.$('#modificationAajouterAnalys01').modal('hide');
            },
            modfications(){
                this.modifierAppelOffre(this.edite_appel_offre)
                this.$('#modificationModal').modal('hide');
            },
            modificationCojo(){
                this.modifierCojo(this.edite_cojo)
                this.$('#modificationModal').modal('hide');
            },
            modficationsLot(){
            
                this.modifierLot(this.edite_lot)
                this.$('#modificationModal1').modal('hide');
            },

            modficationsAnalyseDMP(){
                this.modifierAnalyseDMP(this.edite_analyse_dpm)
                    this.getProceVerbal();
                this.getAnoDMPBailleur()
                this.$('#editeDMP').modal('hide');
            },

            editeAnoDMPBailleurLocal(){

                const formData = new FormData();
                formData.append('date_ano_dmp', this.edite_ano_bailleur_dmp.date_ano_dmp);
                formData.append('avis_bail', this.edite_ano_bailleur_dmp.avis_bail);
                formData.append('observations_bailleur', this.edite_ano_bailleur_dmp.observations_bailleur);
                formData.append('ref_ano_dmp', this.edite_ano_bailleur_dmp.ref_ano_dmp);
                formData.append('analyse_dmp_id', this.edite_ano_bailleur_dmp.analyse_dmp_id);
                formData.append('appel_offre_id', this.edite_ano_bailleur_dmp.appel_offre_id);
                formData.append('id', this.edite_ano_bailleur_dmp.id);
                console.log(formData)
                if ( this.selectedFile!==""){
                    formData.append('fichier', this.selectedFile, this.selectedFile.name);
                }
                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }
                this.modifierAnoDMPBailleur(formData,config)
                this.$('#editeAnoDmpBailleurModal').modal('hide');
                this.getProceVerbal()
                this.getActeEffetFinancier()
            },
// afficher modification demande ano

/* afficherModalModifierDemandeAno(index){
    this.$('#modificationDemandeAno').modal({
       backdrop:'static',
     keyboard:false
  })
  },*/     

            // eslint-disable-next-line no-unused-vars
            afficheBouttonTechFin(index){
             this.isOffreTechniqueFinancier=true
            this.$('#modificationDossierCandidatModal').modal({
                    backdrop:'static',
                    keyboard:false
                });
                this.editDossierCadidature = this.dossierCandidature(this.marcheid)[index];


            },
            afficheBouttonTechFinInvitation(index){
                this.$('#modificationLettreInvitation').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                this.edite_lettre_invitation = this.getterLettreInvitation.find(item=>item.id==index);
            },
            modificationLettreInvitation(){
                const formData = new FormData();
                formData.append('appel_offre_id', this.edite_lettre_invitation.appel_offre_id);
                formData.append('destination', this.edite_lettre_invitation.destination);
                formData.append('ref_lettre', this.edite_lettre_invitation.ref_lettre);
                formData.append('date_lettre', this.edite_lettre_invitation.date_lettre);
                formData.append('date_cojo', this.edite_lettre_invitation.date_cojo);
                formData.append('id', this.edite_lettre_invitation.id);
                console.log(this.edite_lettre_invitation.id)
                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }
                if ( this.selectedFile!==""){
                    formData.append('fichier', this.selectedFile, this.selectedFile.name);
                }
               this.modifierLettreInvitation(formData,config)
            },
            // formatage de date
            formaterDate(date) {
              return moment(date, "YYYY-MM-DD").format("DD/MM/YYYY");
            },

            ExporterEnExel(){
                this.$refs.excel.click()
            }
,
            OnchangeFichier(e) {
                const files = e.target.files;
                this.selectedFile = event.target.files[0];
                console.log(this.selectedFile)
                Array.from(files).forEach(file => this.addFichierPDF(file));
            },
            addFichierPDF(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = e => {
                    vm.imagePDF = "pdf.png";
                    vm.namePDF = file.name;
                    vm.fichierPDF = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            ajouterPV(){
                const formData = new FormData();
                formData.append('fichier', this.selectedFile, this.selectedFile.name);
                formData.append('appel_offre_id', this.formLot.appel_offre_id);
                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }
                //console.log(formData)
                this.ajouterProceVerbal(formData,config);

            },
            OnchangeFichierDemandeAno(e) {
                const files = e.target.files;
                this.selectedFileDemandeAno = event.target.files[0];
                console.log(this.selectedFileDemandeAno)
                Array.from(files).forEach(file => this.addFichierPDFDemandeAno(file));
            },
            addFichierPDFDemandeAno(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = e => {
                    vm.imagePDFDemandeAno = "pdf.png";
                    vm.namePDFDemandeAno = file.name;
                    vm.fichierPDFDemandeAno = e.target.result;
                };
                reader.readAsDataURL(file);
            }
            ,
            ajouterDemandeAnoLocal(){
                const formData = new FormData();
                formData.append('fichier', this.selectedFileDemandeAno, this.selectedFileDemandeAno.name);
                formData.append('proce_verbal_jugement_offre_id', this.formDemande.proce_verbal_jugement_offre_id);
                formData.append('date_demande', this.formDemande.date_demande);
                formData.append('ref_marche', this.formDemande.ref_marche);
                formData.append('num_courrier', this.formDemande.num_courrier);
                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }
                console.log(formData)
                this.ajouterDemandeAno(formData,config)
                this.formDemande={
                    date_demande:"",
                    ref_marche:"",
                    num_courrier:"",
                    analyse_dossier_id:"",
                    proce_verbal_jugement_offre_id:""

                }
            },
            editDemandeDAO(){
                //console.log(this.edite_demande_dao)
                const formData = new FormData();
                formData.append('proce_verbal_jugement_offre_id', this.edite_demande_dao.proce_verbal_jugement_offre_id);
                formData.append('date_demande', this.edite_demande_dao.date_demande);
                formData.append('ref_marche', this.edite_demande_dao.ref_marche);
                formData.append('num_courrier', this.edite_demande_dao.num_courrier);
                formData.append('id', this.edite_demande_dao.id);
                console.log(formData)
                if ( this.selectedFileDemandeAno!==""){
                    formData.append('fichier', this.selectedFileDemandeAno, this.selectedFileDemandeAno.name);
                }
                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }

                this.modifierDemandeAno(formData,config)
                this.getAnalyseDMP()
                this.getAnoDMPBailleur()
                this.$('#modifDemandeAno').modal('hide');
            },
         ajouterAnoDMPBailleurLocal(){
             const formData = new FormData();
             formData.append('fichier', this.selectedFile, this.selectedFile.name);
             formData.append('date_ano_dmp', this.formAno.date_ano_dmp);
             formData.append('avis_bail', this.formAno.avis_bail);
             formData.append('observations_bailleur', this.formAno.observations_bailleur);
             formData.append('ref_ano_dmp', this.formAno.ref_ano_dmp);
             formData.append('numero_courie', this.formAno.numero_courie);
             formData.append('appel_offre_id', this.formAno.appel_offre_id);
             formData.append('analyse_dmp_id', this.formAno.analyse_dmp_id);
             let config = {
                 header : {
                     'Content-Type' : 'multipart/form-data'
                 }
             }
            this.ajouterAnoDMPBailleur(formData,config)
            this.formAno={
                date_ano_dmp:"",
                avis_bail:"",
                observations_bailleur:"",
                ref_ano_dmp:"",
                numero_courie:"",
                appel_offre_id:"",
                analyse_dmp_id:""
            }
        }
        }
    };
</script>
<style scoped>
    .taillemodal {
        width: 800px;
        margin: 0 -380px;
    }
    .gdmodelfour
    {
 width: 1000px;
 margin: 0 -580px;
 height: 500px;
    }
    .grdirModalActeEffet
    {

 width: 1200px;
 margin: 0 -530px;
 height: 550px;

    }
    .grdirModalAnalyse{
         width: 1000px;
 margin: 0 -530px;
 height: 350px;
    }
    .tlAviBailleur{
  width: 1000px;
 margin: 0 -530px;
 height: 450px;

    }
    .tlDossierCandidat{
        width: 1000px;
 margin: 0 -530px;
 height: 500px;

    }

    .tlg{
    width: 900px;
 margin: 0 -450px;
 height: 500px; 
    }
    .sommecolor{
        background-color: red;
        color:red;
        font-size: 120%;
        text-align: center;
        font-weight:bold;
    }
    .modaloffreFin{
width: 850px;
 margin: 0 -480px;
    }
    .tailDMP{
        width: 850px;
 margin: 0 -490px;
    }
    .tailleModalOffre{
           width: 1200px;
 margin: 0 -490px;
    }
     .tailleModalOffre2{
           width: 1300px;
 margin: 0 -690px;
    }
</style>
