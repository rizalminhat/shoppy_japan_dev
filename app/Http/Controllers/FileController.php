<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Suopport\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{

    public function __construct()
  {
  	$this->middleware('auth');
  }

  public function getFile($foldername,$filename)
  {
    //  if (auth()->user()->hasRole('admin') )
    //  {
    //     $fullpath="{$foldername}/{$filename}";
    //     return response()->download(storage_path($fullpath), null, [], null);
    //  }
    $fullpath="storage/{$foldername}/{$filename}";
    return Storage::download($fullpath);
  }
}
