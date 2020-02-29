<?php

namespace App\Http\Controllers;
use App\Models\Mission;
use Illuminate\Http\Request;
use App\Repositories\Repository;

class UploadController extends Controller
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
      
    }
    public function upload(Resquest $request){

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
       
    }
}
