<?php
/**
 * Created by PhpStorm.
 * User: sudeeptalati
 * Date: 01/03/2018
 * Time: 13:41
 */


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoviesControllerRatingTest extends WebTestCase
{


    public function testRatingSearchHeader()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/rating');
        // asserts that the "Content-Type" header is "application/json"
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
        );
    }///end of public function testRatingSearchBadRequest()

    public function testRatingSearchBadRequest()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/rating');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }///end of public function testRatingSearchBadRequest()



    public function testRatingSearchNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/rating/10');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }///end of     public function testRatingSearchNotFound()



    public function testRatingSearchSuccessful()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/rating/5');
        // asserts that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
    }///end of     public function testRatingSearchOk()



    public function testRatingSearchJson()
    {

        $client = static::createClient();
        $client->request('GET', '/movies/rating/5');

        $expectedResponseString= '{"status":"OK","status_code":200,"message":"results found","result":{"total":3,"movies":[{"id":1,"name":"Movie A","date_released":{"date":"2018-02-27 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":5},{"id":3,"name":"Movie C","date_released":{"date":"2018-12-05 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":5},{"id":5,"name":"Movie E","date_released":{"date":"2018-02-09 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":5}]}}';
        $expectedResponseJson=json_decode($expectedResponseString,true);

        $responseDataString = $client->getResponse()->getContent();
        $responseDataJson = json_decode($responseDataString, true);

        $this->assertJson($responseDataString);
        $this->assertJsonStringEqualsJsonString($expectedResponseString,$responseDataString,'Json file not equal');
        $this->assertSame($expectedResponseString,$responseDataString);
        $this->assertSame($expectedResponseJson,$responseDataJson);


    }///end of     public function testRatingSearchJson()












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



    public function testSearchByRating(){

        $param=['rating'=>'5'];
        $client = static::createClient();
        $client->request('GET', '/movies',$param);

        //echo $client->getRequest();

        $response = $client->getResponse();

        echo $response;

    }///end of public function testSearchByRating(){
    */


}