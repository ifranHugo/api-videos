<?php

namespace Tests\Feature;

use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class YouCanGetAListOfSeriesTest extends TestCase
{
    use RefreshDatabase;
    public function test_that_you_can_get_a_listing_of_series():void
    {
        Serie::factory()->count(4)->create();
        $this->getJson('/api/series')->assertOk()->assertJsonCount(4);
    }

    public function test_that_the_preview_of_a_serie_has_the_format_correct():void
    {
        $id =1234;
        $title='un titulo';
        $thumbnail='http://unaimagen.com/imagen.jpg';
        $description ='mi resumen';
        Serie::factory()->create([
            'id'=>$id,
            'title'=>$title,
            'thumbnail'=>$thumbnail,
            'description'=>$description
        ]);
        $this->getJson('/api/series')
            ->assertExactJson([
                [
                'id'=>$id,
                'title'=>$title,
                'thumbnail'=>$thumbnail,
                'description'=>$description,
                ]
            ]);
    }
}
