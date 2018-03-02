<?php

namespace App\Controller;

use App\Entity\Movies;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;


class MoviesController extends Controller
{

    public function generateResponse($statusCode=404,$status='NOT_FOUND',$message='Not Found', $data=null)
    {
        $response = new Response();
        $response->setStatusCode($statusCode);
        $response->setContent(json_encode(array(
            'status' => $status,
            'status_code' => $statusCode,
            'message'=>$message,
            'result' => $data,
        )));


        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @param $rating
     * @Route("/movies/rating/{rating}", name="movies_rating")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function searchByRating($rating=null)
    {
        if (!$rating)
            return $this->generateResponse(400, 'BAD_REQUEST', 'This is a bad rating request');

        $movies = $this->getDoctrine()
            ->getRepository(Movies::class)
            ->searchAllBy(false, false, $rating, true);

        if (count($movies) == 0)
            return $this->generateResponse(404,'NOT_FOUND', 'No results found');
        else
            return $this->generateResponse(200,'OK', 'results found', ['total'=>count($movies),'movies'=>$movies]);
    }///end of public function searchByRating($rating)




    /**
     * @param $genre
     * @Route("/movies/genre/{genre}", name="movies_genre")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function searchByGenre($genre=null)
    {
        if (!$genre)
            return $this->generateResponse(400, 'BAD_REQUEST', 'This is a bad genre request');

        $movies = $this->getDoctrine()
            ->getRepository(Movies::class)
            ->searchAllBy(false, $genre, false, true);

        if (count($movies) == 0)
            return $this->generateResponse(404,'NOT_FOUND', 'No results found');
        else
            return $this->generateResponse(200,'OK', 'results found', ['total'=>count($movies),'movies'=>$movies]);
    }///end of public function searchByRating($genre)





    /**
     * @param $genre
     * @Route("/movies/date_release/{date_release}", name="movies_date_release")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function searchByDateRelease($date_release=null)
    {
        if (!$date_release)
            return $this->generateResponse(400, 'BAD_REQUEST', 'This is a bad date_release request');

        ///converting to Mysql date format
        $date_release=date('Y-m-d H:i:s', strtotime($date_release));


        $movies = $this->getDoctrine()
            ->getRepository(Movies::class)
            ->searchAllBy($date_release,false,  false, true);

        if (count($movies) == 0)
            return $this->generateResponse(404,'NOT_FOUND', 'No results found');
        else
            return $this->generateResponse(200,'OK', 'results found', ['total'=>count($movies),'movies'=>$movies]);
    }///end of public function searchByRating($genre)










    //////If you want to search by passing parameters then use the following url
    /// For Example

    /**
     * @Route("/movies", name="movies")
     */
    public function index()
    {

        $output_array = [];
        $request_array['status'] = 'OK';

        $request = Request::createFromGlobals();


        $date_released = $request->query->get('date_released');
        $genre = $request->query->get('genre');
        $rating = $request->query->get('rating');

        if (!$date_released && !$genre && !$rating)
           return $this->generateResponse('400', 'BAD_REQUEST', 'This is a bad request');



        if ($date_released) {
            $request_array['date_released'] = $date_released;
            ///converting to Mysql date format
            $date_released=date('Y-m-d H:i:s', strtotime($date_released));


            $movies = $this->getDoctrine()
                ->getRepository(Movies::class)
                ->searchAllBy($date_released, false, false, true);
            $output_array['movies'] = $movies;
        }//end of if ($date_released)


        if ($genre) {
            $request_array['genre'] = $genre;
            $movies = $this->getDoctrine()
                ->getRepository(Movies::class)
                ->searchAllBy(false, $genre, false, true);
            $output_array['movies'] = $movies;

        }///end of  if ($genre)

        if ($rating) {
            $request_array['rating'] = $rating;
            $movies = $this->getDoctrine()
                ->getRepository(Movies::class)
                ->searchAllBy(false, false, $rating, true);
            //->findAllByRating( $rating, true);

            $output_array['movies'] = $movies;
        }///end of if ($rating){

        if (count($movies) == 0)
            return $this->generateResponse(404,'NOT_FOUND', 'No results found');
            else

            return $this->generateResponse(200,'OK', 'results found', ['total'=>count($output_array['movies'] ),'movies'=>$output_array['movies'] ]);


    }


    /**
     * @Route("/movies/populate", name="product_populate")
     */
    public function populate()
    {


        $saved_movies_array = array();

        $movie = $this->saveMovie('Movie A', '2018-02-27 00:00:00', 'Action', '5');
        array_push($saved_movies_array, $movie->getName());

        $movie = $this->saveMovie('Movie B', '2018-05-27 00:00:00', 'Action', '4');
        array_push($saved_movies_array, $movie->getName());

        $movie = $this->saveMovie('Movie C', '2018-12-05 00:00:00', 'Action', '5');
        array_push($saved_movies_array, $movie->getName());

        $movie = $this->saveMovie('Movie D', '2018-06-15 00:00:00', 'Action', '3');
        array_push($saved_movies_array, $movie->getName());

        $movie = $this->saveMovie('Movie E', '2018-02-09 00:00:00', 'Action', '5');
        array_push($saved_movies_array, $movie->getName());


        $response = new Response();
        $response->setContent(json_encode(array(
            'data' => $saved_movies_array,
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }////END OOF public function populate()


    protected function saveMovie($name, $date_released, $genre, $rating)
    {

        $em = $this->getDoctrine()->getManager();
        $product = new Movies();
        $product->setName($name);
        $product->setDateReleased($date_released);
        $product->setGenre($genre);
        $product->setRating($rating);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);
        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        return $product;
    }


}
