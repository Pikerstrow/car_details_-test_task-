<?php

namespace App\Http\Controllers;

use App\Events\ProductWasDeleted;
use App\Models\Applying;
use App\Models\Car;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(5);
        $editedProduct = '';
        return view('admin.pages.products', compact('products', 'editedProduct'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:4'
        ]);

        try {
            Product::create($data);
            $request->session()->flash('success', 'Запчастину успішно додано до системи! Застосування та модифікації додаються на сторінці запчастини!');

            return redirect()->back();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors([
                'create_error', 'Помилка запису до БД!'
            ]);
        }

    }

    public function show(Product $product)
    {
        $cars = Car::pluck('name', 'id')->all();
        return view('admin.pages.product', compact('product', 'cars'));
    }

    public function edit($id)
    {
        $products = Product::orderBy('id', 'desc')->paginate(5);
        $editedProduct = Product::findOrFail($id);
        return view('admin.pages.products', compact('products', 'editedProduct'));
    }

    public function update (Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|min:4'
        ]);

        try {
            $product->update($data);
            $request->session()->flash('success', 'Назву запчастини відредаговано');

            return redirect()->route('products');

        } catch(QueryException $e){
            return redirect()->back()->withErrors([
                'delete_error', 'Помилка оновлення даних!'
            ]);
        }
    }


    public function destroy(Product $product)
    {
        try {
            $product->delete();

            event(new ProductWasDeleted($product));

            Session::flash('success', 'Запчастину видалено');

            return redirect()->back();
        } catch(QueryException $e){
            return redirect()->back()->withErrors([
                'delete_error', 'Помилка видалення даних!'
            ]);
        }
    }
}
