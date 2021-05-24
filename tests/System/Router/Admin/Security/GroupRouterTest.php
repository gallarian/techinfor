<?php

/**
 * @Author: Gallarian <gallarian@gmail.com>
 */

namespace App\Tests\System\Router\Admin\Security;

use App\Repository\Security\GroupRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GroupRouterTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testGroupIndexGet(): void
    {
        $this->client->request(Request::METHOD_GET, "/administration/groupes");

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGroupShowGet(): void
    {
        $group = static::$container->get(GroupRepository::class)->findOneBy([]);
        $this->client->request(Request::METHOD_GET, "/administration/groupes/{$group->getId()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGroupCreateGet(): void
    {
        $this->client->request(Request::METHOD_GET, "/administration/groupes/creation");

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGroupCreatePost(): void
    {
        $this->client->request(Request::METHOD_POST, "/administration/groupes/creation");

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGroupUpdateGet(): void
    {
        $group = static::$container->get(GroupRepository::class)->findOneBy([]);
        $this->client->request(Request::METHOD_GET, "/administration/groupes/mise-a-jour/{$group->getId()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGroupUpdatePatch(): void
    {
        $group = static::$container->get(GroupRepository::class)->findOneBy([]);
        $this->client->request(Request::METHOD_PATCH, "/administration/groupes/mise-a-jour/{$group->getId()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGroupActivatePatch(): void
    {
        $group = static::$container->get(GroupRepository::class)->findOneBy([]);
        $this->client->request(Request::METHOD_PATCH, "/administration/groupes/activation/{$group->getId()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testGroupDeactivatePatch(): void
    {
        $group = static::$container->get(GroupRepository::class)->findOneBy([]);
        $this->client->request(Request::METHOD_PATCH, "/administration/groupes/desactivation/{$group->getId()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testGroupDelete(): void
    {
        $group = static::$container->get(GroupRepository::class)->findOneBy([]);
        $this->client->request(Request::METHOD_DELETE, "/administration/groupes/{$group->getId()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
