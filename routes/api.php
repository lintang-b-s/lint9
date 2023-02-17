<?php

use Dingo\Api\Routing\Router;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * Welcome route - link to any public API documentation here
 */
Route::get('/', function () {
    echo 'Welcome to our API';
});

/** @var \Dingo\Api\Routing\Router $api */
// ['middleware' => ['api']],
$api = app('Dingo\Api\Routing\Router');
$api->version('v1',  ['middleware' => ['api']],function (Router $api) {

    // $api->get('/hello', function() {
    //     return 'haloo tes tes';
    // });
    /*
     * Authentication
     */
    $api->group(['prefix' => 'auth'], function (Router $api) {
        $api->group(['prefix' => 'jwt'], function (Router $api) {
            $api->get('/token', 'App\Http\Controllers\Auth\AuthController@token');
        });
    });



    $api->group(['prefix' => 'users'], function (Router $api) {
        $api->get('/', 'App\Http\Controllers\UserController@getAll');
        $api->get('/{uuid}', 'App\Http\Controllers\UserController@get');
        $api->post('/', 'App\Http\Controllers\UserController@post');

    });

    $api->group(['prefix' => 'blog-posts'], function (Router $api) {
        $api->get('/', 'App\Http\Controllers\BlogPostController@index');
        $api->get('/{blogPost}', 'App\Http\Controllers\BlogPostController@show');
    });

    /*
     * Authenticated routes
     */
    $api->group(['middleware' => ['api.auth']], function (Router $api) {
        /*
         * Authentication
         */
        $api->group(['prefix' => 'auth'], function (Router $api) {
            $api->group(['prefix' => 'jwt'], function (Router $api) {
                $api->get('/refresh', 'App\Http\Controllers\Auth\AuthController@refresh');
                $api->delete('/token', 'App\Http\Controllers\Auth\AuthController@logout');
            });

            $api->get('/me', 'App\Http\Controllers\Auth\AuthController@getUser');
        });

        /*
         * Users
         */
        $api->group(['prefix' => 'users', 'middleware' => 'check_role:admin'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\UserController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\UserController@get');
            // $api->post('/', 'App\Http\Controllers\UserController@post');
            $api->put('/{uuid}', 'App\Http\Controllers\UserController@put');
            $api->patch('/{uuid}', 'App\Http\Controllers\UserController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\UserController@delete');
        });

        /*
         * Roles
         */
        $api->group(['prefix' => 'roles'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\RoleController@getAll');
        });


        /*
        * BlogPosts
        */
        $api->group(['prefix' => 'blog-posts'], function (Router $api) {
            $api->post('/', 'App\Http\Controllers\BlogPostController@store');
            $api->put('/{blogPost}', 'App\Http\Controllers\BlogPostController@update');
            $api->delete('/{blogPost}', 'App\Http\Controllers\BlogPostController@destroy');
        });


        /*
        * PostComments
        */
        $api->group(['prefix' => 'post-comments'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\PostCommentController@index');
            $api->get('/{postComment}', 'App\Http\Controllers\PostCommentController@show');
            $api->post('/', 'App\Http\Controllers\PostCommentController@store');
            $api->put('/{postComment}', 'App\Http\Controllers\PostCommentController@update');
            $api->delete('/{postComment}', 'App\Http\Controllers\PostCommentController@destroy');
        });

        /*
        * Tags
        */
        $api->group(['prefix' => 'tags'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\TagController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\TagController@get');
            $api->post('/', 'App\Http\Controllers\TagController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\TagController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\TagController@delete');
        });

        /*
        * PostTags
        */
        $api->group(['prefix' => 'post-tags'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\PostTagController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\PostTagController@get');
            $api->post('/', 'App\Http\Controllers\PostTagController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\PostTagController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\PostTagController@delete');
        });

        /*
        * Categories
        */
        $api->group(['prefix' => 'categories'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\CategoryController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\CategoryController@get');
            $api->post('/', 'App\Http\Controllers\CategoryController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\CategoryController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\CategoryController@delete');
        });

        /*
        * PostCategories
        */
        $api->group(['prefix' => 'post-categories'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\PostCategoryController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\PostCategoryController@get');
            $api->post('/', 'App\Http\Controllers\PostCategoryController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\PostCategoryController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\PostCategoryController@delete');
        });
        
        /*
        * Orders
        */
        $api->group(['prefix' => 'orders'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\OrderController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\OrderController@get');
            $api->post('/', 'App\Http\Controllers\OrderController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\OrderController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\OrderController@delete');
        });

        /*
        * Shippers
        */
        $api->group(['prefix' => 'shippers'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\ShipperController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\ShipperController@get');
            $api->post('/', 'App\Http\Controllers\ShipperController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\ShipperController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\ShipperController@delete');
        });

        /*
        * Payments
        */
        $api->group(['prefix' => 'payments'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\PaymentController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\PaymentController@get');
            $api->post('/', 'App\Http\Controllers\PaymentController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\PaymentController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\PaymentController@delete');
        });

        /*
        * OrderDetails
        */
        $api->group(['prefix' => 'order-details'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\OrderDetailController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\OrderDetailController@get');
            $api->post('/', 'App\Http\Controllers\OrderDetailController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\OrderDetailController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\OrderDetailController@delete');
        });
        
        /*
        * Products
        */
        $api->group(['prefix' => 'products'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\ProductController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\ProductController@get');
            $api->post('/', 'App\Http\Controllers\ProductController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\ProductController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\ProductController@delete');
        });

        /*
        * Suppliers
        */
        $api->group(['prefix' => 'suppliers'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\SupplierController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\SupplierController@get');
            $api->post('/', 'App\Http\Controllers\SupplierController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\SupplierController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\SupplierController@delete');
        });
    });
});

