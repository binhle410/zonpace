<?php

namespace App\Repositories\Backend\House;

use App\Exceptions\GeneralException;
use App\Models\House\House;

/**
 * Class EloquentHouseRepository
 * @package App\Repositories\Backend\House
 */
class EloquentHouseRepository implements HouseContract
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function findOrThrowException($id)
    {
        $model = House::find($id);

        if (!is_null($model)) {
            return $model;
        }

        throw new GeneralException(trans('exceptions.backend.access.houses.not_found'));
    }

    /**
     * @param int    $per_page
     * @param int    $status
     * @param string $order_by
     * @param string $sort
     *
     * @return mixed
     */
    public function getHousesPaginated($perPage = null, $status = null, $orderBy = 'updated_at', $sort = 'desc')
    {
        $perPage = $perPage !== null ? : config('pagination.default_per_page');

        if ($status !== null) {
            return House::where('status', $status)
                ->orderBy('status', 'asc')
                ->orderBy('updated_at', 'asc')
                ->orderBy($orderBy, $sort)
                ->paginate($perPage);
        }

        return House::orderBy('status', 'asc')->orderBy($orderBy, $orderBy)->paginate($perPage);
    }

    /**
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getAllHouses($orderBy = 'id', $sort = 'asc')
    {
        return House::orderBy($orderBy, $sort)->get();
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function create($input)
    {
        $model = $this->_createHouseStub($input);

        if ($model->save()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.houses.create_error'));
    }

    /**
     * @param int $id
     * @param array $input
     *
     * @return mixed
     */
    public function update($id, $input)
    {
        $model = $this->findOrThrowException($id);

        if ($model->update($input)) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.houses.update_error'));
    }

    /**
     * @param int $id
     * @param int $status
     *
     * @return mixed
     */
    public function mark($id, $status)
    {
        $model = $this->findOrThrowException($id);
        $model->status = $status;

        if ($model->save()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.houses.mark_error'));
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        $model = $this->findOrThrowException($id);

        if ($model->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.houses.delete_error'));
    }

    /**
     * @param array $input
     *
     * @return House
     */
    private function _createHouseStub($input)
    {
        $model = new House;
        $model->user_id = array_get($input, 'user_id');
        $model->name = array_get($input, 'name');
        $model->display_name = array_get($input, 'display_name');
        $model->nor = array_get($input, 'nor');
        $model->max_guest = array_get($input, 'max_guest');
        $model->status = array_get($input, 'status');

        return $model;
    }
}