<?php

namespace App\Http\Backend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Http\Requests\Bookings\CreateBookingRequest;
use App\Http\Requests\Bookings\UpdateBookingRequest;
use Illuminate\Support\Facades\Response;

class BookingsController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $bookings = Booking::paginate(20);

        $index = $bookings->firstItem();

        return view('bookings.index', compact('bookings', 'index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateBookingRequest $request)
    {
        $booking = Booking::create($request->all());

        return redirect()->route('bookings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
    
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateBookingRequest $request, $id)
    {       
        $booking = Booking::findOrFail($id);

        $booking->update($request->all());

        return redirect()->route('bookings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        
        $booking->delete();
    
        return redirect()->route('bookings.index');
    }

}
