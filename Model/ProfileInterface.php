<?php

namespace Movent\ProfilerBundle\Model;

interface ProfileInterface
{
	function setId($id);
	
	function getId();
	
	function setHasEmail($hasEmail = true);
	
	function getHasEmail();
	
	function setCategories($categories);
	
	function getCategories();
	
	function updateCategoryScore($categoryId, $score);

}
