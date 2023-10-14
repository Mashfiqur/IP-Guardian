<?php

namespace App\QueryFilters\IpAddress;

use App\QueryFilters\Base\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class IpAddressFilter extends QueryFilter {

    /**
     * Filter by label
     *
     * @param  string $values
     * @return object<\Illuminate\Database\Eloquent\Builder>
     */
    public function label($values): Builder
    {
        return $this->builder->whereLike('label', $values);
    }


    /**
     * Filter by a global query
     *
     * @param  string $values
     * @return object<\Illuminate\Database\Eloquent\Builder>
     */
    public function query($values): Builder
    {
        return $this->builder->whereLike([config('uuid.column'), 'ip', 'label', 'comment'], $values);
    }


    /**
     * Filter by status. This is for Soft Delete & Trash feature 
     * status: 1=Active, 2==Trash
     *
     * @param  string $values
     * @return object<\Illuminate\Database\Eloquent\Builder>
     */
    public function status($values): Builder
    {
        if(intval($values) === 2){
            return $this->builder->onlyTrashed();
        }
    }
}