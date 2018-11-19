<?php

function findOrCreatePath($path){
    $result_path = explode('/', $path)[0];

    if(!file_exists($result_path)){
        mkdir($result_path);
    }
    
    for( $i = 1; $i < count(explode('/', $path)); $i++) {
        $result_path = $result_path.'/'.explode('/', $path)[$i];
        if(!file_exists($result_path)){
            mkdir($result_path);
        }
    }

    return $result_path;
}