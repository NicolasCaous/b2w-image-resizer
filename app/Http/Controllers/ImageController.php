<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Image as ImageMongo;
use GuzzleHttp\Client;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

class ImageController extends BaseController
{

    public function index()
    {
        $images = ImageMongo::GetImages();
        foreach ($images as $image)
        {
            unset($image['_id']);
        }
        return Response()->json([
            'images' => $images
        ], 200);
    }

    public function show($name)
    {
        $images = ImageMongo::GetImagesWithData()->toArray();
        foreach ($images as $image)
        {
            if (((string) $image['smallurl']) == str_replace("http", "https", url()).'/images/'.$name)
            {
                return ImageIntervention::make(((string) $image['smalldata']))->response();
            }
            if (((string) $image['mediumurl']) == str_replace("http", "https", url()).'/images/'.$name)
            {
                return ImageIntervention::make(((string) $image['mediumdata']))->response();
            }
            if (((string) $image['largeurl']) == str_replace("http", "https", url()).'/images/'.$name)
            {
                return ImageIntervention::make(((string) $image['largedata']))->response();
            }
        }
        return Response()->json([], 404);
    }

    public function store(Request $request)
    {
        ImageMongo::DeleteImages();
        $client = new Client();
        $res = json_decode($client->get('http://54.152.221.29/images.json')->getBody(), true);

        ImageIntervention::configure(array('driver' => 'imagick'));

        foreach ($res['images'] as $image)
        {
            $insert = [];

            $name = explode("/", $image['url']);

            $insert['smalldata'] = (string) ImageIntervention::make($image['url'])->resize(320, 240)->encode('data-url');
            $insert['smallurl'] = str_replace("http", "https", url()).'/images/'.end($name).'small';

            $insert['mediumdata'] = (string) ImageIntervention::make($image['url'])->resize(384, 288)->encode('data-url');
            $insert['mediumurl'] = str_replace("http", "https", url()).'/images/'.end($name).'medium';

            $insert['largedata'] = (string) ImageIntervention::make($image['url'])->resize(640, 480)->encode('data-url');
            $insert['largeurl'] = str_replace("http", "https", url()).'/images/'.end($name).'large';

            ImageMongo::PostImage($insert);
        }

        return Response()->json(['ok' => 'ok'], 200);
    }

}
