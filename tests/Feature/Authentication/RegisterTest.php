<?php

namespace Tests\Feature\Authentication;

use Tests\UnauthCase;

class RegisterTest extends UnauthCase
{

    /** @test */  
    public function test_a_new_user_can_be_created_and_token_generated()
    {
        $response = $this->post('/api/register', [
            "name" => "Godwin Daniel",
            "email" => "godwindaniel101@gmail.com",
            "password" => "password",
            "password_confirmation" => "password"
        ]);

        $response->assertStatus(201);
        $data =  $response->getOriginalContent();

        $this->assertEquals($data['data']['email'], "godwindaniel101@gmail.com");
        $this->assertEquals($data['data']['name'], "Godwin Daniel");
    }

    public function test_name_is_required_to_create_a_user()
    {
        $response = $this->post('/api/register', [
            "name" => "",
            "email" => "godwindaniel101@gmail.com",
            "password" => "password",
            "password_confirmation" => "password"
        ]);

        $response->assertStatus(422);
    }

    public function test_email_is_required_to_test_a_user()
    {
        $response = $this->post('/api/register', [
            "name" => "Godwin",
            "email" => "",
            "password" => "password",
            "password_confirmation" => "password"
        ]);

        $response->assertStatus(422);
    }

    public function test_email_has_to_be_unique_to_create_a_user()
    {
        $this->post('/api/register', [
            "name" => "Godwin",
            "email" => "godwindaniel101@gmail.com",
            "password" => "password",
            "password_confirmation" => "password"
        ]);

        $response = $this->post('/api/register', [
            "name" => "Godwin",
            "email" => "godwindaniel101@gmail.com",
            "password" => "password",
            "password_confirmation" => "password"
        ]);

        $response->assertStatus(422);
        $data =  $response->getOriginalContent();

        $this->assertEquals($data['success'], false);
        $this->assertEquals('The email has already been taken.', $data['message']);
    }
  
}
