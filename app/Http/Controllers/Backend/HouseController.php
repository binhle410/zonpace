<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Backend\House\HouseContract;
use App\Repositories\Backend\User\UserContract;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HouseController extends Controller
{

    protected $houses;
    protected $users;

    public function __construct(HouseContract $houses, UserContract $users)
    {
        $this->houses = $houses;
        $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.houses.index')->withHouses($this->houses->getHousesPaginated());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Requests\House\CreateHouseRequest $request)
    {

        return view('backend.houses.create')->withUsers($this->users->getAllUsers());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\House\StoreHouseRequest $request)
    {
        $this->houses->create($request->all());

        return redirect()->route('admin.houses.index')->withFlashSuccess(trans('alerts.backend.houses.created'));
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
        $house = $this->houses->findOrThrowException($id);

        return view('backend.houses.edit')->withHouse($house)->withUsers($this->users->getAllUsers());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Requests\House\UpdateHouseRequest $request)
    {
        $this->houses->update($id, $request->all());

        return redirect()->route('admin.houses.index')->withFlashSuccess(trans('alerts.backend.houses.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Requests\House\DeleteHouseRequest $request)
    {
        $this->houses->destroy($id);

        return redirect()->route('admin.houses.index')->withFlashSuccess(trans('alerts.backend.houses.deleted'));
    }
}
