<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::all();
        return response()->json($reservations);
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
        'user_id' => 'required',
        'product_id' => 'required',
        'date_debut' => 'required|date',
        'date_fin' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($request) {
                $date_debut = $request->input('date_debut');
                if (strtotime($value) <= strtotime($date_debut)) {
                    $fail('La date de fin doit être postérieure à la date de début.');
                }
            },
        ],
    ]);

    $reservation = Reservation::create($request->all());
    return response()->json($reservation, 201);
}

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return response()->json($reservation);
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
        $reservation = Reservation::findOrFail($id);
        $reservation->update($request->all());
        return response()->json($reservation, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Reservation::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
