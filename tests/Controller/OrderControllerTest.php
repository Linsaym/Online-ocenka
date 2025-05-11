<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class OrderControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/order');

        self::assertResponseIsSuccessful();
    }

    public function testOrderValidation(): void {
        $client = static::createClient();
        $user = new User();
        $user->setEmail('test@mail.com');
        $user->setPassword('password');
        $client->loginUser($user);

        $crawler = $client->request('GET', '/order');
        $form = $crawler->selectButton('Подтвердить')->form();
        $form['order[email]'] = '';
        $client->submit($form);
        $this->assertSelectorTextContains('.error', 'Поле email обязательно');
    }
}
