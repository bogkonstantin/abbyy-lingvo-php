abbyy-lingvo-php
===========

PHP interface to ABBYY Lingvo API

### API Key

Create account and get API key here:  
https://developers.lingvolive.com

### Install

```
composer require bog/abbyy-lingvo-php
```

##### Methods
All methods has the same names as in ABBYY documentation.  
ABBYY documentation:  
https://developers.lingvolive.com/ru-ru/Help
  
  
Usage:
```PHP
$api = new AbbyyLingvo\Api('apiKey');

$api->translation('plum', Languages::EN, Languages::RU);

$api->wordList('mother', Languages::EN, Languages::RU, 20);

$api->wordList('mother', Languages::EN, Languages::RU, 20);

$api->minicard('test', Languages::EN, Languages::RU);

$api->search('board', Languages::EN, Languages::RU, SearchZones::ALL, 0, 10);

$api->article('pin', 'Electronics (En-Ru)', Languages::EN, Languages::RU);

$api->suggests('helo', Languages::EN, Languages::RU);

$api->wordForms('колено', Languages::RU);

$api->sound('LingvoUniversal (En-Ru)', 'bang.wav');
```
