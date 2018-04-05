<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use AppBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception;
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
        $content = $request->getContent();
        $content_decoded = json_decode($content,true) ;

        $payload = $content_decoded['payload'] ;
        $email = $payload['email'];
        $birthDate = $payload['birthDate'];
        $entityManager = $this->getDoctrine()->getManager();
        $userWithEmail = $entityManager->getRepository('AppBundle:User')->findByEmail($email);
        if (count($userWithEmail)>=1) {
            throw new \Exception('Already an user with this email');
        }
        $birthDateConverted = \DateTime::createFromFormat('d/m/Y', $birthDate);
        
        $user = new User;
        $user->setLogin($payload['login']);
        $user->setEmail($email);
        $user->setBirthDate($birthDateConverted);
        $entityManager->persist($user);
        $entityManager->flush();
        $data = $payload;
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/user/{user_id}/vote/{movie_id}",requirements={"user_id"="\d+"}, name="user_vote")
     * @Method({"POST"})
     */
    public function PostUserVoteAction($user_id, $movie_id, SerializerInterface $serializer)
    {
        //$data = ['movie_id' => $movie_id ,'user_id' => $user_id];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/user/{user_id}/vote/{movie_id}",requirements={"user_id"="\d+"}, name="user_retract")
     * @Method({"POST"})
     */
    public function DeleteUserVoteAction($user_id, $movie_id, SerializerInterface $serializer)
    {
        $data = ['movie_id' => $movie_id ,'user_id' => $user_id];
        //$data =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/user/{user_id}/votes/",requirements={"user_id"="\d+"}, name="user_votes")
     * @Method({"GET"})
     */
    public function GetUserVotesAction($user_id, SerializerInterface $serializer)
    {
        $data = ['$user_id'  =>  $user_id];
        $serializedData =  $this->get('serializer')->serialize($user_id, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/movies/{movie_id}/votes/", name="film_votes")
     * @Method({"GET"})
     */
    public function GetFilmVotesAction($movie_id, SerializerInterface $serializer)
    {
        $data = ['$movie_id'  =>  $movie_id];
        $serializedData =  $this->get('serializer')->serialize($movie_id, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/movies/{movie_id}/rank/{order}",requirements={"order"="\d+"}, defaults={"order" = "ASC"},name="film_votes" )
     * @Method({"GET"})
     */
    public function GetFilmRankAction($user_id, $movie_id, SerializerInterface $serializer)
    {
        $data = ['movie_id' => $movie_id ,'user_id' => $user_id];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

     /**
     * @Route("/debug",name="debug" )
     * @Method({"GET"})
     */
    public function DebugAction( SerializerInterface $serializer)
    {
        $OmdbapiClient = $this->get("client.Omdbapi");
        $data = $OmdbapiClient->getMoviesmetadata('tt0371724');
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
