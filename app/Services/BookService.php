<?php

namespace App\Services;


use App\Models\Book;

class BookService
{

    private function __construct()
    {
    }


    public static function getAll()
    {
        return auth()->user()->books;
    }


    /**
     * @param $data
     * @return mixed
     */
    public static function save($data)
    {
        return auth()->user()->books()->create($data);
    }


    /**
     * @throws \Exception
     */
    public static function update($id, $data)
    {
        $book = Book::find($id);
        if ($book->user_id !== auth()->id()) {
            throw new \Exception('you can\'t update this book');
        }

        return $book->update($data);
    }


    public static function getById($id)
    {
        return Book::find($id);
    }


    public static function deleteById($id)
    {
        $book = Book::find($id, ['id', 'user_id']);
        if ($book->user_id !== auth()->id()) {
            throw new \Exception('you can  delete this book');
        }

        return $book->delete();
    }

}
