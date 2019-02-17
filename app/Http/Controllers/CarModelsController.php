<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarModelsCreateRequest;
use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CarModelsController extends Controller
{

    public function getCarMarks(Request $request, $id)
    {
        if($request->ajax()){
            $carModels = CarModel::where('car_id', $id)->pluck('name', 'id')->all();
            return response()->json($carModels);
        }
        return null;
    }


    public function store (CarModelsCreateRequest $request)
    {
        $data = $request->validated();
        $carsId = Car::pluck('id')->all();

        if(!in_array($data['car_id'], array_values($carsId))){
            return redirect()->back()->withErrors([
                'invalid_car_id', 'Передане значення ідентифікатора марки автомобіля не зареєстроване в системі'
            ]);
        }

        try {
            CarModel::create($data);
            $request->session()->flash('success', 'Модель автомобіля було успішно додано в систему');

            return redirect()->back();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors([
                'create_error', 'Помилка запису до БД!'
            ]);
        }

    }


    public function destroy(CarModel $car_model)
    {
        try {
            $car_model->delete();

            Session::flash('success', 'Модель автомобіля було успішно видплено із системи');
            return redirect()->back();

        } catch(QueryException $e){
            return redirect()->back()->withErrors([
                'delete_error', 'Помилка видалення даних!'
            ]);
        }
    }
}
