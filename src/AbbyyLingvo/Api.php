<?php

namespace AbbyyLingvo\Api;

class Api
{
	public function __construct()
	{
	}

	public function authenticate()
	{
	}

	/**
	 * Словарный перевод слова/фразы. Поиск осуществляется только в указанном направлении
	 */
	public function translation($text, $srcLang, $dstLang, $isCaseSensitive)
	{
	}

	/**
	 * Часть словника, соответствующая имеющимся словарям
	 */
	public function wordList($prefix, $srcLang, $dstLang, $pageSize, $startPos)
	{
	}

	/**
	 * Миникарточка(краткий перевод слова / фразы)
	 */
	public function minicard($text, $srcLang, $dstLang)
	{
	}

	/**
	 * Полнотекстовый поиск по статьям доступных словарей
	 */
	public function search($text, $srcLang, $dstLang, $searchZone, $startIndex, $pageSize)
	{
	}

	/**
	 * Конкретная статья из конкретного словаря Lingvo
	 */
	public function article($heading, $dict, $srcLang, $dstLang)
	{
	}

	/**
	 * Варианты орфокоррекции для слова / фразы
	 */
	public function suggests($text, $srcLang, $dstLang)
	{
	}

	/**
	 * Словоформы для слова
	 */
	public function wordForms($text, $lang)
	{
	}

	/**
	 * Возвращает файл озвучки. Все параметры можно взять из поисковой выдачи
	 */
	public function sound($dictionaryName, $fileName)
	{
	}

}
