<?php
/**
 * Created by PhpStorm.
 * User: sudeeptalati
 * Date: 01/03/2018
 * Time: 13:41
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoviesControllerTest extends WebTestCase
{
    public $testSystemUrl='http://127.0.0.1/houseology/symfony/my-project/public/';

    public function testMoviesSearchHeader()
    {
        $url=$this->testSystemUrl.'movies?genre=action';
        $curl=$this->curl($url,true);
        $this->assertContains('application/json', $curl['output'], 'the "Content-Type" header is "application/json');
    }///end of public function testRatingSearchBadRequest()


    public function testMoviesSearchBadRequest()
    {
        $url=$this->testSystemUrl.'movies';
        $curl=$this->curl($url,true);
        $this->assertEquals(400, $curl['httpcode']);
    }///end of public function testRatingSearchBadRequest()



    public function testMoviesSearchNotFound()
    {
        $url=$this->testSystemUrl.'movies?date_released=28-feb-2018';
        $curl=$this->curl($url);
        $this->assertEquals(404, $curl['httpcode']);
    }///end of     public function testRatingSearchNotFound()



    public function testMoviesSearchSuccessful()
    {
        $url=$this->testSystemUrl.'movies?rating=5';
        $curl=$this->curl($url);
        $this->assertEquals(200, $curl['httpcode']);
    }///end of     public function testRatingSearchOk()




    public function testRatingSearchJson()
    {

        $url=$this->testSystemUrl.'movies?rating=5';
        $curl=$this->curl($url);

        //echo $curl['output'];

        $expectedResponseString= '{"status":"OK","status_code":200,"message":"results found","result":{"total":3,"movies":[{"id":1,"name":"Movie A","date_released":{"date":"2018-02-27 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":5},{"id":3,"name":"Movie C","date_released":{"date":"2018-12-05 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":5},{"id":5,"name":"Movie E","date_released":{"date":"2018-02-09 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"genre":"Action","rating":5}]}}';
        $expectedResponseJson=json_decode($expectedResponseString,true);

        $responseDataString = $curl['output'];
        $responseDataJson = json_decode($responseDataString, true);


        $this->assertJson($responseDataString);
        $this->assertJsonStringEqualsJsonString($expectedResponseString,$responseDataString,'Json file not equal');
        $this->assertSame($expectedResponseString,$responseDataString);
        $this->assertSame($expectedResponseJson,$responseDataJson);





    }///end of     public function testRatingSearchJson()





    public function curl($url, $header=false)
    {
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($header)
            curl_setopt($ch, CURLOPT_HEADER, true);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // close curl resource to free up system resources
        curl_close($ch);

        return ['httpcode'=>$httpcode, 'output'=>$output];
    }///end of public function curl($url)














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

    */



}