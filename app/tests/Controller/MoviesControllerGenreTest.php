<?php
/**
 * Created by PhpStorm.
 * User: sudeeptalati
 * Date: 01/03/2018
 * Time: 13:41
 */


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoviesControllergenreTest extends WebTestCase
{


    public function testGenreSearchHeader()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/genre');
        // asserts that the "Content-Type" header is "application/json"
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
        );
    }///end of public function testgenreSearchBadRequest()

    public function testGenreSearchBadRequest()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/genre');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }///end of public function testgenreSearchBadRequest()



    public function testGenreSearchNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/genre/10');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }///end of     public function testgenreSearchNotFound()



    public function testGenreSearchSuccessful()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/genre/action');
        // asserts that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
    }///end of     public function testgenreSearchOk()



    public function testGenreSearchJson()
    {

        $client = static::createClient();
        $client->request('GET', '/movies/genre/action');

        $expectedResponseString= '{"status":"OK","status_code":200,"message":"results found","result":{"total":5,"movies":[{"id":1,"name":"Movie A","date_released":{"date":"2018-02-27 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":5},{"id":2,"name":"Movie B","date_released":{"date":"2018-05-27 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":4},{"id":3,"name":"Movie C","date_released":{"date":"2018-12-05 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":5},{"id":4,"name":"Movie D","date_released":{"date":"2018-06-15 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":3},{"id":5,"name":"Movie E","date_released":{"date":"2018-02-09 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":5}]}}';
        $expectedResponseJson=json_decode($expectedResponseString,true);

        $responseDataString = $client->getResponse()->getContent();
        $responseDataJson = json_decode($responseDataString, true);

        //echo $client->getResponse()->getContent();

        $this->assertJson($responseDataString);
        $this->assertJsonStringEqualsJsonString($expectedResponseString,$responseDataString,'Json file not equal');
        $this->assertSame($expectedResponseString,$responseDataString);
        $this->assertSame($expectedResponseJson,$responseDataJson);


    }///end of     public function testgenreSearchJson()












    /*
    public function testJson()
    {

        $expectedResponseString='{"status":"ZERO_RESULTS","request":{"status":"OK"},"result":[]}';
        $expectedResponseJson=json_decode($expectedResponseString,true);

        $client = static::createClient();
        $client->request('GET', '/movies');
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        // asserts that the "Content-Type" header is "application/json"
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
        );

        // asserts that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');


        $responseDataString = $response->getContent();
        $responseDataJson = json_decode($response->getContent(), true);

        $this->assertSame($expectedResponseString,$responseDataString);
        $this->assertSame($expectedResponseJson,$responseDataJson);

        //echo $response->getContent();
    }//end of public function testJson()



    public function testSearchBygenre(){

        $param=['genre'=>'5'];
        $client = static::createClient();
        $client->request('GET', '/movies',$param);

        //echo $client->getRequest();

        $response = $client->getResponse();

        echo $response;

    }///end of public function testSearchBygenre(){
    */


}