<?php

class WikipediaApi
{

	public function __construct()
	{
		$this->guzzle = new GuzzleHttp\Client();
	}

	public function randomArticleTitle()
	{
		$response = $this->randomArticleJson();
		return $response['query']['random'][0]['title'];
	}

	private function randomArticleJson()
	{
		return $this->guzzle->get('http://en.wikipedia.org/w/api.php', [
			'query' => [
				'action' => 'query',
				'rnnamespace' => '0',
				'list' => 'random',
				'rnlimit' => '1',
				'format' => 'json'
			]
		])->json();
	}

}
