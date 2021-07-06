<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Getting the path of the user image.
     */
    public function get($id, $filename)
    {
        $path = storage_path("app/user/$id/$filename");

        if (!File::exists($path))
        {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * Getting the path of the logo of the club.
     */
    public function getLogo($id)
    {
        $club = Club::find($id)->first();
        $filename = $club->logo;

        $path = storage_path("app/logo/$id/$filename");

        if (!File::exists($path))
        {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
