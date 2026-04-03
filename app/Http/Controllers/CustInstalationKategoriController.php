<?php

namespace App\Http\Controllers;


class CustinstalationKategoriController extends Controller
{
    public function index()
    {
        $path = public_path('data/categories.json');
        $categories = json_decode(file_get_contents($path), true);

        return view('katalog', compact('categories'));
    }
}