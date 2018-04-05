<?php 

namespace AppBundle\Http;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OmdbapiClient 
{
	const BASE_URL = 'http://www.omdbapi.com';
	const API_KEY = '2a784a2';

	const CACHE_KEY = 'Omdbapi.';

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct( SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->cache = $cache = new FilesystemCache();;
    }

    /**
     * @param int $idMovie
     *
     * @return array
     */
    public function getMoviesmetadata( $idMovie)
    {
    	if( !$this->cache->has(self::CACHE_KEY.'$idMovie')){

    		//here we should use http://docs.php-http.org/ interface , officialy supported by Symfony Flex
    		$url = self::BASE_URL."/?i=".$idMovie."&apikey=".self::API_KEY;
    		$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'www.someapi.com?param1=A&param2=B');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$response = curl_exec($ch);
			var_dump($url);
			$movieData = json_decode($response);

    		$this->cache->set(self::CACHE_KEY.'$idMovie', $movieData, 2592000); // cache of one month

    	}
    	throw new NotFoundHttpException(
                        'Movies not found',
                        $e
                    );
    	$movieData = $this->cache->get(self::CACHE_KEY.'$idMovie');

    	return $movieData;
    }
}