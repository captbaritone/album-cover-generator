<?php

class FlickrApi
{
	private $apiKey = 'd29428c5b36bf1f1ac803c92f26fdfc6';

	public function __construct()
	{
		$this->guzzle = new GuzzleHttp\Client();
	}

	public function randomInterestingImageUrl()
	{
		$photos = $this->interestingImagesArray();

		$randomKey = array_rand($photos);
		$photo = $photos[$randomKey];

		return $this->imageUrlFromArray($photo);
	}

	private function interestingImagesArray()
	{
		$response = $this->interestingImagesJson();

		return $response['photos']['photo'];
	}

	private function interestingImagesJson()
	{
		$response = $this->guzzle->get("https://api.flickr.com/services/rest/", [
			'query' => [
				'method' => 'flickr.interestingness.getList',
				'api_key' => $this->apiKey,
				'format' => 'json',
				'nojsoncallback' => 1
			]
		]);
		
		return $response->json();
	}

	private function imageUrlFromArray($array)
	{
		return "http://farm{$array['farm']}.staticflickr.com/{$array['server']}/{$array['id']}_{$array['secret']}_z.jpg";
	}
}
