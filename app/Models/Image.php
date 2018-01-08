<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

use DB;

class Image extends Moloquent {

    protected $connection = 'mongodb';
    protected $collection = 'Images';

    public static function PostImage($data) {
        $insertData = DB::connection('mongodb')->collection('Images')->insert($data);
        if ($insertData) {
            return true;
        } else {
            return false;
        }
    }

    public static function GetImages()
    {
        return DB::connection('mongodb')->collection('Images')->get(['smallurl', 'mediumurl', 'largeurl']);
    }

    public static function GetImagesWithData()
    {
        return DB::connection('mongodb')->collection('Images')->get();
    }

    public static function DeleteImages()
    {
        return DB::connection('mongodb')->collection('Images')->truncate();
    }

}
