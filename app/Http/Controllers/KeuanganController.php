<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    //
    public function Keuangan(){
      return view('Keuangan', ["title" => 'Belanja Pegawai']);
    }
}
