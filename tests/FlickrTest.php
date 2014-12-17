<?php

use VCR\VCR;

class FlickrTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @vcr flickr
	 */
	public function testGetInterestingImageUrl()
	{
		$flickr = new FlickrApi();
		echo $flickr->randomInterestingImageUrl();

	}
}
