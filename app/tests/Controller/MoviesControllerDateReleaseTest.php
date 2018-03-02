<?php
/**
 * Created by PhpStorm.
 * User: sudeeptalati
 * Date: 01/03/2018
 * Time: 13:41
 */


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoviesControllerDateReleaseTest extends WebTestCase
{


    public function testDateReleaseSearchHeader()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/date_release');
        // asserts that the "Content-Type" header is "application/json"
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
        );
    }///end of public function testDateReleaseSearchBadRequest()

    public function testDateReleaseSearchBadRequest()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/date_release');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }///end of public function testDateReleaseSearchBadRequest()



    public function testDateReleaseSearchNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/date_release/10');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }///end of     public function testDateReleaseSearchNotFound()



    public function testDateReleaseSearchSuccessful()
    {
        $client = static::createClient();
        $client->request('GET', '/movies/date_release/27-Feb-2018');
        // asserts that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
    }///end of     public function testDateReleaseSearchOk()



    public function testDateReleaseSearchJson()
    {

        $client = static::createClient();
        $client->request('GET', '/movies/date_release/27-Feb-2018');

        $expectedResponseString= '{"status":"OK","status_code":200,"message":"results found","result":{"total":1,"movies":[{"id":1,"name":"Movie A","date_released":{"date":"2018-02-27 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":5}]}}';

        $expectedResponseJson=json_decode($expectedResponseString,true);

        $responseDataString = $client->getResponse()->getContent();
        //echo $responseDataString;
        $responseDataJson = json_decode($responseDataString, true);

        $this->assertJson($responseDataString);
        $this->assertJsonStringEqualsJsonString($expectedResponseString,$responseDataString,'Json file not equal');
        $this->assertSame($expectedResponseString,$responseDataString);
        $this->assertSame($expectedResponseJson,$responseDataJson);


    }///end of     public function testDateReleaseSearchJson()












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



    public function testSearchByDateRelease(){

        $param=['date_release'=>'5'];
        $client = static::createClient();
        $client->request('GET', '/movies',$param);

        //echo $client->getRequest();

        $response = $client->getResponse();

        echo $response;

    }///end of public function testSearchByDateRelease(){
    */


}