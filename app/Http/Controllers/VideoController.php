<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Requests\ListadoDeVideosRequest;
use App\Http\Resources\VideoPreview;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class VideoController extends Controller
{
    public function get(Video $video):Video
    {
        return $video;
    }
    public function index(ListadoDeVideosRequest $request):mixed
    {
        $videos=Video::ultimo($request->getLimit(), $request->getOffset())
            ->get();

        return VideoPreview::collection($videos);
    }
}
