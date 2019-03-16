<?php

if (! function_exists('create_random_file_name')) {
    function create_random_file_name($input)
    {
        $fileName = md5(rand(10, 15)) . '.' . $input;
        return $fileName;
    }
}

if (! function_exists('logo_path')) {
    function logo_path()
    {
        return url('/') . '/uploads/gym/logo/';
    }
}

if (! function_exists('banner_path')) {
    function banner_path()
    {
        return url('/') . '/uploads/gym/banner/';
    }
}

if (! function_exists('logo_path_real')) {
    function logo_path_real()
    {
        return public_path() . '/uploads/gym/logo/';
    }
}

if (! function_exists('banner_path_real')) {
    function banner_path_real()
    {
        return public_path() . '/uploads/gym/banner/';
    }
}
