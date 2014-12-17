<?php

class QuotationspageApi
{

	public function __construct()
	{
		$this->guzzle = new GuzzleHttp\Client();
	}

	public function randomQuote()
	{
		$regEx = "-<dt class=\"quote\">.*</dt>-";
		$matchesCount = preg_match_all($regEx, $this->randomQuotesHtml(), $quoteArray);
		$lastQuoteArray = array_pop($quoteArray);
		return trim(strip_tags($lastQuoteArray[0]));
	}

	private function randomQuotesHtml()
	{
		$res = $this->guzzle->get('http://www.quotationspage.com/random.php3');
		return $res->getBody();
	}

}
