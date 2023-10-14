<?php

namespace App\QueryFilters\Base;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter {

	/**
     * The request object.
     *
     * @var object<\Illuminate\Http\Request>
     */
    protected $request;


    /**
     * The builder instance.
     *
     * @var object<\Illuminate\Database\Eloquent\Builder>
     */
    protected $builder;


    /**
     * Create a new QueryFilters instance.
     *
     * @param  object<\Illuminate\Http\Request> $request
     * @return void
     */
    public function __construct(Request $request) {

        $this->request = $request;
    }


    /**
     * Apply the filters to the builder.
     *
     * @param  object<\Illuminate\Database\Eloquent\Builder> $builder
     * @return object<\Illuminate\Database\Eloquent\Builder>
     */
    public function apply(Builder $builder) {

        $this->builder = $builder;
        
        foreach ($this->filters() as $name => $value) {
            
            if (! method_exists($this, $name)) {

                continue;
            }

            try {

                if(is_array($value) && count($value)){
                    $this->$name($value);
                }

                if( is_string($value) && strlen($value)){
                    $this->$name($value);
                }

            } catch (Exception $exception) {

                continue;
            }
        }

        return $this->builder;
    }


    /**
     * Get all request filters data.
     *
     * @return array
     */
    public function filters() {
        return optional($this->request)->all() ?? [];
    }
}