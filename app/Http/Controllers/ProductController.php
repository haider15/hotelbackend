<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'adresse' => 'required',
           
        ]);

        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
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
        $product = Product::find($id);
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }
    public function getProductsByActivity(Request $request)
    {
        // Valider l'ID de l'activité
        $request->validate([
            'activity_id' => 'required|exists:activities,id'
        ]);

        // Récupérer l'ID de l'activité depuis la requête
        $activityId = $request->activity_id;

        // Récupérer les produits associés à l'activité
        $products = Product::where('activity_id', $activityId)->get();

        return response()->json($products);
    }

    public function getProductsByActivityName($activityName)
    {
        // Rechercher l'activité par son nom
        $activity = Activity::where('name', $activityName)->first();

        // Vérifier si l'activité existe
        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        // Récupérer les produits associés à l'activité
        $products = Product::where('activity_id', $activity->id)->get();

        return response()->json($products);
    }

}
