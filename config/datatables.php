<?php

return [
    'namespace' => [
        'base' => 'Yajra\\DataTables\\',
        'model' => 'App\\Models\\',
        'resource' => 'App\\Http\\Resources\\',
    ],
    'search' => [
        'smart' => true,
        'case_insensitive' => true,
        'use_wildcards' => false,
    ],
    'index_column' => 'DT_RowIndex',
    'engines' => [
        'eloquent' => 'Yajra\\DataTables\\EloquentDataTable',
        'query' => 'Yajra\\DataTables\\QueryDataTable',
        'collection' => 'Yajra\\DataTables\\CollectionDataTable',
    ],
    'builders' => [
        'Illuminate\Database\Eloquent\Relations\Relation' => 'eloquent',
        'Illuminate\Database\Eloquent\Builder' => 'eloquent',
        'Illuminate\Database\Query\Builder' => 'query',
        'Illuminate\Support\Collection' => 'collection',
    ],
];

