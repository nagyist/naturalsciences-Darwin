<?php 
include(dirname(__FILE__).'/../../bootstrap/Doctrine.php');
$t = new lime_test(9, new lime_output_color());

$t->info('getDistinctCategories');
$cat = SpecimensTable::getDistinctCategories();
$t->is(count($cat),12,'Number of differents categories');
$t->is($cat['Undefined'],'Undefined','get the first category');
$t->is($cat['Collect'],'Collect','get the last category');

$t->info('getDistinctTools');
$cat = Doctrine::getTable('Specimens')->getDistinctTools();
$t->is($cat->count(),2,'Number of differents tools');
$t->is($cat[0]->getTool(),'Fish Net','get the first tool');
$t->is($cat[1]->getTool(),'fish Pas net','get the last tool');

$t->info('getDistinctMethods');
$cat = Doctrine::getTable('Specimens')->getDistinctMethods();
$t->is($cat->count(),2,'Number of differents method');
$t->is($cat[0]->getMethod(),'Hunting','get the first method');
$t->is($cat[1]->getMethod(),'Fishing','get the last method');