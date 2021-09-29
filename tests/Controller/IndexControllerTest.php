<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
class IndexControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $em = static::getContainer()->get('doctrine')->getManager();

        $purger = new ORMPurger($em);
        $purger->purge();

        $user1 = new User();
        $user1->setFirstname('Toto');
        $user1->setLastname('XX');
        $user1->setEmail('toto@toto.com');
        $user1->setPassword('...');

        $user2 = new User();
        $user2->setFirstname('Tata');
        $user2->setLastname('XX');
        $user2->setEmail('tata@tata.com');
        $user2->setPassword('...');

        $em->persist($user1);
        $em->persist($user2);
        $em->flush();

        $client->loginUser($user1);
        $crawler = $client->request('GET', '/index');
        $this->assertResponseIsSuccessful();
        $this->assertSame('Hello Toto!', $crawler->filter('h1')->text(null, true));

        $client->loginUser($user2);
        $crawler = $client->request('GET', '/index');
        $this->assertResponseIsSuccessful();
        $this->assertSame('Hello Tata!', $crawler->filter('h1')->text(null, true));
    }
}
