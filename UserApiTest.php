<?php

require('vendor/autoload.php');

class UserApiTest extends \PHPUnit\Framework\TestCase
{

    private $client;
    private $faker;
    private $username;
    private $email;
    private $password;


    protected function setUp(): void {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://3.145.97.83:3333'
        ]);

        $this->faker=\Faker\Factory::create();
        $this->username =  $this->faker->userName();
        $this->email = $this->faker->safeEmail();
        $this->password = $this->faker->password();
    }


    public function testCreateUser() {

        $response = $this->client->post('/user/create', [
            'json'=>[
                "username" => $this->username,
                "password" => $this->password,
                "email" => $this->email
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);



        $this->assertArrayHasKey('success', $data);
        $this->assertArrayHasKey('details', $data);
        $this->assertArrayHasKey('message', $data);

        $this->assertArrayHasKey('username', $data['details']);
        $this->assertArrayHasKey('email', $data['details']);
        $this->assertArrayHasKey('password', $data['details']);
        $this->assertArrayHasKey('created_at', $data['details']);
        $this->assertArrayHasKey('updated_at', $data['details']);
        $this->assertArrayHasKey('id', $data['details']);

        $this->assertEquals(true, $data['success']);
        $this->assertEquals('User Successully created', $data['message']);

        $this->assertEquals($this->username, $data['details']['username']);
        $this->assertEquals($this->email, $data['details']['email']);

    }

    public function testGetAllUsers() {
        $response = $this->client->get('/user/get', []);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);


        $this->assertEquals('test', $data[0]['username']);
        $this->assertEquals(1, $data[0]['id']);
        $this->assertEquals('test@test.com', $data[0]['email']);
        $this->assertEquals('$2a$10$5hEv.bjy6wM.OfXZaWuvTexAg9cUTWQc1HQeIeB.WnRE8Mt8FD0vC', $data[0]['password']);
        $this->assertEquals('2022-10-13 11:57:35', $data[0]['created_at']);
        $this->assertEquals('2022-10-13 11:57:35', $data[0]['updated_at']);

        $this->assertEquals('user3', $data[3]['username']);
        $this->assertEquals(4, $data[3]['id']);
        $this->assertEquals('user3@email.com', $data[3]['email']);
        $this->assertEquals('$2a$10$ZzmvIm15luScyqPrGwpw6.Pqm5PkUEflU3/JR1BSwUBUkipedh3mu', $data[3]['password']);
        $this->assertEquals('2022-10-16 16:42:26', $data[3]['created_at']);
        $this->assertEquals('2022-10-16 16:42:26', $data[3]['updated_at']);

    }

    public function testGetUserById() {
        $response = $this->client->get('/user/get', [
            'query' => [
                'id' => 21474836707
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);


        $this->assertArrayHasKey('username', $data[0]);
        $this->assertArrayHasKey('email', $data[0]);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('password', $data[0]);
        $this->assertArrayHasKey('created_at', $data[0]);
        $this->assertArrayHasKey('updated_at', $data[0]);

        $this->assertEquals(21474836707, $data[0]['id']);
        $this->assertEquals('alittle', $data[0]['username']);
        $this->assertEquals('dax.emard@example.org', $data[0]['email']);
        $this->assertEquals('$2a$10$oAdpo4A87WpDMOMdwJHYFuQi.rcP1wRryB1D2WH4Nuk3ZjLYYNeUK', $data[0]['password']);
        $this->assertEquals('2023-03-19 13:36:43', $data[0]['created_at']);
        $this->assertEquals('2023-03-19 13:36:43', $data[0]['updated_at']);

    }

    public function testGetUserByUsername() {
        $response = $this->client->get('/user/get', [
            'query' => [
                'username' => 'haley.tyreek'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);


        $this->assertArrayHasKey('username', $data[0]);
        $this->assertArrayHasKey('email', $data[0]);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('password', $data[0]);
        $this->assertArrayHasKey('created_at', $data[0]);
        $this->assertArrayHasKey('updated_at', $data[0]);

        $this->assertEquals(21474836724, $data[0]['id']);
        $this->assertEquals('haley.tyreek', $data[0]['username']);
        $this->assertEquals('epouros@example.net', $data[0]['email']);
        $this->assertEquals('$2a$10$hzKvdBUDyiHDhEMXmrwZMuNjKeYpS/7UsP.y1/IHTO0Sc/5UWP.7q', $data[0]['password']);
        $this->assertEquals('2023-03-19 14:04:54', $data[0]['created_at']);
        $this->assertEquals('2023-03-19 14:04:54', $data[0]['updated_at']);
    }

    public function testGetUserByEmail() {
        $response = $this->client->get('/user/get', [
            'query' => [
                'email' => 'test4111@mail.com'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);


        $this->assertArrayHasKey('username', $data[0]);
        $this->assertArrayHasKey('email', $data[0]);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('password', $data[0]);
        $this->assertArrayHasKey('created_at', $data[0]);
        $this->assertArrayHasKey('updated_at', $data[0]);

        $this->assertEquals(21474836698, $data[0]['id']);
        $this->assertEquals('te444553st-180323-2', $data[0]['username']);
        $this->assertEquals('test4111@mail.com', $data[0]['email']);
        $this->assertEquals('$2a$10$yx2/4y/aXwPcUTNIuF5DA.P9BE4nMas1pdcCDWP1LHtx1RgFRRGQy', $data[0]['password']);
        $this->assertEquals('2023-03-19 12:39:57', $data[0]['created_at']);
        $this->assertEquals('2023-03-19 12:39:57', $data[0]['updated_at']);
    }
}