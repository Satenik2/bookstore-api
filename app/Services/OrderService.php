<?php

namespace App\Services;


use App\Models\Book;
use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrderService
{

    private function __construct()
    {
    }


    public static function getAll()
    {
        return auth()->user()->orders;
    }


    /**
     * @param $data
     * @return mixed
     */
    public static function save($data)
    {
        $orderItems = $data['order_items'];
        $orderData = Arr::except($data, 'order_items');
        $order = auth()->user()->orders()->create($orderData);
        $bookIds = array_column($orderItems, 'book_id');

        // TODO we should add validation to check quantity and
        // and decrease book quantity from books table
        if (Book::whereIn('id', $bookIds)->count() != count($bookIds)) {
            throw new \Exception('book id not found');
        }
        $order->orderItems()->createMany($orderItems);

        return $order->load('orderItems');
    }



    public static function getById($id)
    {
        $order = Order::find($id);
        if ($order->user_id !== auth()->id()) {
            throw new \Exception('you can\'t get this order');
        }

        return Order::with('orderItems')->find($id);
    }
}
