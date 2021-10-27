<?php 

// src/Form/DataTransformer/IssueToNumberTransformer.php
// CONVERT String to array and Array to string

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\VarDumper\VarDumper;


class ArrayTransformer implements DataTransformerInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function transform($string)
	{
	    // GET convert json string to array
		//VarDumper::dump('Transform GET:'.$string);
		if($string != null || $string != ''){
		    $decode = json_decode($string, true);
            //VarDumper::dump($decode);
			return $decode;
		}
		
	}

	/**
	 * {@inheritdoc}
	 */
	public function reverseTransform($string)
	{
	    // SET convert array to string
		//VarDumper::dump($string);
		if($string != null || $string != ''){

		    //$json = json_encode($string, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
            $json = json_encode($string, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
            VarDumper::dump($json);
			return $json;
		}
	}
}
