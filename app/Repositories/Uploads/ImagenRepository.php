<?php
namespace App\Repositories\Uploads;

use Illuminate\Http\Request;

class ImagenRepository
{
    public function uploadPublicImage(Request $request): false|string|null{

        $coverPath = $request->hasFile('cover')
            ? $request->file('cover')->store('series_cover',' public')
            : null;
        return $coverPath;
    }



}
