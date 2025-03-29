<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class AffairesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::where('type', 'Affaire')->get();
        return view('affaires', ['clients' => $clients, 'title' => 'Liste des clients affaires']);
    }
}