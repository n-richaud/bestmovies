<?php 

namespace AppBundle\Manager;
use AppBundle\Entity\User;
use AppBundle\Entity\Movie;
class UserManager
{
	 /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var EntityManager
     */
    protected $movieManager;

    public function __construct( $entityManager, $movieManager){

    	$this->entityManager = $entityManager;
        $this->movieManager = $movieManager;

    }

	public function addVote($user_id,$movie_id){

		
        $user = $this->entityManager->getRepository('AppBundle:User')->findOneById($user_id);
        if ($user == null) {
        	throw new \Exception('User doesn\'t exist');
        }
        if (count($user->getVotes())>=3) {
        	throw new \Exception('User can\'t add more vote');
        }

        $movie_id =  $this->movieManager->CheckMovies($movie_id);
        
        $movie = $this->entityManager->getReference("AppBundle\Entity\Movie", $movie_id);
        $user->addVote($movie);

        
        $this->entityManager->flush();


	}

	public function deleteVote($user_id,$movie_id){

		$user = $this->entityManager->getRepository('AppBundle:User')->findOneById($user_id);
        if ($user == null) {
        	throw new \Exception('User doesn\'t exist');
        }
        $movie = $this->entityManager->getReference("AppBundle\Entity\Movie", $movie_id);
        $user->removeVote($movie);
       
        $this->entityManager->flush();


	}

	public function createUser(array $payload){

		$email = $payload['email'];
        $birthDate = $payload['birthDate'];
        $userWithEmail = $this->entityManager->getRepository('AppBundle:User')->findByEmail($email);
        if (count($userWithEmail)>=1) {
            throw new \Exception('Already an user with this email');
        }
        $birthDateConverted = \DateTime::createFromFormat('d/m/Y', $birthDate);
        
        $user = new User;
        $user->setLogin($payload['login']);
        $user->setEmail($email);
        $user->setBirthDate($birthDateConverted);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user->getId();
	}

	public function getUserVotes($user_id){
		$user = $this->entityManager->getRepository('AppBundle:User')->findOneById($user_id);

        if ($user == null) {
        	throw new \Exception('User doesn\'t exist');
        }
        $moviesChoosen = $user->getVotes()->toArray();
        $arrayMoviesChoosen = [];
        foreach ($moviesChoosen as $key => $movie) {
        	$arrayMoviesChoosen[] = $movie->getId();
        }


        return $arrayMoviesChoosen;
	}

	public function findUserByChoices(){

	}


}