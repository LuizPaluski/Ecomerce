<?php
namespace App\Repositories\Uploads;

use Illuminate\Http\Request;

class ImagenRepository
{
    public function uploadPublicImage(Request $request): false|string|null
    {
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            return $request->file('cover')->store('series_cover', 'public');
        }

        return null;
    }
}

