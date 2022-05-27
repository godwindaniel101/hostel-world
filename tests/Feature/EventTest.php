<?php

namespace Tests\Feature;

use DateTime;
use Tests\AuthCase;
use Illuminate\Support\Str;

class EventTest extends AuthCase
{
    public function test_event_authentication()
    {
        $response = $this->get('/api/events');
        $response->assertStatus(200);
        $data =  $response->getOriginalContent();
        $this->assertEquals($data['message'], "Events called successfully.");
    }

    public function test_to_ensure_only_valid_date()
    {

        $yesterday = new DateTime('yesterday'); 
        $date = $yesterday->format('Y-m-d');
        $response = $this->get('/api/events?date='.$date);
        $response->assertStatus(422);
        $data =  $response->getOriginalContent();
        $this->assertEquals($data['message'], "The date must be a date after yesterday.");
    }

    public function test_to_ensure_only_valid_date_format()
    {
        $yesterday = new DateTime('today'); 
        $date = $yesterday->format('d-m-Y');
        $response = $this->get('/api/events?date='.$date);
        $response->assertStatus(422);
        $data =  $response->getOriginalContent();
        $this->assertEquals($data['message'], "The date does not match the format Y-m-d.");
    }

    public function test_to_event_is_empty_when_search_does_not_exist()
    {
        $term = Str::random(50);
        $response = $this->get('/api/events?term='. $term);
        $response->assertStatus(200);
        $data =  $response->getOriginalContent();
        $this->assertEquals($data['message'], "Events called successfully.");
        $this->assertEmpty($data['data']['data']);
    }

    public function test_to_event_is_not_empty_when_search_exist()
    {
        $term = 'fugiat';
        $response = $this->get('/api/events?term='. $term);
        $data = $response->getContent();
        $data = json_decode(json_encode($response) , true)['baseResponse']['original'];
        $response->assertStatus(200);
        $this->assertEquals($data['message'], "Events called successfully.");
        $this->assertNotNull($data['data']['data']);
    }
}
