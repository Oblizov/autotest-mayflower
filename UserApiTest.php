<?php

require('vendor/autoload.php');

class UserApiTest extends \PHPUnit\Framework\TestCase
{

    private $client;
    private $faker;
    private $username;
    private $email;
    private $password;


    // POST /user/create
    function postUser()
    {
        $response = $this->client->post('/user/create', [
            'json'=>[
                "username" => $this->username,
                "password" => $this->password,
                "email" => $this->email
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $responseData = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('success', $responseData);
        $this->assertArrayHasKey('details', $responseData);
        $this->assertArrayHasKey('message', $responseData);

        $this->assertArrayHasKey('username', $responseData['details']);
        $this->assertArrayHasKey('email', $responseData['details']);
        $this->assertArrayHasKey('password', $responseData['details']);
        $this->assertArrayHasKey('created_at', $responseData['details']);
        $this->assertArrayHasKey('updated_at', $responseData['details']);
        $this->assertArrayHasKey('id', $responseData['details']);

        $this->assertEquals(true, $responseData['success']);
        $this->assertEquals('User Successully created', $responseData['message']);

        $this->assertEquals($this->username, $responseData['details']['username']);
        $this->assertEquals($this->email, $responseData['details']['email']);

        return $responseData;
    }

    // GET /user/get?{queryField}={$queryParam}
    function getUser($queryField, $postResponseData)
    {
        $response = $this->client->get('/user/get', [
            'query' => [
                $queryField => $postResponseData['details'][$queryField]
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $responseData = json_decode($response->getBody(), true);

        $this->assertEquals($postResponseData['details']['id'], $responseData[0]['id']);
        $this->assertEquals($postResponseData['details']['username'], $responseData[0]['username']);
        $this->assertEquals($postResponseData['details']['email'], $responseData[0]['email']);
        $this->assertEquals($postResponseData['details']['password'], $responseData[0]['password']);
        $this->assertEquals($postResponseData['details']['created_at'], $responseData[0]['created_at']);
        $this->assertEquals($postResponseData['details']['updated_at'], $responseData[0]['updated_at']);
    }

    // GET /user/get
    function getAllUsers($postResponseData)
    {
        $response = $this->client->get('/user/get', []);

        $this->assertEquals(200, $response->getStatusCode());

        $responseData = json_decode($response->getBody(), true);

        $numberUsers = count($responseData);

        $this->assertEquals($postResponseData['details']['username'], $responseData[$numberUsers - 1]['username']);
        $this->assertEquals($postResponseData['details']['id'], $responseData[$numberUsers - 1]['id']);
        $this->assertEquals($postResponseData['details']['email'], $responseData[$numberUsers - 1]['email']);
        $this->assertEquals($postResponseData['details']['password'], $responseData[$numberUsers - 1]['password']);
        $this->assertEquals($postResponseData['details']['created_at'], $responseData[$numberUsers - 1]['created_at']);
        $this->assertEquals($postResponseData['details']['updated_at'], $responseData[$numberUsers - 1]['updated_at']);

    }

    protected function setUp(): void {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://3.145.97.83:3333'
        ]);

        $this->faker=\Faker\Factory::create();
        $this->username =  $this->faker->userName();
        $this->email = $this->faker->safeEmail();
        $this->password = $this->faker->password();
    }

    public function testPostAndGetUserById() {

        $postResponseData = $this->postUser();

        $this->getUser('id', $postResponseData);

    }

    public function testPostAndGetUserByUsername() {

        $postResponseData = $this->postUser();

        $this->getUser('username', $postResponseData);

    }
    public function testPostAndGetUserByEmail() {

        $postResponseData = $this->postUser();

        $this->getUser('email', $postResponseData);

    }

    public function testPostAndCheckLastUser() {

        $postResponseData1 = $this->postUser();

        $this->getAllUsers($postResponseData1);

    }

}