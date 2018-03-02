<?php
/**
 * Created by PhpStorm.
 * User: sudeeptalati
 * Date: 02/03/2018
 * Time: 09:11
 */
namespace App\Tests\Repository;

use App\Entity\Movies;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;



class MoviesRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByGenre()
    {
        $movies = $this->entityManager
            ->getRepository(Movies::class)
            ->searchAllBy(false, 'action', false, true);
        $this->assertCount(5, $movies);
    }


    public function testSearchByRating()
    {
        $movies = $this->entityManager
            ->getRepository(Movies::class)
            ->searchAllBy(false, false, '5', true);
        $this->assertCount(3, $movies);
    }


    public function testSearchByDateReleased()
    {
        $date_released=date('Y-m-d H:i:s', strtotime('27-Feb-2018'));

        $movies = $this->entityManager
            ->getRepository(Movies::class)
            ->searchAllBy($date_released, false,false, true);

        $this->assertCount(1, $movies);
    }

    public function testGetterAndSetter() {

        $movie = new Movies();

        $this->assertNull($movie->getId());

        $name='Movie A';
        $movie->setName($name);
        $this->assertSame($name, $movie->getName());

        $genre='Action';
        $movie->setGenre($genre);
        $this->assertSame($genre, $movie->getGenre());

        $rating='5';
        $movie->setRating($rating);
        $this->assertSame($rating, $movie->getRating());


        $date_string='28-Feb-2018';
        $date_released=date('Y-m-d H:i:s', strtotime($date_string));
        $date_object=\DateTime::createFromFormat('U', strtotime($date_string));

        $movie->setDateReleased($date_released);
        $this->assertEquals($date_object, $movie->getDateReleased());


    }



    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}