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


    $api->group(['prefix' => 'categories'], function (Router $api) {
        $api->get('/', 'App\Http\Controllers\CategoryController@index');
        $api->get('/{category}', 'App\Http\Controllers\CategoryController@show');
     
    });

    $api->group(['prefix' => 'tags'], function (Router $api) {
        $api->get('/', 'App\Http\Controllers\TagController@index');
        $api->get('/{tag}', 'App\Http\Controllers\TagController@show');
      
    });


    $api->group(['prefix' => 'products'], function (Router $api) {
        $api->get('/', 'App\Http\Controllers\ProductController@index');
        $api->get('/{product}', 'App\Http\Controllers\ProductController@show');
    
    });


     /*
        * Discounts
        */
        $api->group(['prefix' => 'discounts'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\DiscountController@index');
            $api->get('/{discount}', 'App\Http\Controllers\DiscountController@show');
          
        });

    /*
    *   product-categories
    */
    $api->group(['prefix' => 'product-categories'], function (Router $api) {
        $api->get('/', 'App\Http\Controllers\ProductCategoryController@index');
        $api->get('/{productCategory}', 'App\Http\Controllers\ProductCategoryController@show');

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
   
            $api->post('/', 'App\Http\Controllers\TagController@store');
            $api->put('/{tag}', 'App\Http\Controllers\TagController@update');
            $api->delete('/{tag}', 'App\Http\Controllers\TagController@destroy');
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
            $api->post('/', 'App\Http\Controllers\CategoryController@store');
            $api->put('/{category}', 'App\Http\Controllers\CategoryController@update');
            $api->delete('/{category}', 'App\Http\Controllers\CategoryController@destroy');
        });

        /*
        * PostCategories
        */
        $api->group(['prefix' => 'post-categories'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\PostCategoryController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\PostCategoryController@show');
            $api->post('/', 'App\Http\Controllers\PostCategoryController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\PostCategoryController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\PostCategoryController@destroy');
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
        * Products
        */
        $api->group(['prefix' => 'products'], function (Router $api) {
         
            $api->post('/', 'App\Http\Controllers\ProductController@store');
            $api->put('/{product}', 'App\Http\Controllers\ProductController@update');
            $api->delete('/{product}', 'App\Http\Controllers\ProductController@destroy');
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

        /*
        * UserPayments
        */
        $api->group(['prefix' => 'user-payments'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\UserPaymentController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\UserPaymentController@get');
            $api->post('/', 'App\Http\Controllers\UserPaymentController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\UserPaymentController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\UserPaymentController@delete');
        });

        /*
        * UserAddresses
        */
        $api->group(['prefix' => 'user-addresses'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\UserAddressController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\UserAddressController@get');
            $api->post('/', 'App\Http\Controllers\UserAddressController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\UserAddressController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\UserAddressController@delete');
        });

        /*
        * Discounts
        */
        $api->group(['prefix' => 'discounts'], function (Router $api) {
            $api->post('/', 'App\Http\Controllers\DiscountController@store');
            $api->put('/{discount}', 'App\Http\Controllers\DiscountController@update');
            $api->put('/{discount}/products', 'App\Http\Controllers\DiscountController@addDiscountToProducts');
            $api->put('/{discount}/productCategories', 'App\Http\Controllers\DiscountController@addDiscountToCategories');
            $api->put('/{discount}/suppliersType', 'App\Http\Controllers\DiscountController@addDiscountToSuppliersType');


            $api->delete('/{discount}', 'App\Http\Controllers\DiscountController@destroy');
        });

        /*
        * OrderItems
        */
        $api->group(['prefix' => 'order-items'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\OrderItemController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\OrderItemController@get');
            $api->post('/', 'App\Http\Controllers\OrderItemController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\OrderItemController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\OrderItemController@delete');
        });

        /*
        * Carts
        */
        $api->group(['prefix' => 'carts', 'middleware' => ['sessions']], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\CartController@index');
            $api->get('/{cart}', 'App\Http\Controllers\CartController@show');
            $api->post('/', 'App\Http\Controllers\CartController@store');
            $api->patch('/{cart}', 'App\Http\Controllers\CartController@update');
            $api->delete('/{cart}', 'App\Http\Controllers\CartController@destroy');
            $api->post('/addToCart', 'App\Http\Controllers\CartController@addToCart');
            $api->post('/removeFromCart', 'App\Http\Controllers\CartController@removeFromCart');
            $api->put('/applyDiscountToCart', 'App\Http\Controllers\CartController@applyDiscountToCart');
        });

        /*
        * CartItems
        */
        $api->group(['prefix' => 'cart-items'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\CartItemController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\CartItemController@get');
            $api->post('/', 'App\Http\Controllers\CartItemController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\CartItemController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\CartItemController@delete');
        });

        /*
        *   product-categories
        */
        $api->group(['prefix' => 'product-categories'], function (Router $api) {
            $api->post('/', 'App\Http\Controllers\ProductCategoryController@store');
            $api->put('{productCategory}', 'App\Http\Controllers\ProductCategoryController@update');
            $api->delete('{productCategory}', 'App\Http\Controllers\ProductCategoryController@destroy');
        });

        /*
        * ProductReviews
        */
        $api->group(['prefix' => 'product-reviews'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\ProductReviewController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\ProductReviewController@get');
            $api->post('/', 'App\Http\Controllers\ProductReviewController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\ProductReviewController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\ProductReviewController@delete');
        });

        /*
        * Transactions
        */
        $api->group(['prefix' => 'transactions'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\TransactionController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\TransactionController@get');
            $api->post('/', 'App\Http\Controllers\TransactionController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\TransactionController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\TransactionController@delete');
        });

        /*
        * PivotProductCategories
        */
        $api->group(['prefix' => 'pivot-product-categories'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\PivotProductCategoryController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\PivotProductCategoryController@get');
            $api->post('/', 'App\Http\Controllers\PivotProductCategoryController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\PivotProductCategoryController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\PivotProductCategoryController@delete');
        });

        /*
        * SupplierTypes
        */
        $api->group(['prefix' => 'supplier-types'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\SupplierTypeController@getAll');
            $api->get('/{uuid}', 'App\Http\Controllers\SupplierTypeController@get');
            $api->post('/', 'App\Http\Controllers\SupplierTypeController@post');
            $api->patch('/{uuid}', 'App\Http\Controllers\SupplierTypeController@patch');
            $api->delete('/{uuid}', 'App\Http\Controllers\SupplierTypeController@delete');
        });
    });
});

