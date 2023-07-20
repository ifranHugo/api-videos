<?php

namespace Tests\Feature;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class YouCanGetAVideoTest extends TestCase
{
    use RefreshDatabase;
   public function test_you_can_a_video_by_your_id(){
    //Crear el video en el sistema (base de datos)

    $video =Video::factory()->create();
    //llamar a api para pedir video
    $response =$this->get(sprintf('/api/videos/%s',$video->id));
    //comprobar que se devuelve el video
    $response->assertExactJson([
        'id'=>$video->id,
        'title'=>$video->title,
        'description'=>$video->description,
        'url_video'=>$video->url_video,
    ]);
   }
}
