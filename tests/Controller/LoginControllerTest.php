<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LoginControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        self::assertResponseIsSuccessful();
    }

    public function testOrderPageUnauthorized(): void {
        $client = static::createClient();
        $client->request('GET', '/order');
        $this->assertResponseRedirects('/login');
    }

    public function testOrderPageAuthorized(): void {
        $client = static::createClient();
        $user = new User();
        $user->setEmail('test@mail.com');
        $user->setPassword('password');
        $client->loginUser($user);

        $client->request('GET', '/order');
        $this->assertSelectorExists('form');
    }

}
