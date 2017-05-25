<?php

require __DIR__.'/../FlSouto/HtSorter.php';
require __DIR__.'/../FlSouto/HtSorterUrl.php';

$obj = new FlSouto\HtSorter('users_sort');

$users = [
    ['id'=>1, 'nome' => 'Rodrigo'],
    ['id'=>2, 'nome' => 'Letícia'],
    ['id'=>3, 'nome' => 'Mariana']
];

$obj->data($users);
$obj->context(['users_sort'=>'nome asc']);
$obj->process();

echo $obj->url()->toggle('nome');

print_r($users);

// htf
// htsort