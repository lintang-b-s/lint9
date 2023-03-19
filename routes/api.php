<?php

use Dingo\Api\Routing\Router;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
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

Route::name('users.')->prefix('users')->group(function () {
    Route::post('/', 'App\Http\Controllers\UserController@store');
});



$api->version('v1',  ['middleware' => ['api']],function (Router $api) {

    /*
     * Authentication
     */
    $api->group(['prefix' => 'auth'], function (Router $api) {
        $api->group(['prefix' => 'jwt'], function (Router $api) {
            $api->get('/token', 'App\Http\Controllers\Auth\AuthController@token');
        });
    });



    $api->group(['prefix' => 'users'], function (Router $api) {
        $api->get('/', 'App\Http\Controllers\UserController@index');
        $api->get('/{uuid}', 'App\Http\Controllers\UserController@show');
        $api->post('/', 'App\Http\Controllers\UserController@store');

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
            $api->get('/', 'App\Http\Controllers\UserController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\UserController@show');
            $api->put('/{uuid}', 'App\Http\Controllers\UserController@put');
            $api->put('/{uuid}', 'App\Http\Controllers\UserController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\UserController@destroy');
            $api->put('/{user}/addrole', 'App\Http\Controllers\UserController@addRole');
        });

        /*
         * Roles
         */
        $api->group(['prefix' => 'roles'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\RoleController@index');
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
            $api->get('/', 'App\Http\Controllers\PostTagController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\PostTagController@show');
            $api->post('/', 'App\Http\Controllers\PostTagController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\PostTagController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\PostTagController@destroy');
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
            $api->get('/', 'App\Http\Controllers\OrderController@index');
            $api->get('/{orderId}', 'App\Http\Controllers\OrderController@show');
            $api->post('/', 'App\Http\Controllers\OrderController@store');
            $api->put('/{orderId}', 'App\Http\Controllers\OrderController@update');

            // $api->delete('/{uuid}', 'App\Http\Controllers\OrderController@destroy');
            // $api->post('', 'App\Http\Controllers\OrderController@');
        });

        /*
        * Shippers
        */
        $api->group(['prefix' => 'shippers'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\ShipperController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\ShipperController@show');
            $api->post('/', 'App\Http\Controllers\ShipperController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\ShipperController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\ShipperController@destroy');
        });

        /*
        * Payments
        */
        $api->group(['prefix' => 'payments'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\PaymentController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\PaymentController@show');
            $api->post('/', 'App\Http\Controllers\PaymentController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\PaymentController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\PaymentController@destroy');
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
            $api->get('/', 'App\Http\Controllers\SupplierController@index');
            $api->get('/{supplier}', 'App\Http\Controllers\SupplierController@show');
            $api->post('/', 'App\Http\Controllers\SupplierController@store');
            $api->put('/{supplier}', 'App\Http\Controllers\SupplierController@update');
            $api->delete('/{supplier}', 'App\Http\Controllers\SupplierController@destroy');
        });

        /*
        * UserPayments
        */
        $api->group(['prefix' => 'user-payments'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\UserPaymentController@index');
            $api->get('/{userPayment}', 'App\Http\Controllers\UserPaymentController@show');
            $api->post('/', 'App\Http\Controllers\UserPaymentController@store');
            $api->put('/{userPayment}', 'App\Http\Controllers\UserPaymentController@update');
            $api->delete('/{userPayment}', 'App\Http\Controllers\UserPaymentController@destroy');
        });

        /*
        * UserAddresses
        */
        $api->group(['prefix' => 'user-addresses'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\UserAddressController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\UserAddressController@show');
            $api->post('/', 'App\Http\Controllers\UserAddressController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\UserAddressController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\UserAddressController@destroy');
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
            $api->put('/{discount}/suppliers', 'App\Http\Controllers\DiscountController@addDiscountToSupplier');
            $api->delete('/{discount}', 'App\Http\Controllers\DiscountController@destroy');
            
        });

        /*
        * OrderItems
        */
        $api->group(['prefix' => 'order-items'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\OrderItemController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\OrderItemController@show');
            $api->post('/', 'App\Http\Controllers\OrderItemController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\OrderItemController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\OrderItemController@destroy');
        });

        /*
        * Carts
        */
        $api->group(['prefix' => 'carts', 'middleware' => ['sessions']], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\CartController@index');
            $api->get('/{cart}', 'App\Http\Controllers\CartController@show');
            $api->post('/', 'App\Http\Controllers\CartController@store');
            $api->put('/{cart}', 'App\Http\Controllers\CartController@update');
            $api->delete('/{cart}', 'App\Http\Controllers\CartController@destroy');
            $api->post('/addToCart', 'App\Http\Controllers\CartController@addToCart');
            $api->post('/removeFromCart', 'App\Http\Controllers\CartController@removeFromCart');
            $api->put('/applyDiscountToCart', 'App\Http\Controllers\CartController@applyDiscountToCart');
            // removeDiscountFromCart
            $api->put('/removeDiscountFromCart', 'App\Http\Controllers\CartController@removeDiscountFromCart');

            $api->put('/{cartId}/applyProductDiscount', 'App\Http\Controllers\CartController@applyProductDiscountToCartItem');
            $api->put('/{cartId}/removeProductDiscount', 'App\Http\Controllers\CartController@removeProductDiscountFromCartItem');


        });

        /*
        * CartItems
        */
        $api->group(['prefix' => 'cart-items', 'middleware' => ['sessions']], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\CartItemController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\CartItemController@show');
            $api->post('/', 'App\Http\Controllers\CartItemController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\CartItemController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\CartItemController@destroy');
            $api->put('/{cartItemId}/addNotes', 'App\Http\Controllers\CartItemController@addNotes');
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
        // belum
        $api->group(['prefix' => 'product-reviews'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\ProductReviewController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\ProductReviewController@show');
            $api->post('/', 'App\Http\Controllers\ProductReviewController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\ProductReviewController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\ProductReviewController@destroy');
        });

        /*
        * Transactions
        */
        $api->group(['prefix' => 'transactions'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\TransactionController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\TransactionController@show');
            $api->post('/', 'App\Http\Controllers\TransactionController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\TransactionController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\TransactionController@destroy');
        });

        /*
        * PivotProductCategories
        */
        $api->group(['prefix' => 'pivot-product-categories'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\PivotProductCategoryController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\PivotProductCategoryController@show');
            $api->post('/', 'App\Http\Controllers\PivotProductCategoryController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\PivotProductCategoryController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\PivotProductCategoryController@destroy');
        });

        /*
        * SupplierTypes
        */
        $api->group(['prefix' => 'supplier-types'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\SupplierTypeController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\SupplierTypeController@show');
            $api->post('/', 'App\Http\Controllers\SupplierTypeController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\SupplierTypeController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\SupplierTypeController@destroy');
        });

        /*
        * Wishlists
        */
        $api->group(['prefix' => 'wishlists'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\WishlistController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\WishlistController@show');
            $api->post('/', 'App\Http\Controllers\WishlistController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\WishlistController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\WishlistController@destroy');
            $api->post('/{productId}', 'App\Http\Controllers\WishlistController@addToWishlist');
            $api->delete('/{productId}', 'App\Http\Controllers\WishlistController@removeFromWishlist');
        });


        /*
        * Shipments
        */
        $api->group(['prefix' => 'shipments'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\ShipmentController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\ShipmentController@show');
            $api->post('/', 'App\Http\Controllers\ShipmentController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\ShipmentController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\ShipmentController@destroy');
        });

        /*
        * ShipmentTypes
        */
        // ->
        $api->group(['prefix' => 'shipment-types'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\ShipmentTypeController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\ShipmentTypeController@show');
            $api->post('/', 'App\Http\Controllers\ShipmentTypeController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\ShipmentTypeController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\ShipmentTypeController@destroy');
        });

        /*
        * ShipmentStatuses
        */
        $api->group(['prefix' => 'shipment-statuses'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\ShipmentStatusController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\ShipmentStatusController@show');
            $api->post('/', 'App\Http\Controllers\ShipmentStatusController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\ShipmentStatusController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\ShipmentStatusController@destroy');
            $api->post('/{shipment}/receivedByCourier', 'App\Http\Controllers\OrderController@receivedByCourier');
            $api->post('/{shipment}/sentFromHub', 'App\Http\Controllers\OrderController@sentFromHub');
            $api->post('/{shipment}/arrivedAtWarehouseFr', 'App\Http\Controllers\OrderController@arrivedAtWarehouseFr');
            $api->post('/{shipment}/sentFromWarehouseFr', 'App\Http\Controllers\OrderController@sentFromWarehouseFr');
            $api->post('/{shipment}/arrivedAtWarehouseDest', 'App\Http\Controllers\OrderController@arrivedAtWarehouseDest');
            $api->post('/{shipment}/sentFromWarehouseDest', 'App\Http\Controllers\OrderController@sentFromWarehouseDest');
            $api->post('/{shipment}/arrivedAtWarehouse', 'App\Http\Controllers\OrderController@arrivedAtWarehouse');
            $api->post('/{shipment}/inDelivery', 'App\Http\Controllers\OrderController@inDelivery');
            $api->post('/{shipment}/received', 'App\Http\Controllers\OrderController@received');

        });


        /*
        * OrderStatuses
        */
        $api->group(['prefix' => 'order-statuses'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\OrderStatusController@index');
            $api->get('/{uuid}', 'App\Http\Controllers\OrderStatusController@show');
            $api->post('/', 'App\Http\Controllers\OrderStatusController@store');
            $api->put('/{uuid}', 'App\Http\Controllers\OrderStatusController@update');
            $api->delete('/{uuid}', 'App\Http\Controllers\OrderStatusController@destroy');
            $api->post('/{order}/payments', 'App\Http\Controllers\OrderStatusController@storePayment');
            $api->post('/{order}/packeds', 'App\Http\Controllers\OrderStatusController@packedStatus');
            $api->put('/{order}/settle', 'App\Http\Controllers\OrderStatusController@settle');
            $api->put('/{order}/cancel', 'App\Http\Controllers\OrderStatusController@cancel');
            $api->put('/{order}/return', 'App\Http\Controllers\OrderStatusController@return');
        });


        /*
        * PrivateChats
        */
        $api->group(['prefix' => 'private-chats'], function (Router $api) {
           
            $api->get('/{chatroom}', 'App\Http\Controllers\PrivateChatController@index');
            $api->post('/{chatroom}', 'App\Http\Controllers\PrivateChatController@store');
            $api->get('/{chatroom}', 'App\Http\Controllers\PrivateChatController@get');
        });

      /*
        * PublicChats
        */
        $api->group(['prefix' => 'public-chats'], function (Router $api) {
            $api->get('/', 'App\Http\Controllers\PublicChatController@index');
       
            $api->post('/{chatroom}', 'App\Http\Controllers\PrivateChatController@store');
            $api->get('/fetch/{chatroom}', 'App\Http\Controllers\PrivateChatController@get');
        });
    });
});

