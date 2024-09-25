<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    public static function addItemToCart($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;

        // Check if the item already exists in the cart
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            // Increment the quantity if the product already exists in the cart
            $cart_items[$existing_item]['quantity']++;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        } else {
            // Add the product to the cart if it doesn't exist
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                    'quantity' => 1,
                    'image' => $product->images[0],
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);

        // Return the total count of items in the cart
        return count($cart_items);
    }

    public static function addItemToCartWithQuantity($product_id, $qty=1)
    {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;

        // Check if the item already exists in the cart
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            // Increment the quantity if the product already exists in the cart
            $cart_items[$existing_item]['quantity'] = $qty;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        } else {
            // Add the product to the cart if it doesn't exist
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                    'quantity' => $qty,
                    'image' => $product->images[0],
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);

        // Return the total count of items in the cart
        return count($cart_items);
    }

    public static function removeCartItem($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart_items[$key]);
            }
        }
        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    public static function addCartItemsToCookie($cart_items)
    {
        Cookie::queue('cart_item', json_encode($cart_items), 60 * 24 * 30);
    }

    public static function clearCartItems()
    {
        Cookie::queue(Cookie::forget('cart_item'));
    }

    public static function getCartItemsFromCookie()
    {
        $cart_items = json_decode(Cookie::get('cart_item'), true);
        if (! $cart_items) {
            $cart_items = [];
        }

        return $cart_items;
    }

    public static function incrementQuantityTToCartItem($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
        }
        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    public static function decrementQuantityTToCartItem($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                if ($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                }
            }
        }
        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    public static function calculateGrandTotal($items)
    {
        return array_sum(array_column($items, 'total_amount'));
    }
}
