<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;

class ConcertsController extends Controller
{
    public function show(int $id)
    {
        $concert = Concert::published()->findOrFail($id);

        return view('concerts.show', compact('concert'));
    }
}
