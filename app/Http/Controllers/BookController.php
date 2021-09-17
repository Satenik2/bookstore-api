<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $books = BookService::getAll();

            return response()->json(['books' => $books], 200);

        } catch (\Exception $e) {

            Log::error('error when getting all  books,  error message ' . $e->getMessage() . ' error file and line ' . $e->getFile() . $e->getLine());

            return response()->json(['message' => 'Failed to get books'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required|string',
            'author' => 'required|string',
        ]);

        try {
            $data = $request->all();
            $book = BookService::save($data);

            return response()->json(['books' => $book], 201);

        } catch (\Exception $e) {

            Log::error('error when creating book error message ' . $e->getMessage() . ' error file and line ' . $e->getFile() . $e->getLine());

            return response()->json(['message' => 'Something went wrong'], 500);
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
            $book = BookService::getById($id);

            return response()->json(['book' => $book], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'No result'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        try {
            $book = BookService::getById($id);

            return response()->json(['book' => $book], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'No result'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'string',
            'author' => 'string',
        ]);
        try {
            $data = $request->all();

            BookService::update($id, $data);

            return response()->json(['message' => 'Updated Successfully'], 200);

        } catch (\Exception $e) {

            Log::error('error when updating book error message ' . $e->getMessage() . ' error file and line ' . $e->getFile() . $e->getLine());

            return response()->json(['message' => 'Book was not updated'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            BookService::deleteById($id);

            return response()->json(['message' => 'successfully deleted'], 200);

        } catch (\Exception $e) {
            Log::error('error when deleting book,  error message ' . $e->getMessage() . ' error file and line ' . $e->getFile() . $e->getLine());

            return response()->json(['message' => 'Unable to delete book'], 500);
        }
    }
}
