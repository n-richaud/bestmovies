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

    public function __construct( $entityManager){

    	$this->entityManager = $entityManager;
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