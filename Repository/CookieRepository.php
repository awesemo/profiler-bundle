<?php

namespace Movent\ProfilerBundle\Repository;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use Movent\ProfilerBundle\Model\ProfileInterface;
use Movent\ProfilerBundle\Repository\RepositoryInterface;

class CookieRepository implements RepositoryInterface
{
	const COOKIE_NAME = "profiler-cloud";
	
	protected $requestStack;
	protected $session;
	protected $serializer;
	protected $data;
	
	public function __construct(RequestStack $requestStack, Session $session)
	{
		$this->requestStack = $requestStack;
		$this->session      = $session;
		$encoders           = array(new JsonEncoder());
		$normalizers        = array(new GetSetMethodNormalizer());
		$this->serializer   = new Serializer($normalizers, $encoders);
	}
	
	public function setClass($class)
	{
		$this->class = $class;
		return $this;
	}
	
	public function getClass()
	{
		return $this->class;
	}
	
	public function getData()
	{
		$cookieName = sprintf("%s-%s", $this->session->getName(), self::COOKIE_NAME);
		$this->data = new $this->class(); 
		if (($cookie = $this->requestStack->getCurrentRequest()->cookies->get($cookieName))) {
			try {
				$this->data = $this->serializer->deserialize($cookie,$this->getClass(),'json');
				return $this->data;
			} catch(Exception $e) {
				;
			}
		}
		return $this->data;
	}
	
	public function getCookieName()
	{
		$cookieName = sprintf("%s-%s", $this->session->getName(), self::COOKIE_NAME);
		return $cookieName;
	}
	
	public function getCookieLifetime()
	{
		return (time() + 3600 * 24 * 7);
	}
	
    public function save()
    {
		$data = $this->serializer->serialize($this->data, 'json');
		
		$cookie = new Cookie($this->getCookieName(), $data, $this->getCookieLifetime());
		$response = new Response();
		$response->headers->setCookie($cookie);
		$response->send();
	}
}
