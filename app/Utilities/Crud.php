<?php

namespace App\Utilities;

class Crud {

    public static function createIndexParams($resource) {
        $config = \Config::get('constants')->config;
        $config->basePath = $resource->apiBasePath;
        $config->resource = $resource->name;

        $values = $resource->fields;
        return [$config, $values];
    }
    
}