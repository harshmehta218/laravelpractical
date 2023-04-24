<?php

namespace App\Service;

use App\Models\Cart;
use App\Models\Cart_item;
use App\Models\Product;

class CartService
{
    private $cartModel;
    private $cartItemModel;

    public function __construct(Cart $cart, Cart_item $cartItem)
    {
        $this->cartModel = $cart;
        $this->cartItemModel = $cartItem;
    }

    public function resource($id)
    {
        $cart = $this->cartModel->with('CartItems')->find($id);
        return $cart;
    }

    public function CreateCart($data)
    {
        $createCart = $this->cartModel->create([
            'user_id' => $data->user_id,
        ]);

        if ($createCart != null) {
            $data[]['messages']['cartCreated'] = __('validation.cartCreated');
            return $data;
        }
    }

    public function StoreCartProduct($data)
    {
        $cart = $this->cartModel->where('user_id', $data['user_id'])->first();
        if ($cart !== null) {
            $data[]['message']['cartiscreated'] = __('validation.cartiscreated');
        }
        foreach ($data['product_id'] as $product_id) {
            $this->cartItemModel->create([
                'cart_id' => $cart->id,
                'product_id' => $product_id
            ]);
        }
        return $cart;
    }

    public function updateCartProduct($data, $id)
    {
        $getCartData = $this->resource($id);
        if ($getCartData != null) {
            foreach ($data['product_id'] as $product_id) {
                $this->cartItemModel->where('cart_id', $getCartData->id)->update([
                    'product_id' => $product_id
                ]);
            }
            return $getCartData;
        }
    }

    public function deleteCartProduct($product_id)
    {
        $product = Product::find($product_id);
        if ($product != null) {
            $cartProduct = $this->cartItemModel->find($product);
            if ($cartProduct->delete() == true) {
                $data['message']['cartproductdeleted'] = __('cartproductdeleted');
            }
        }
    }

    public function deleteCart($id)
    {
        $cart = $this->resource($id);
        if ($cart != null) {
            $cartProducts = $this->cartItemModel->where('cart_id', $cart->id)->get();
            foreach ($cartProducts as $cartProduct) {
                $cartProduct->delete();
            }
            $cart->delete();
            $data['message']['cartdeleted'] = __('validation.cartdeleted');
            return $data;
        }
    }

    public function checkout($data)
    {
        $price = 0;
        $cart = $this->resource($data['cart_id']);

        if ($cart != null) {
            $cartProducts = $this->cartItemModel->where('cart_id', $cart->id)->get();
            foreach ($cartProducts as $cartProduct) {
                $price = $price + $cartProduct;
                $cartProduct->delete();
            }
            $cart->delete();
            $data[]['data'] = [
                'total' => $price,
                'message' => __('validation.orderplaced'),
            ];
            return $data;
        }
    }
}
