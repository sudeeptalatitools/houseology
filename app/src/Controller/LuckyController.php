<?php
/**
 * Created by PhpStorm.
 * User: sudeeptalati
 * Date: 28/02/2018
 * Time: 08:27
 */

// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LuckyController extends Controller
{

    /**
     * @Route("/lucky/number")
     */

    public function number()
    {
        $number = mt_rand(0, 100);
/*
        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
*/
        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));
    }
}