<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('check_scheme_url')) {
    function check_scheme_url($url) {
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (!empty($scheme)) {
            return $url;
        } else {
            return 'http://'.$url;
        }
    }
}

if (!function_exists('check_file_exist')) {
    function check_file_exist($url, $type, $filename = '') {
        if ($filename) {
            if (Storage::disk('public')->exists($url)) {
                $image_url =  '/storage/'.$url.$filename;
            } else {
                if ($type == 'masthead') {
                    $image_url = '/assets/images/default-masthead.jpg';
                } elseif ($type == 'thumb') {
                    $image_url = '/assets/images/default-thumb.jpg';
                } else {
                    $image_url = '/assets/images/default-logo.jpeg';
                }
            }    
        } else {
            if ($type == 'masthead') {
                $image_url = '/assets/images/default-masthead.jpg';
            } elseif ($type == 'thumb') {
                $image_url = '/assets/images/default-thumb.jpg';
            } else {
                $image_url = '/assets/images/default-logo.jpeg';
            }
        }
        return $image_url;
    }
}