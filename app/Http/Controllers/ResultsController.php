<?php

namespace App\Http\Controllers;

use App\Services\AnimalCatalog;

class ResultsController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'animals' => AnimalCatalog::all(),
            'widget' => config('bicho.widget'),
            'logo' => is_file(public_path(config('brand.logo'))) ? config('brand.logo') : null,
        ]);
    }
}
