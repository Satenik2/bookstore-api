<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $orders = OrderService::getAll();

            return response()->json(['orders' => $orders], 200);

        } catch (\Exception $e) {

            Log::error('error when getting all  orders,  error message ' . $e->getMessage() . ' error file and line ' . $e->getFile() . $e->getLine());

            return response()->json(['message' => 'Failed to get orders'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'buyer_email' => 'required|email',
            'total' => 'required',
            'order_items' => 'required'
        ]);
        DB::beginTransaction();

        try {
            $data = $request->all();
            $order = OrderService::save($data);

            DB::commit();

            return response()->json(['order' => $order, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('error when when storing  order  ' . $e->getMessage() . ' error file and line ' . $e->getFile() . $e->getLine());
            return response()->json(['message' => 'storing order Failed!'], 409);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $order = OrderService::getById($id);

            return response()->json(['book' => $order], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'No result'], 500);
        }
    }

}
