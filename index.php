<?php

try {
    
    if (!file_exists('User.php'))
    {
      throw new Exception("File User.php not found.");
    }
 
    require_once 'User.php';
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

require_once 'Users.php';

echo '<pre>';
$user = new User(2);

print_r($user);

echo '<hr>';

$array = [1, 2, 4];

$users = new Users($array);
echo '<hr>';

print_r($users);
echo '<hr>';

$users->deleteUsers();

//$user->delete(12);