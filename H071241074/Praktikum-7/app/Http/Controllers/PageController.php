<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function destinasi()
    {
        return view('destinasi');
    }

    public function kuliner()
    {
        return view('kuliner');
    }

    public function peta()
    {
        return view('peta');
    }

    public function galeri()
    {
        return view('galeri');
    }

    public function kontak()
    {
        return view('kontak');
    }
}
