<?php

namespace App\Concerns\Model;

use App\QueryFilters\Base\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable {

	/**
     * Filter from request params
     *
     * @param  object<\Illuminate\Database\Eloquent\Builder> 	$query
     * @param  object<\App\QueryFilter\Base\QueryFilter>      	$queryFilter
     *
     * @return object<\Illuminate\Database\Eloquent\Builder>
     */
	public function scopeFilter($query, QueryFilter $queryFilter): Builder 
    {
		return $queryFilter->apply($query);
	}
}