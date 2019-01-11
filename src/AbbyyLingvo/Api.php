<?php

namespace AbbyyLingvo;

/**
 * ABBYY Lingvo Dictionary Api PHP
 *
 * @author Konstantin Bogomolov <bog.konstantin@gmail.com>
 * @link https://github.com/bogkonstantin/abbyy-lingvo-php
 */
class Api
{
	const AUTH_BASIC = 'Basic';
	const AUTH_BEARER = 'Bearer';

	const BASIC_URL = 'https://developers.lingvolive.com/';

	const URL_AUTH = 'api/v1.1/authenticate';
	const URL_TRANSLATE = 'api/v1/Translation';
	const URL_WORD_LIST = 'api/v1/WordList';
	const URL_MINICARD = 'api/v1/Minicard';
	const URL_SEARCH = 'api/v1/Search';
	const URL_ARTICLE = 'api/v1/Article';
	const URL_SUGGESTS = 'api/v1/Suggests';
	const URL_WORD_FORMS = 'api/v1/WordForms';
	const URL_SOUND = 'api/v1/Sound';

	/**
	 * @var string
	 */
	private $apiKey;

	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var \GuzzleHttp\Client
	 */
	private $transport;

	public function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
		$this->transport = new \GuzzleHttp\Client(['exceptions' => false]);

		$this->authenticate();
	}

	/**
	 * Словарный перевод слова/фразы. Поиск осуществляется только в указанном направлении
	 * @param string $text
	 * @param int $srcLang
	 * @param int $dstLang
	 * @param bool $isCaseSensitive
	 * @return array
	 * @throws \Exception
	 */
	public function translation($text, $srcLang, $dstLang, $isCaseSensitive = false)
	{
		return $this->getRequest(
			self::URL_TRANSLATE,
			[
				'text' => $text,
				'srcLang' => $srcLang,
				'dstLang' => $dstLang,
				'isCaseSensitive' => $isCaseSensitive,
			]
		);
	}

	/**
	 * Часть словника, соответствующая имеющимся словарям
	 * @param string $prefix
	 * @param int $srcLang
	 * @param int $dstLang
	 * @param int $pageSize
	 * @param string $startPos
	 * @return array
	 * @throws \Exception
	 */
	public function wordList($prefix, $srcLang, $dstLang, $pageSize, $startPos = '')
	{
		return $this->getRequest(
			self::URL_WORD_LIST,
			[
				'prefix' => $prefix,
				'srcLang' => $srcLang,
				'dstLang' => $dstLang,
				'pageSize' => $pageSize,
				'startPos' => $startPos,
			]
		);
	}

	/**
	 * Миникарточка(краткий перевод слова / фразы)
	 * @param string $text
	 * @param int $srcLang
	 * @param int $dstLang
	 * @return array
	 * @throws \Exception
	 */
	public function minicard($text, $srcLang, $dstLang)
	{
		return $this->getRequest(
			self::URL_MINICARD,
			[
				'text' => $text,
				'srcLang' => $srcLang,
				'dstLang' => $dstLang,
			]
		);
	}

	/**
	 * Полнотекстовый поиск по статьям доступных словарей
	 * @param string $text
	 * @param int $srcLang
	 * @param int $dstLang
	 * @param int $searchZone
	 * @param int $startIndex
	 * @param int $pageSize
	 * @return array
	 * @throws \Exception
	 */
	public function search($text, $srcLang, $dstLang, $searchZone, $startIndex, $pageSize)
	{
		return $this->getRequest(
			self::URL_SEARCH,
			[
				'text' => $text,
				'srcLang' => $srcLang,
				'dstLang' => $dstLang,
				'searchZone' => $searchZone,
				'startIndex' => $startIndex,
				'pageSize' => $pageSize,
			]
		);
	}

	/**
	 * Конкретная статья из конкретного словаря Lingvo
	 * @param string $heading
	 * @param string $dict
	 * @param int $srcLang
	 * @param int $dstLang
	 * @return array
	 * @throws \Exception
	 */
	public function article($heading, $dict, $srcLang, $dstLang)
	{
		return $this->getRequest(
			self::URL_ARTICLE,
			[
				'heading' => $heading,
				'dict' => $dict,
				'srcLang' => $srcLang,
				'dstLang' => $dstLang,
			]
		);
	}

	/**
	 * Варианты орфокоррекции для слова / фразы
	 * @param string $text
	 * @param int $srcLang
	 * @param int $dstLang
	 * @return array
	 * @throws \Exception
	 */
	public function suggests($text, $srcLang, $dstLang)
	{
		return $this->getRequest(
			self::URL_SUGGESTS,
			[
				'text' => $text,
				'srcLang' => $srcLang,
				'dstLang' => $dstLang,
			]
		);
	}

	/**
	 * Словоформы для слова
	 * @param string $text
	 * @param int $lang
	 * @return array
	 * @throws \Exception
	 */
	public function wordForms($text, $lang)
	{
		return $this->getRequest(
			self::URL_WORD_FORMS,
			[
				'text' => $text,
				'lang' => $lang,
			]
		);
	}

	/**
	 * Возвращает файл озвучки. Все параметры можно взять из поисковой выдачи
	 * @param string $dictionaryName
	 * @param string $fileName
	 * @return array
	 * @throws \Exception
	 */
	public function sound($dictionaryName, $fileName)
	{
		return $this->getRequest(
			self::URL_SOUND,
			[
				'dictionaryName' => $dictionaryName,
				'fileName' => $fileName,
			]
		);
	}

	private function authenticate()
	{
		$response = $this->transport->request('POST',
			$this->getFullUrl(self::URL_AUTH),
			$this->getAuthHeader(self::AUTH_BASIC, $this->apiKey)
		);

		if ($response->getStatusCode() !== 200) {
			throw new \InvalidArgumentException('Check your API Key');
		}

		$this->token = $response->getBody()->getContents();
	}

	private function getFullUrl($apiUrl)
	{
		return self::BASIC_URL . $apiUrl;
	}

	private function getAuthHeader($type, $key)
	{
		return [
			'headers' => [
				'Authorization' => $type . ' ' . $key,
			],
		];
	}

	private function getRequest($apiUrl, $params)
	{
		$queryOptions = array_merge(
			$this->getAuthHeader(self::AUTH_BEARER, $this->token),
			['query' => $params]
		);
		$response = $this->transport->request(
			'GET',
			$this->getFullUrl($apiUrl),
			$queryOptions
		);

		if ($response->getStatusCode() === 401) {
			$this->authenticate();
			return $this->getRequest($apiUrl, $params);
		}

		if ($response->getStatusCode() !== 200) {
			throw new \Exception($response->getBody()->getContents());
		}

		return \json_decode($response->getBody()->getContents(), true);
	}

}
