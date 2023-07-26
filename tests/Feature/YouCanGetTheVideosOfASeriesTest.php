<?php

namespace Tests\Feature;

use App\Models\Serie;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class YouCanGetTheVideosOfASeriesTest extends TestCase
{
    use RefreshDatabase;
    public function test_you_can_get_the_videos_of_a_serie(){
        $serie = Serie::factory()->create();
        $videoId= Video::factory()->count(2)->create()->pluck('id')->toArray();
        $serie->videos()->attach($videoId);

        $this->getJson(sprintf('api/series/%s/videos',$serie->id))
            ->assertOk()
            ->assertJsonCount(2);
    }
    public function testTheContentOfVideosIsCorrect()
    {
        $serie = Serie::factory()->create();
        $video= Video::factory()->create();
        $serie->videos()->attach($video->id);

        $this->getJson(sprintf('api/series/%s/videos',$serie->id))
            ->assertOk()
            ->assertExactJson([
                [
                    'id'=>$video->id,
                    'thumbnail'=>$video->thumbnail
                ],
            ]);

    }
}
