<?php

namespace App\Http\Controllers;

use App\Models\HistoriqueMission;
use App\Models\Mission;

use Illuminate\Http\Request;
use App\Repositories\Repository;


class HistoriqueMissionController extends Controller
{  

    protected $model;

    public function __construct(HistoriqueMission $exemple){
        $this->model = new Repository($exemple);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        // model avec relation
         return $this->model->with(['missions'])->get();

        // fin model avec relation

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
       

         // model avec relation
        $historiqueMission = new HistoriqueMission;
        $creation = $historiqueMission->create($request->only($historiqueMission->fillable));


return response()->json(Mission::with(['historique_missions' => function ($query) {
            $query->latest()->first();
        }])
        ->with('categorie_mission')
        ->withCount('historique_missions')

        ->find($request->get('mission') ), 201 );
        // fin model avec relation



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exemple  $Exemple
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->model->show($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exemple  $exemple
     * @return \Illuminate\Http\Response
     */
    public function edit(Exemple $exemple)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exemple  $exemple
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          // model avec relation
        $this->model->update($request->only($this->model->getModel()->fillable), $id);

        return response()->json(HistoriqueMission::with(['missions'])->find($id));  

        // fin model avec relation

  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exemple  $exemple
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        return $this->model->delete($id);

    }
}
