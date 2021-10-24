<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        // (new self())->truncateEntities();
    }

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
    }

    private function truncateEntities()
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testListingOfCars()
    {
        $this->client->request('GET', '/cars', [], [], ['CONTENT_TYPE' => 'application/json']);

        $response = $this->client->getResponse();
        $actualResponseContent = $response->getContent();
        $expectedResponseContent = '[{"id":1,"make":"BMW","model":"M3","build_date":"2020-10-15","colour":"white"},{"id":2,"make":"Audi","model":"A3","build_date":"2019-02-13","colour":"black"}]';

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson($actualResponseContent);
        $this->assertJsonStringEqualsJsonString($expectedResponseContent, $actualResponseContent);
    }

    public function testSuccessfullGetCarFromId()
    {
        $this->client->request('GET', '/car/1', [], [], ['CONTENT_TYPE' => 'application/json']);

        $response = $this->client->getResponse();
        $actualResponseContent = $response->getContent();
        $expectedResponseContent = '{"id":1,"make":"BMW","model":"M3","build_date":"2020-10-15","colour":"white"}';

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson($actualResponseContent);
        $this->assertJsonStringEqualsJsonString($expectedResponseContent, $actualResponseContent);
    }

    public function testUnsuccessfullGetCarFromId()
    {
        $this->client->request('GET', '/car/5', [], [], ['CONTENT_TYPE' => 'application/json']);

        $response = $this->client->getResponse();
        $actualResponseContent = $response->getContent();
        $expectedResponseContent = '{"message":"The car does not exist."}';

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson($actualResponseContent);
        $this->assertJsonStringEqualsJsonString($expectedResponseContent, $actualResponseContent);
    }

    public function testUnsuccessfullDeleteCarFromId()
    {
        $this->client->request('DELETE', '/cars/5', [], [], ['CONTENT_TYPE' => 'application/json']);

        $response = $this->client->getResponse();
        $actualResponseContent = $response->getContent();
        $expectedResponseContent = '{"message":"The car does not exist."}';

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson($actualResponseContent);
        $this->assertJsonStringEqualsJsonString($expectedResponseContent, $actualResponseContent);
    }

    public function testSuccessfullCreateCar()
    {
        $requestPayload = [
            "make"=> "Audi",
            "model"=> "TT",
            "build_date"=> "2019-10-13",
            "colour"=> "red"
        ];
        $this->client->request('POST', '/cars', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestPayload));

        $response = $this->client->getResponse();
        $actualResponseContent = $response->getContent();
        $expectedContained = '"make":"Audi","model":"TT","build_date":"2019-10-13","colour":"red"';

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson($actualResponseContent);
        $this->assertStringContainsString($expectedContained, $actualResponseContent);
    }

    public function testUnsuccessfullCreateCar()
    {
        $requestPayload = [
            "make"=> "Audi",
            "model"=> "TT",
            "build_date"=> "2014-10-13",
            "colour"=> "yellow"
        ];
        $this->client->request('POST', '/cars', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestPayload));

        $response = $this->client->getResponse();
        $actualResponseContent = $response->getContent();
        $expectedResponseContent = '{
            "message": "Validation failed",
            "errors": [
                {
                    "parameter": "colour",
                    "message": "The value you selected is not a valid choice."
                },
                {
                    "parameter": "build_date",
                    "message": "The car\'s build date cannot be older than 4 years"
                }
            ]
        }';

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson($actualResponseContent);
        $this->assertJsonStringEqualsJsonString($expectedResponseContent, $actualResponseContent);
    }

    public function testListingOfColours()
    {
        $this->client->request('GET', '/colours', [], [], ['CONTENT_TYPE' => 'application/json']);

        $response = $this->client->getResponse();
        $actualResponseContent = $response->getContent();
        $expectedResponseContent = '[
            {
                "id": 1,
                "name": "red"
            },
            {
                "id": 2,
                "name": "blue"
            },
            {
                "id": 3,
                "name": "white"
            },
            {
                "id": 4,
                "name": "black"
            }
        ]';

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson($actualResponseContent);
        $this->assertJsonStringEqualsJsonString($expectedResponseContent, $actualResponseContent);
    }
}
