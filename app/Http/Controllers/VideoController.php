<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use App\Dtos\VideoPreview;
use App\Http\Requests\ListadoDeVideosRequest;
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

        return Video::limit($request->getLimit())
            ->offset($request->getOffset())
            ->orderBy('created_at','desc')
            ->get()
            ->mapInto(VideoPreview::class);
    }
}
