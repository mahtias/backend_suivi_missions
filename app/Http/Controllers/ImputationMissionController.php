<?php

namespace App\Http\Controllers;

use App\Models\ImputationMission;
use Illuminate\Http\Request;
use App\Repositories\Repository;


class ImputationMissionController extends Controller
{  

    protected $model;

    public function __construct(ImputationMission $exemple){
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
         return $this->model->with(['mission_imputation'])->get();

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
        $imputation = new ImputationMission;
        $creation = $imputation->create($request->only($imputation->fillable));

        return response()->json(ImputationMission::with(['mission_imputation'])->find($creation->id));

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

        return response()->json(ImputationMission::with(['mission_imputation'])->find($id));  

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
