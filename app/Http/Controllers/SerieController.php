<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeriePreview;
use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
  public function index()
  {
    return SeriePreview::collection(Serie::all());
  }
}
