<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuCariController extends Controller
{
    public function index(Request $request)
    {
        $judul = $request->query('judul');

        // AMAN: nilai dikirim sebagai parameter terikat (binding), bukan digabung ke string SQL
        $hasil = DB::select('SELECT * FROM bukus WHERE judul = ?', [$judul]);

        return response()->json($hasil);
    }
}