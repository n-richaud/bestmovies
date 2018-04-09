<?php 

namespace AppBundle\Manager;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use AppBundle\Entity\User;
use AppBundle\Entity\Movie;


class MovieManager{

	/**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var EntityManager
     */
    protected $omdbapiClient;

    public function __construct( $entityManager,$omdbapiClient){

    	$this->entityManager = $entityManager;
        $this->omdbapiClient = $omdbapiClient;
    }

    public function CheckMovies($movie_id){
        var_dump($movie_id);
        if (is_int($movie_id)) { // is internal id 
            return $movie_id;
        }
        else{ // maybe id is imdb id 
            $movie = $this->entityManager->getRepository('AppBundle:Movie')->findOneByIdIMDB($movie_id); 
            if ($movie == null) {
                $moviesImdb = $this->omdbapiClient->getMoviesMetadata($movie_id);
                $movie = new Movie ;
                $movie->setIdIMDB($movie_id);
                $movie->setName($moviesImdb['Title']);
                $movie->setPoster($moviesImdb['Poster']);
                $this->entityManager->persist($movie);
                $this->entityManager->flush();

                return $movie->getId();
            }

        }

    }

    public function getUserVotedFor($movie_id){
    	$movie = $this->entityManager->getRepository('AppBundle:Movie')->findOneById($movie_id);

    	if ($movie == null) {
        	throw new \Exception('movie note in database');
        }
        $usersVotedFor = $movie->getUsers()->toArray();
        $arrayusersVotedFor = [];
        foreach ($usersVotedFor as $key => $user) {
        	$arrayusersVotedFor[] = $user->getId();
        }

        return $arrayusersVotedFor;
    }
}