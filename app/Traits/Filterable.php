<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Scope untuk filter dinamis.
     * Penggunaan: Model::filter($request->only(['search', 'status']))->get();
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $value) {
            if (method_exists($this, 'scope' . ucfirst($key))) {
                $query->{$key}($value);
            } elseif (!empty($value) && in_array($key, $this->filterable ?? [])) {
                $query->where($key, $value);
            }
        }

        return $query;
    }

    /**
     * Scope untuk pencarian global (Search).
     */
    public function scopeSearch(Builder $query, string $term = null): Builder
    {
        if (!$term) return $query;

        $columns = $this->searchable ?? ['name', 'title', 'description'];

        return $query->where(function ($q) use ($columns, $term) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'LIKE', "%{$term}%");
            }
        });
    }
}
