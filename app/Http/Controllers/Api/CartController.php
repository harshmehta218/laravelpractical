<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\Create;
use App\Http\Requests\Cart\CreateCart;
use App\Http\Requests\Cart\CreateProduct;
use Illuminate\Http\Request;
use App\Service\CartService;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    private $service;

    public function __construct(CartService $Cartservice)
    {
        $this->service = $Cartservice;
    }

    public function index()
    {
        //
    }

    public function createCart(CreateCart $request)
    {
        $data = $this->service->CreateCart($request);
        return new CartResource($data);
    }

    public function StoreCartProducts(CreateProduct $request)
    {
        $data = $this->service->StoreCartProduct($request);
        return new CartResource($data);
    }

    public function show($id)
    {
        $data = $this->service->resource($id);
        return new CartResource($data);
    }

    public function updateCartProduct(Request $request, $id)
    {
        $data = $this->service->updateCartProduct($request, $id);
        return new CartResource($data);
    }

    public function deleteCartProduct($id)
    {
        $data = $this->service->deleteCartProduct($id);
        return $data;
    }

    public function deleteCart($cart_id)
    {
        $data = $this->service->deleteCart($cart_id);
        return $data;
    }

    public function checkout(Request $request)
    {
        $data = $this->checkoutCartItems($request);
        return $data;
    }
}
