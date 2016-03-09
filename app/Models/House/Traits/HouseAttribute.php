<?php

namespace App\Models\House\Traits;

/**
 * Class UserAttribute
 * @package App\Models\Access\User\Traits\Attribute
 */
trait HouseAttribute
{
    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 0:
                return "<label class='label label-warning'>".trans('labels.general.statuses.pending')."</label>";
            break;
            case 1:
                return "<label class='label label-success'>".trans('labels.general.statuses.approved')."</label>";
            break;
            case 2:
                return "<label class='label label-danger'>".trans('labels.general.statuses.denied')."</label>";
            break;
            default:
                return '';
            break;
        }
    }

    /**
     * @return bool
     */
    public function getIsPendingAttribute()
    {
        return $this->status == 0;
    }

    /**
     * @return bool
     */
    public function getIsApprovedAttribute() {
        return $this->status == 1;
    }

    /**
     * @return bool
     */
    public function getIsDeniedAttribute() {
        return $this->status == 2;
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.houses.edit', $this->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.houses.destroy', $this->id) . '"
             data-method="delete"
             data-trans-button-cancel="'.trans('buttons.general.cancel').'"
             data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
             data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
             class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.delete') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getEditButtonAttribute() . $this->getDeleteButtonAttribute();
    }
}
