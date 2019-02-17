<?php

namespace App\Http\Controllers;

use App\Models\Applying;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ApplyingsController extends Controller
{
    public function storeWithAjax(Request $request, $productId)
    {
        $applying = new Applying();
        $applying->car_id = $request->get('car_id');
        $applying->car_model_id = $request->get('car_model_id');

        if($applying->save()){
            $applying->products()->attach($productId);

            return response()->json([
                'id' => $applying->id,
                'car_mark' => $applying->car->name,
                'car_model' => $applying->car_model->name
            ]);
        }
        return null;
    }


    public function destroy(Applying $applying)
    {
        if($applying->products()->detach()){
            try {
                $applying->delete();
                return redirect()->back();

            } catch(QueryException $e){
                return redirect()->back()->withErrors([
                    'delete_error', 'Помилка видалення даних!'
                ]);
            }
        }
    }


    public function destroyWithAjax($id)
    {
        $applying = Applying::findOrFail($id);

        if($applying->products()->detach()){
            if($applying->delete()){
                return 'deleted';
            }
        }
        return false;
    }
}
