<?php

namespace Tests\Feature;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class YouCanGetAListOfVideosTest extends TestCase
{
    use RefreshDatabase;
    public function test_off_that_can_it_get_video_list():void
    {
        Video::factory()->count(2)->create();

        $this->getJson('/api/videos')
            ->assertOk()
            ->assertJsonCount(2);
    }
    public function test_that_the_preview_the_a_video_has_id_and_thumbnail():void
    {
        $unId=1234;
        $unThumbnail='http://unaimagen.com';
        Video::factory()->create([
            'id'=>$unId,
            'thumbnail'=>$unThumbnail,
        ]);
        $this->getJson('/api/videos')
            ->assertExactJson([
                [
                'id'=>$unId,
                'thumbnail'=>$unThumbnail,
                ]
            ]);

    }
    public function test_that_the_videos_are_sorted_from_newest_to_oldest():void
    {
        $videoUnMes= Video::factory()->create([
            'created_at'=>Carbon::now()->subDays(30)
        ]);

        $videoHoy= Video::factory()->create([
            'created_at'=>Carbon::now()
        ]);

        $videoAyer= Video::factory()->create([
            'created_at'=>Carbon::yesterday()
        ]);

        $this->getJson('/api/videos')
        ->assertJsonPath('0.id',$videoHoy->id)
        ->assertJsonPath('1.id',$videoAyer->id)
        ->assertJsonPath('2.id',$videoUnMes->id);
    }
    public function test_that_can_be_limit_the_number_of_Video_to_get(){
        Video::factory()->count(4)->create();
        $this->getJson('/api/videos?limit=3')
            ->assertJsonCount(3);
    }
    public function test_that_return_a_processable_when_the_limit_is_a_string()
    {
        Video::factory()->count(4)->create();
        $this->getJson('/api/videos?limit=unstring')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
