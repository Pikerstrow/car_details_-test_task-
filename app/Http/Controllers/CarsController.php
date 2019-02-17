<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    public function index ()
    {
        $cars = Car::all();
        $carsForSelectOptions = $cars->pluck('name', 'id')->all();

        return view('admin.pages.cars', compact('carsForSelectOptions', 'cars'));
    }

}
