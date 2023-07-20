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
    public function test_that_by_default_only_return_30_videos()
    {
        Video::factory()->count(100)->create();

        $this->getJson('/api/videos')
            ->assertJsonCount(30);
    }
    public function providerLimitInvaled():array
    {
        return [
            'The min of videos that can be brought is 1'=>[3,'-1'],
            'You can not get more than 50 videos'=>[53,'51'],
            'You cannot pass a limit that is a string'=>[4,'unstring']
        ];
    }
    /**
    *@dataProvider providerLimitInvaled
    **/
    public function test_return_an_processable_if_there_is_error_in_the_limit(
        int $numeroDeVIdeosACrear,
        string $limit)
    {
        Video::factory()->count($numeroDeVIdeosACrear)->create();

        $this->getJson(sprintf('/api/videos?limit=%s',$limit))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_that_you_can_paginate_the_videos()
    {
        Video::factory()->count(9)->create();

        $this->getJson('/api/videos?limit=5&page=2')
            ->assertJsonCount(4);
    }
    public function test_that_the_default_page_is_the_first()
    {
        Video::factory()->count(9)->create();

        $this->getJson('/api/videos?limit=5')
            ->assertJsonCount(5);
    }

    public function providerOfPageInvalid():array
    {
        return [
            'Cannot pass a string like Page'=>['unstring'],
            'the page can not be less than one'=>['0']
        ];
    }

    /**
    * @dataProvider providerOfPageInvalid
    **/
    public function test_that_returns_an_processable_if_there_errors_in_the_page(
        $invalidPage
    )
    {
        Video::factory()->count(9)->create();
        $this->getJson(sprintf('/api/videos?page=%s',$invalidPage))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
