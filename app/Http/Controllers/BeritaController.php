<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        return view('show.index');
    }
}
