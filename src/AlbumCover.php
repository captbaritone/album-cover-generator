<?php

class AlbumCover {

	public $hash;
	public $fileName;
	private $flickrApi;
	private $wikipediaApi;
	private $quotationspageApi;

	public function __construct()
	{
		$this->flickrApi = new FlickrApi();
		$this->wikipediaApi = new WikipediaApi();
		$this->quotationspageApi = new QuotationspageApi();
	}

	// Writes an album cover image to disk, and returns it's path
	public function generate()
	{
		$this->newFileName();

		$image = new Image(SIZE, SIZE);

		$coverUrl = $this->flickrApi->randomInterestingImageUrl();
		$image->setBackgroundFromUrl($coverUrl);

		$image->registerColor('white', 255, 255, 255);
		$image->registerColor('black', 0, 0, 0);
		$image->registerFont('carbon', __DIR__ .  "/../carbon.ttf");



		$albumTitle = wordwrap($this->albumTitle(), TITLE_LETTERS);
		$image->textWithShadow(20, 15, SIZE/2, 'white', 'black', 'carbon', $albumTitle);

		$bandName = wordwrap($this->bandName(), BAND_LETTERS);
		$image->textWithShadow(12, 50, SIZE/1.5, 'white', 'black', 'carbon', $bandName);

		$image->writeToFile($this->fileName);

	}

	private function bandName()
	{
		$bandName = $this->wikipediaApi->randomArticleTitle();
		return ucwords(removePunctuation($bandName));
	}

	private function albumTitle()
	{
		$quote = $this->quotationspageApi->randomQuote();
		$quote = removePunctuation($quote);
		$quoteWords = explode(" ", $quote);
		$lastFourWords = array_slice($quoteWords, (sizeof($quoteWords) - 4));
		$lastFourWordsString = implode(" ", $lastFourWords);
		return ucwords($lastFourWordsString);
	}

	// Come up with a name that has not been taken yet
	private function newFileName()
	{
		do {
			$this->hash = md5(rand() * time());
			$this->fileName = "generated/" . $this->hash . ".jpg";
		} while(is_file($this->fileName));
	}
}
