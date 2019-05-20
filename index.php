<?php

require('src/Paginator.php');

$input = ['alpha', 'beta', 'delta', 'gamma'];

$input = new \ArrayObject(['alpha', 'beta', 'delta', 'gamma']);

$paginator = (new \Danbyrne84\Paginator($input, 2));
$page = $paginator->paginate(2);

print_r($paginator);
print_r($page);