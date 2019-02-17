<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModificationsCreateRequest;
use App\Http\Requests\ModificationsUpdateRequest;
use App\Models\Modification;
use http\Env\Response;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModificationsController extends Controller
{
    const TEMP_STORAGE_PATH = 'images/modifications/temp_storage/';
    const MAIN_STORAGE_PATH = 'images/modifications/main_storage/';
    const DELETED_STORAGE_PATH = 'images/modifications/deleted_storage/';

    public function storeWithAjax(ModificationsCreateRequest $request, $productId)
    {
        $data = $request->validated();

        if($data){
            if($photo = $request->file('photo')){
                $name = time() . $photo->getClientOriginalName();

                if($photo->move(self::MAIN_STORAGE_PATH, $name)){
                    $data['photo'] = url(self::MAIN_STORAGE_PATH . $name);

                    /*clean temp_storage where we store photos for preview*/
                    $filesystem = new Filesystem();
                    $filesystem->cleanDirectory(self::TEMP_STORAGE_PATH);

                    /*save new modification to db*/
                    $data['product_id'] = $productId;

                    if($modification = Modification::create($data)){

                        $condition = $modification->condition ? 'нова' : 'б/в';
                        $stock     = $modification->is_sold ? 'продано' : 'в наявності';

                        /*create and return row for inserting into table*/
                        $html = "<tr class='text-center'><td><img width='70' src='{$modification->photo}'></td>";
                        $html .= "<td class='text-left'>" . str_limit($modification->description, 80) . "</td>";
                        $html .= "<td>" . $condition . "</td>";
                        $html .= "<td>" . $stock . "</td>";
                        $html .= "<td>" . number_format($modification->price, 2, ".", " ")  . "</td>";
                        $html .= "<td>" . $modification->created_at->diffForHumans()  . "</td>";
                        $html .= "<td><a href='". route('show.modification', $modification) . "' data-id='{$modification->id}' class='modification-edit-button'><i style='color:darkgreen' class='far fa-eye'></i></a> ";
                        $html .= "<a href='". route('edit.modification', $modification) . "' data-id='{$modification->id}' class='modification-edit-button'><i style='color: royalblue' class='fas fa-pen'></i></a> ";
                        $html .= "<button data-id='{$modification->id }' class='modification-delete-button'><i style='color: darkred' class='fas fa-plus delete-i'></i></button></td></tr>";

                        return \response()->json($html);
                    }
                }
            }
        }
    }

    public function storePhotoWithAjax(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:5120'
        ]);

        $photo = $request->file('photo');
        $name = time() . $photo->getClientOriginalName();

        if($photo->move(self::TEMP_STORAGE_PATH, $name)){
            return response()->json( url(self::TEMP_STORAGE_PATH . $name) );
        }
    }

    public function destroyWithAjax($id)
    {
        $modification = Modification::findOrFail($id);
        $photo = self::MAIN_STORAGE_PATH . $modification->getFileNameFromFileUrl();

        /*Because we using soft delete for modifications, we don't delete file permanently. All we do is just move it
        from main storage to temporary one ('deleted_storage')*/
        if(File::exists($photo)){
            File::move($photo, self::DELETED_STORAGE_PATH . $modification->getFileNameFromFileUrl());
        }

        if($modification->delete()){
            return 'deleted';
        }

        return false;
    }


    public function destroy(Modification $modification)
    {
        $photo = self::MAIN_STORAGE_PATH . $modification->getFileNameFromFileUrl();

        /*Because we using soft delete for modifications, we don't delete file permanently. All we do is just move it
        from main storage to temporary one ('deleted_storage')*/
        if(File::exists($photo)){
            File::move($photo, self::DELETED_STORAGE_PATH . $modification->getFileNameFromFileUrl());
        }

        try {
            $productId = $modification->product_id;
            $modification->delete();
            Session::flash('success', 'Модифікацію видалено');

            return redirect()->route('show.product', $productId);
        } catch(\Exception $e){
            return redirect()->back()->withErrors([
                'delete_error', 'Помилка видалення даних!'
            ]);
        }

    }


    public function edit(Modification $modification)
    {
        return view('admin.pages.edit-modification', compact('modification'));
    }


    public function update(ModificationsUpdateRequest $request, $id)
    {
        $modification = Modification::findOrFail($id);
        $data = $request->validated();

        if($photo = $request->file('photo')){
            $name = time() . $photo->getClientOriginalName();

            if($photo->move(self::MAIN_STORAGE_PATH, $name)){
                $data['photo'] = url(self::MAIN_STORAGE_PATH . $name);

                /*clean temp_storage where we store photos for preview*/
                $filesystem = new Filesystem();
                $filesystem->cleanDirectory(self::TEMP_STORAGE_PATH);

                /*delete previous modification photo*/
                $oldPhoto = self::MAIN_STORAGE_PATH . $modification->getFileNameFromFileUrl();
                if(File::exists($oldPhoto)){
                    File::delete($oldPhoto);
                }
            }
        }

        /*update current modification in db*/
        try{
            $modification->update($data);
            $request->session()->flash('success', 'Модифікацію запчастини оновлено');

            return redirect()->route('show.product', $modification->product_id);

        } catch(\Exception $e){
            return redirect()->back()->withErrors([
                'update_error', 'Помилка оновлення даних!'
            ]);
        }
    }


    public function show(Modification $modification)
    {
        return view('admin.pages.show-modification', compact('modification'));
    }

}
