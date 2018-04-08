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
    public function indexAction(Request $request, SerializerInterface $serializer){
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir'  =>  realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/user", name="user_create")
     * @Method({"POST"})
     */
    public function userCreateAction(Request $request, SerializerInterface $serializer){

        $content = $request->getContent();
        $content_decoded = json_decode($content,true) ;
        $payload = $content_decoded['payload'] ;

        try{
            $user_id = $this->get('manager.user')->createUser($payload);
        } 
        catch(\Exception $e){
            $data = ['Response'=>'false','error'=>$e->getMessage()];
            $serializedData =  $this->get('serializer')->serialize($data, 'json');
            $response = new Response($serializedData);
            $response->setStatusCode(500);
            $response->headers->set('Content-Type', 'application/problem+json'); // https://datatracker.ietf.org/doc/rfc7807/
            return $response; 
        }
        
        $data = ['success'=>'user created !' , 'payload' => ['user_id'=>$user_id]];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/user/{user_id}/vote/{movie_id}",requirements={"user_id"="\d+"}, name="user_vote")
     * @Method({"POST"})
     */
    public function PostUserVoteAction($user_id, $movie_id, SerializerInterface $serializer){

        try{
            $this->get('manager.user')->addVote($user_id,$movie_id);
        } 
        catch(\Exception $e){
            $data = ['Response'=>'false','error'=>$e->getMessage()];
            $serializedData =  $this->get('serializer')->serialize($data, 'json');
            $response = new Response($serializedData);
            $response->setStatusCode(500);
            $response->headers->set('Content-Type', 'application/problem+json'); // https://datatracker.ietf.org/doc/rfc7807/
            return $response; 
        }
       

        $data = ['success'=>'vote added !' , 'payload' => ['user_id'=>$user_id,'movies_id'=>$movie_id] ];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/user/{user_id}/vote/{movie_id}",requirements={"user_id"="\d+"}, name="user_retract")
     * @Method({"DELETE"})
     */
    public function DeleteUserVoteAction($user_id, $movie_id, SerializerInterface $serializer){
        
        try{
            $this->get('manager.user')->deleteVote($user_id,$movie_id);
        } 
        catch(\Exception $e){
            $data = ['Response'=>'false','error'=>$e->getMessage()];
            $serializedData =  $this->get('serializer')->serialize($data, 'json');
            $response = new Response($serializedData);
            $response->setStatusCode(500);
            $response->headers->set('Content-Type', 'application/problem+json'); // https://datatracker.ietf.org/doc/rfc7807/
            return $response; 
        }
       

        $data = ['success'=>'vote deleted !' , 'payload' => ['user_id'=>$user_id] ,'movies_id'=>$movie_id];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/user/{user_id}/votes/",requirements={"user_id"="\d+"}, name="user_votes")
     * @Method({"GET"})
     */
    public function GetUserVotesAction($user_id, SerializerInterface $serializer){

        try{
           $moviesChoosen = $this->get('manager.user')->getUserVotes($user_id);
        } 
        catch(\Exception $e){
            $data = ['Response'=>'false','error'=>$e->getMessage()];
            $serializedData =  $this->get('serializer')->serialize($data, 'json');
            $response = new Response($serializedData);
            $response->setStatusCode(500);
            $response->headers->set('Content-Type', 'application/problem+json'); // https://datatracker.ietf.org/doc/rfc7807/
            return $response; 
        }
       

        $data = ['success'=>'votes for $user_id ' , 'payload' => ['user_id'=>$user_id] ,'movies Choosen'=>$moviesChoosen];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
        
    }

    /**
     * @Route("/movie/{movie_id}/votes/", name="film_votes")
     * @Method({"GET"})
     */
    public function GetFilmVotesAction($movie_id, SerializerInterface $serializer){
        
        try{
           $usersVotedFor = $this->get('manager.movie')->getUserVotedFor($movie_id);
        } 
        catch(\Exception $e){
            $data = ['Response'=>'false','error'=>$e->getMessage()];
            $serializedData =  $this->get('serializer')->serialize($data, 'json');
            $response = new Response($serializedData);
            $response->setStatusCode(500);
            $response->headers->set('Content-Type', 'application/problem+json'); // https://datatracker.ietf.org/doc/rfc7807/
            return $response; 
        }
       

        $data = ['success'=>'votes for $movie_id ' , 'payload' => ['movie_id'=>$movie_id] ,'user'=>$usersVotedFor];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/movies/best",name="best_film" )
     * @Method({"GET"})
     */
    public function GetFilmRankAction(SerializerInterface $serializer){

        $entityManager = $this->getDoctrine()->getManager();
        $bestMovie = $entityManager->getRepository('AppBundle:Movie')->getMovieBest();
        $data = ['movie_id' => $bestMovie ];
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

     /**
     * @Route("/debug",name="debug" )
     * @Method({"GET"})
     */
    public function DebugAction( SerializerInterface $serializer){
        $OmdbapiClient = $this->get("client.Omdbapi");
        $data = $OmdbapiClient->getMoviesMetadata('tt0371724');
        $serializedData =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($serializedData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
