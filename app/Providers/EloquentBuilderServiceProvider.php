<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class EloquentBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $likeOperator = DB::connection()->getDriverName() == 'pgsql' ? 'ILIKE' : 'LIKE';

            $searchTerms = collect(explode(' ', strtolower($searchTerm)))
                ->filter()
                ->map(function ($term) use ($attributes, $likeOperator) {
                    return function (Builder $query) use ($attributes, $term, $likeOperator) {
                        foreach (Arr::wrap($attributes) as $attribute) {
                            $query->orWhere($attribute, $likeOperator, "%$term%");
                        }
                    };
                });
        
            if ($searchTerms->count()) {
                $this->where(function (Builder $query) use ($searchTerms) {
                    $searchTerms->each(function ($term) use ($query) {
                        $query->orWhere($term);
                    });
                });
            }
        
            return $this;
        });
        
    }
}
