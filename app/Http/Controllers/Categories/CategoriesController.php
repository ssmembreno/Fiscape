<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Categories\CategoriesRequest;
use Illuminate\Auth\Events\Validated;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Categories::whereNull('user_id')
                        ->orderBy('name')
                        ->get();

        $categoriesUsers = Categories::where('user_id' , Auth::id())
                    ->orderBy('created_at')
                    ->get();

        return Inertia::render('Categories/Index', [
            'categories' => $categories,
            'categoriesUsers' => $categoriesUsers
        ]);
    }

    public function create(){
        $categories = Categories::all();

        return Inertia::render('Categories/Create' , [
            'categories' => $categories
        ]);
    }

    public function store(CategoriesRequest $request){

        $validate = $request->validated();

        $validate['user_id'] = Auth::id();

        Categories::create($validate);

        return redirect()->route('categoriesIndex')->with('success', 'Transacción agregada correctamente.');
    }

    public function edit(Categories $categories){

        return  Inertia::render('Categories/Edit' , [
            'categories' => $categories,
        ]);

    }

    public function update(CategoriesRequest $request, Categories $categories){

        $validate = $request->validated();

        $categories->update([
            'name' => $validate['name'],
            'descripcion' => $validate['descripcion']
        ]);

    }

    public function destroy(Categories $categories){
        $categories->delete();
    }

}
