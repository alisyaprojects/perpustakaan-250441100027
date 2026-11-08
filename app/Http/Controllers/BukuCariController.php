<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuCariController extends Controller
{
    public function index(Request $request)
    {
        $judul = $request->query('judul');

        // RENTAN: nilai digabung langsung ke string SQL (SQL Injection)
        $hasil = DB::select("SELECT * FROM bukus WHERE judul = '$judul'");

        return response()->json($hasil);
    }
}