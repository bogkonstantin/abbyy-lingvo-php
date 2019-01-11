<?php

use PHPUnit\Framework\TestCase;
use AbbyyLingvo\Api;
use AbbyyLingvo\Languages;
use AbbyyLingvo\SearchZones;

class ApiTest extends TestCase
{
	private $api;

	public function __construct()
	{
		parent::__construct();
		$this->api = new Api(API_KEY);
	}

	public function testAuthentificate()
	{
		$this->expectException(\InvalidArgumentException::class);
		new Api('123');
	}

	public function testTranslation()
	{
		$translation = $this->api->translation('plum', Languages::EN, Languages::RU);
		$this->assertIsArray($translation);
		$this->assertNotEmpty($translation);
	}

	public function testWordList()
	{
		$wordList = $this->api->wordList('mother', Languages::EN, Languages::RU, 20);
		$this->assertIsArray($wordList);
		$this->assertNotEmpty($wordList);

		$wordList = $this->api->wordList('mother', Languages::EN, Languages::RU, 20);
		$this->assertIsArray($wordList);
		$this->assertNotEmpty($wordList);
	}

	public function testMinicard()
	{
		$minicard = $this->api->minicard('test', Languages::EN, Languages::RU);
		$this->assertIsArray($minicard);
		$this->assertNotEmpty($minicard);
	}

	public function testSearch()
	{
		$searchResult = $this->api->search('board', Languages::EN, Languages::RU, SearchZones::ALL, 0, 10);
		$this->assertIsArray($searchResult);
		$this->assertNotEmpty($searchResult);
	}

	public function testArticle()
	{
		$article = $this->api->article('pin', 'Electronics (En-Ru)', Languages::EN, Languages::RU);
		$this->assertIsArray($article);
		$this->assertNotEmpty($article);
	}

	public function testSuggests()
	{
		$suggests = $this->api->suggests('helo', Languages::EN, Languages::RU);
		$this->assertIsArray($suggests);
		$this->assertNotEmpty($suggests);
	}

	public function testWordForms()
	{
		$wordForms = $this->api->wordForms('колено', Languages::RU);
		$this->assertIsArray($wordForms);
		$this->assertNotEmpty($wordForms);
	}

	public function testSound()
	{
		$sound = $this->api->sound('LingvoUniversal (En-Ru)', 'bang.wav');
		$this->assertIsString($sound);
		$this->assertNotEmpty($sound);
	}
}
