<?php

namespace Movent\ProfilerBundle\Model;

use Symfony\Component\Security\Core\Util\SecureRandom;

class DefaultProfile implements ProfileInterface
{
	/**
	 * @var string
	 */
	protected $id;
	protected $hasEmail;
	protected $categories;
	
	public function __construct()
	{
		$generator = new SecureRandom();
		$this->setId(md5($generator->nextBytes(10)));
		$this->hasEmail = false;
		$this->categories = array();
	}
	
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setHasEmail($hasEmail = true)
	{
		$this->hasEmail = $hasEmail;
	}
	
	public function getHasEmail()
	{
		return $this->hasEmail;
	}
	
	public function setCategories($categories = [])
	{
		$this->categories = $categories;
	}
	
	public function getCategories()
	{
		return $this->categories;
	}
	
	public function updateCategoryScore($categoryId, $score = 0)
	{
		if ($categoryId) {
			if (!isset($this->categories[$categoryId])) {
				$this->categories[$categoryId] = 0;
			}
			$this->categories[$categoryId] += $score;
		}
		return $this;
	}
}
