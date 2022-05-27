<?php

namespace Tests\Feature;

use Tests\AuthCase;

class LogoutTest extends AuthCase
{
    /** @test */
    public function test_user_can_logout_after_login()
    {
        $response = $this->delete('/api/logout');

        $response->assertStatus(200);

        $data =  $response->getOriginalContent();

        $this->assertEquals($data['message'], "User logged out successfully.");
    }

}
