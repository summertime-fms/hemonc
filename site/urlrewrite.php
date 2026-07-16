<?php
$arUrlRewrite=array (
  2 =>
  array (
    'CONDITION' => '#^/about-us/publications/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about-us/publications/index.php',
    'SORT' => 100,
  ),
  3 =>
  array (
    'CONDITION' => '#^/about-us/our-doctors/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about-us/our-doctors/index.php',
    'SORT' => 100,
  ),
  0 =>
  array (
    'CONDITION' => '#^/about-us/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about-us/blog/index.php',
    'SORT' => 100,
  ),
  1 =>
  array (
    'CONDITION' => '#^/about-us/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about-us/news/index.php',
    'SORT' => 100,
  ),
  5 =>
  array (
    'CONDITION' => '#^/zabolevaniya/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/zabolevaniya/index.php',
    'SORT' => 100,
  ),
  4 =>
  array (
    'CONDITION' => '#^/poleznoe/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/poleznoe/index.php',
    'SORT' => 100,
  ),
  7 =>
  array (
    'CONDITION' => '#^/rekomendatsii/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/rekomendatsii/index.php',
    'SORT' => 100,
  ),
  6 =>
  array (
    'CONDITION' => '#^/services/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/services/index.php',
    'SORT' => 100,
  ),
    10 => array(
        'CONDITION' => '#^/([a-zA-Z0-9_-]+)/?(\?.*)?$#',
        'RULE' => 'ELEMENT_CODE=$1',
        'ID' => '',
        'PATH' => '/landing.php',
        'SORT' => 90,
    ),
);
