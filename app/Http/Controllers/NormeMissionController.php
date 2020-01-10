<?php

namespace App\Http\Controllers;

use App\Models\NormeMission;
use Illuminate\Http\Request;
use App\Repositories\Repository;


class NormeMissionController extends Controller
{     

    protected $model;

    public function __construct(NormeMission $model){
        $this->model = new Repository($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        // model sans relation
         return $this->model->all();
        //return 'ok';

        // fin model sans relation

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


               //model sans relation
   return $this->model->create($request->only($this->model->getModel()->fillable));
         // fin model sans relation



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model  $model
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         return $this->model->show($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(model $model)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //model sans relation
     $this->model->update($request->only($this->model->getModel()->fillable), $id);
         return $this->model->show($id);
         // fin model sans relation

  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        return $this->model->delete($id);

    }
}
