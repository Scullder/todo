<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait FilterTrait
{
    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];

    public function getFilters(Request $request) 
    {
        if (!isset($this->allowedFilterColumns)) {
            return [];
        }

        $eloquentQuery = [];

        foreach ($this->allowedFilterColumns as $column => $operators) {
            if (!$query = $request->query($column)) {
                continue;
            }

            foreach ($operators as $operator) {
                if(isset($query[$operator])) {
                    $eloquentQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloquentQuery;
    }
}
