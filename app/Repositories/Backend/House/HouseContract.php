<?php

namespace App\Repositories\Backend\House;

/**
 * Interface HouseContract
 * @package App\Repositories\House
 */
interface HouseContract
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * @param int    $per_page
     * @param int    $status
     * @param string $order_by
     * @param string $sort
     *
     * @return mixed
     */
    public function getHousesPaginated($perPage = null, $status = null, $orderBy = 'id', $sort = 'asc');

    /**
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getAllHouses($orderBy = 'id', $sort = 'asc');

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function create($input);

    /**
     * @param int $id
     * @param array $input
     *
     * @return mixed
     */
    public function update($id, $input);

    /**
     * @param int $id
     * @param int $status
     *
     * @return mixed
     */
    public function mark($id, $status);

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function destroy($id);
}