<?php

//Task: Validator, որի կանոնները մենք կարող ենք ավելացնել ձեռք չտալով գգլխավոր լոգիկան

error_reporting(E_NOTICE);
function my_autoloader($class) {
    include $class . '.php';
}
spl_autoload_register('my_autoloader');

$request = [
    'email' => "asd@asd",
    'shit' => "some name",
];
echo "custom rule with 'min' rule: " . "<br>";
$obj = new CustomValidator();

$obj->make($request, [
    'email' => 'email|required',
    'shit' => 'required|min:5',
    'asd' => 'required'
]);
var_dump($obj->getErrors());


echo "<br>" . "default rule without 'min' rule: " . "<br>";
$obj2 = new Validator();

$obj2->make($request, [
    'email' => 'required',
    'shit' => 'required|min:5',
    'asd' => 'required'
]);
var_dump($obj2->getErrors());

