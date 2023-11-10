<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $seed = true;

    public function actingAsUser($user)
    {
        $token = JWTAuth::fromUser($user);

        $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

        return $this;
    }
}
