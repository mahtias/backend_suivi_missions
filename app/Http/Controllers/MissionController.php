<?php

namespace App\Http\Controllers;
use App\Models\Mission;
use Illuminate\Http\Request;
use App\Repositories\Repository;

class MissionController extends Controller
{

    protected $model;

    public function __construct(Mission $model){
        
        $this->model = new Repository($model);
        //$this->fonctions = $fonctions;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        //
        return Mission::with(['historique_missions' => function ($query) {
            $query->orderBy('id', 'desc')->get();
        }])
        ->with('categorie_mission')
        ->withCount('historique_missions')

        ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $mission = new Mission;
      // $creation = $mission->create($request->only($mission->fillable));
        $mission->objet = $request->get('objet');
        $mission->date_mission = $request->get('date_mission');
     $mission->exercice_budgetaire_id = $request->get('exercice_budgetaire_id');
        $mission->categorie_missions_id = $request->get('categorie_missions_id');
        $mission->cout_total = $request->get('cout_total');
        $mission->numero_autorisation = $request->get('numero_autorisation');
        $mission->numero_ccm = $request->get('numero_ccm');
        $mission->type_mission = $request->get('type_mission');
        $mission->destination = $request->get('destination');
        $mission->itineraire_retenu = $request->get('itineraire_retenu');
        $mission->moyen_transport = $request->get('moyen_transport');
        $mission->classe_voyage = $request->get('classe_voyage');
        $mission->autre_frais = $request->get('autre_frais');
        $mission->cout_billet_avion = $request->get('cout_billet_avion');
        $mission->date_depart = $request->get('date_depart');
        $mission->date_retour = $request->get('date_retour');
        $mission->duree = $request->get('duree');
        $mission->mode_paiement = $request->get('mode_paiement');
       $mission->frais_restauration = $request->get('frais_restauration');
        $mission->frais_hebergement = $request->get('frais_hebergement');
         $mission->frais_deplacement = $request->get('frais_deplacement');
         $mission->acte_personnel_id = $request->get('acte_personnel_id');
        $mission->ua_id = $request->get('ua_id');
        
    
         $mission->signataire = $request->get('signataire');

        // commentaire
          if ($request->hasFile('fichier_joint')){
           // dd("bonjour");
           // echo 'bbbbbb';
            //recuperation du nom de fichier_joint
            $fullName = $request->file('fichier_joint')->getClientOriginalName();
            //recuperation du nom san l'extention
            $name = pathinfo($fullName,PATHINFO_FILENAME);
            //Recuperation de l'extension
         $extension = $request->file('fichier_joint')->getClientOriginalExtension();
            //creation du nom unique pour le fichier
            $nomDeFichier = $name.'_'.time().'.'.$extension;
            $destination = 'uploads/documents/';
             $request->file('fichier_joint')->move($destination, $nomDeFichier);
            $url_fichier_joint = url('/uploads/documents/'.$nomDeFichier);


           // $objet = Mission::find($creation->id);
            $mission->fichier_joint = $fullName;
            $mission->url_fichier_joint = $url_fichier_joint;

           // return response()->json(url('/uploads/documents/'.$nomDeFichier));


        }

         $mission->save();
         return response()->json(Mission::with(['historique_missions' => function ($query) {
            $query->latest()->first();
        }])
        ->with('categorie_mission')
            ->withCount('historique_missions')
            ->find($mission->id));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

$this->model->update($request->only($this->model->getModel()->fillable), $id);

 return response()->json(Mission::with(['historique_missions' => function ($query) {
            $query->latest()->first();
        }])
        ->with('categorie_mission')
        ->withCount('historique_missions')

        ->find($id));  
    }


  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return $this->model->delete($id);
    }
}
