<?php
namespace App\Http\Controllers;
use App\Currencies;

class CurrenciesController extends Controller
{
    public function index()
    {
       return response()->json(Currencies::all());
    }

     public function show($id)
     {
         return response()->json(Currencies::find($id));
   }

    // public function store()
    // {
        
    // }

//    public function delete() {}
}