<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository 
{
    // déclaration de la propiété model 
    protected $model;

    // initialisation du constructeur
    public function __construct(Model $model){
        $this->model = $model;
    }

       // retourne toutes les instances
    public function all(){
        return response()->json($this->model->all(), 200); 
    }

    // enregistrer dans la base de données
    public function create(array $data){
        return response()->json($this->model->create($data), 201);
    }

     // modification
     public function update(array $data, $id)
     {
         $record = $this->model->find($id);
         return response()->json($record->update($data), 200);
     }

    // suppression
    public function delete($id){
        $this->model->destroy($id);
        return response()->json(null, 204);
    }

    // show
    public function show($id){
        return response()->json($this->model->findOrFail($id), 200);

    }

     // getter du model 
     public function getModel()
     {
         return $this->model;
     }


     // setter du model
     public function setModel($model)
     {
         $this->model = $model;
         return $this;
     }
 
     // cette fonction charge les relations
     public function with($relations)
     {
         return $this->model->with($relations);
     }


}
