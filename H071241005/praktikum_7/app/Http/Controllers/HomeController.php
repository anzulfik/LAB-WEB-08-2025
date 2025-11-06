<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return view('home');
    }

    public function destinasi(){
        return view('destinasi');
    }

    public function galeri(){
        return view('galeri');
    }

    public function kontak(){
        return view('kontak');
    }
    
    public function kuliner(){
        return view('kuliner');
    }
}
