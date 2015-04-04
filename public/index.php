<?php use App\Http\Controllers\FeedController;

// Require composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
$router->get('', function() { echo (new FeedController)->index(); });
$router->get('/add', function() { echo (new FeedController)->create(); });
$router->post('/add', function() { echo (new FeedController)->store(); });
$router->post('show/(\d+)',   function($feed_id) { echo (new FeedController)->show($feed_id); });
$router->post('delete/(\d+)', function($feed_id) { echo (new FeedController)->destroy($feed_id); });

// Run it!
$router->run();