<?php

namespace Tests\Unit;

use Tests\UnitCase;
use App\Utilities\Helpers;

class HelperTest extends UnitCase
{
    /**
     * A basic sku example.
     *
     * @return void
     */
    public function test_helper_success_responder_login()
    {
        $data = ['key_one' => 'value_one'];

        $response = (new Helpers)->successResponder($data,200);
        $response =  $response->getOriginalContent();

        $this->assertEquals($response['message'], "Action was Successfull");
        $this->assertEquals($response['data'], $data);
    }

    public function test_helper_error_responder_login()
    {
        $data = ['key_one' => 'value_one'];

        $response = (new Helpers)->errorResponder($data,400);
        $response =  $response->getOriginalContent();

        $this->assertEquals($response['message'], "Action was Unsuccessfull");
        $this->assertEquals($response['data'], $data);
    }
}
