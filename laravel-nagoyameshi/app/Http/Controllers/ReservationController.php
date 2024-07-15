<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Store;
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
        $user_id = Auth::id();

        $reservations = Reservation::where('user_id', $user_id)->orderBy('reservation_date', 'desc')->orderBy('reservation_time', 'desc')->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($store_id)
    {
        $store = Store::findOrFail($store_id);
        
        $dates = collect(range(1, 21))->map(function ($day) {
            return now()->addDays($day)->format('Y-m-d');
        });

        $times = collect(range(10, 22))->flatMap(function ($hour) {
            return [
                sprintf('%02d:00', $hour),
            ];
        });

        $peopleNumbers = range(1, 30);
        
        return view('reservations.create', compact('store', 'dates', 'times', 'peopleNumbers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $store_id)
    {
        $reservation = new Reservation();
        $reservation->reservation_date = $request->input('reservation_date');
        $reservation->reservation_time = $request->input('reservation_time');
        $reservation->reservation_people_number = $request->input('reservation_people_number');
        $reservation->store_id = $request->input('store_id');
        $reservation->user_id = Auth::user()->id;
        $reservation->save();

        return to_route('reservations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $store = Store::findOrFail($reservation->store_id);
        
        return view('reservations.show', compact('reservation', 'store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $store = Store::findOrFail($reservation->store_id);

        $dates = collect(range(1, 21))->map(function ($day) {
            return now()->addDays($day)->format('Y-m-d');
        });

        $times = collect(range(10, 22))->flatMap(function ($hour) {
            return [
                sprintf('%02d:00', $hour),
            ];
        });

        $peopleNumbers = range(1, 30);

        return view('reservations.edit', compact('reservation', 'store', 'dates', 'times', 'peopleNumbers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        $reservation->reservation_date = $request->input('reservation_date');
        $reservation->reservation_time = $request->input('reservation_time');
        $reservation->reservation_people_number = $request->input('reservation_people_number');
        $reservation->store_id = $request->input('store_id');
        $reservation->user_id = Auth::user()->id;
        $reservation->update();

        return to_route('reservations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return to_route('reservations.index');
    }
}
