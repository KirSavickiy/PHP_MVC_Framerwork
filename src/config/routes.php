<?php

use App\Controllers\HomeController;

app()->router->add('/home', function (){
echo 'Home';
}, ['GET']);

app()->router->get('/post/(?P<slug>[a-z0-9-]+)', [HomeController::class, 'index']);
