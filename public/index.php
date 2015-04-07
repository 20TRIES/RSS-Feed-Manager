<?php use App\Http\Controllers\FeedController;

// Require composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Crude blocking of exceptions and errors.
// This should be done during production to respond to
// unexpected errors and exceptions.

ini_set('display_errors', 'off');

set_error_handler("error_handler", E_ALL);
set_exception_handler("error_handler");
function error_handler($errno, $errstr)
{
    header('HTTP/1.1 500 Internal Server Error');
    echo('Oops It looks like something went wrong.');
    exit();
}


// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes

// Custom 404 Handler
$router->set404(function()
{
    header('HTTP/1.1 404 Not Found');
    echo "Oops we couldn't find that!";
});

$router->get('', function() { echo (new FeedController)->index(); });
$router->get('/add', function() { echo (new FeedController)->create(); });
$router->post('/add', function() { echo (new FeedController)->store(); });
$router->get('/show/(\d+)',   function($feed_id) { echo (new FeedController)->show($feed_id); });

// !!! Should a delete route use the GET verb?!?
$router->get('/delete/(\d+)', function($feed_id) { echo (new FeedController)->destroy($feed_id); });

// Run it!
$router->run();