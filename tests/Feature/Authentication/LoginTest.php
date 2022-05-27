<?php

namespace Tests\Feature\Authentication;

use Tests\UnauthCase;

class LoginTest extends UnauthCase
{
    /** @test */
    public function test_a_registered_user_should_be_able_to_log_in()
    {
        
        $this->post('/api/register', [
            "name" => "Godwin Daniel",
            "email" => "godwindaniel101@gmail.com",
            "password" => "password",
            "password_confirmation" => "password"
        ]);

        $response = $this->post('/api/login', [
            "email" => "godwindaniel101@gmail.com",
            "password" => "password",
        ]);

        $response->assertStatus(200);
        $data =  $response->getOriginalContent();

        $this->assertIsString($data['data']['token']);
        $this->assertEquals($data['data']['name'], "Godwin Daniel");
    }

    public function test_email_is_required_to_login_a_user()
    {
        $response = $this->post('/api/login', [
            "email" => "godwindaniel101@gmail.com",
            "password" => "",
        ]);

        $response->assertStatus(422);
    }

    public function test_email_and_password_most_be_valid_before_login_is_possible()
    {
        $this->post('/api/register', [
            "name" => "Godwin Daniel",
            "email" => "godwindaniel101@gmail.com",
            "password" => "password",
            "password_confirmation" => "password"
        ]);

        $response = $this->post('/api/login', [
            "email" => "godwindaniel101@gmail.com",
            "password" => "passwordInccorect",
        ]);

        $response->assertStatus(422);
        $data =  $response->getOriginalContent();

        $this->assertEquals($data['success'], false);
        $this->assertEquals('incorrect username or password.', $data['message']);
    }
}
