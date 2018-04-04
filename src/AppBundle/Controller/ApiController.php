<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request, SerializerInterface $serializer)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir'  =>  realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/user/create", name="user_create")
     * @Method({"POST"})
     */
    public function userCreateAction(Request $request, SerializerInterface $serializer)
    {
        $data = ['movie_id' => $movie_id ,'user_id' => $user_id];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
    }

    /**
     * @Route("/user/{user_id}/vote/{movie_id}",requirements={"user_id"="\d+","movie_id"="\d+"}, name="user_vote")
     * @Method({"POST"})
     */
    public function PostUserVoteAction(int $user_id,int $movie_id, SerializerInterface $serializer)
    {
        $data = ['movie_id' => $movie_id ,'user_id' => $user_id];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/user/{user_id}/vote/{movie_id}",requirements={"user_id"="\d+","movie_id"="\d+"}, name="user_retract")
     * @Method({"POST"})
     */
    public function DeleteUserVoteAction(int $user_id,int $movie_id, SerializerInterface $serializer)
    {
        $data = ['movie_id' => $movie_id ,'user_id' => $user_id];
        $data =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/user/{user_id}/votes/",requirements={"user_id"="\d+"}, name="user_votes")
     * @Method({"GET"})
     */
    public function GetUserVotesAction(int $user_id, SerializerInterface $serializer)
    {
        $data = ['$user_id'  =>  $user_id];
        $serializedData =  $this->get('serializer')->serialize($user_id, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/movies/{movie_id}/votes/",requirements={"movie_id"="\d+"}, name="film_votes")
     * @Method({"GET"})
     */
    public function GetFilmVotesAction(int $movie_id, SerializerInterface $serializer)
    {
        $data = ['$movie_id'  =>  $movie_id];
        $serializedData =  $this->get('serializer')->serialize($movie_id, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/movies/{movie_id}/rank/{order}",requirements={"movie_id"="\d+","order"="\d+"}, defaults={"order" = "asc"},name="film_votes" )
     * @Method({"GET"})
     */
    public function GetFilmRankAction(int $user_id, int $movie_id, SerializerInterface $serializer)
    {
        $data = ['movie_id' => $movie_id ,'user_id' => $user_id];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
