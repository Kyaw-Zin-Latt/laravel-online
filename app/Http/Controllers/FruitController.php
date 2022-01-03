<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use App\Http\Requests\StoreFruitRequest;
use App\Http\Requests\UpdateFruitRequest;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class FruitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("welcome");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFruitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFruitRequest $request)
    {
//        return $request;
        $validation = Validator::make($request->all(),[
            "name" => "required|min:3",
            "price" => "required|integer|min:2",
            "photo" => "required|file|mimes:jpg,png,jpeg"
        ]);

        return $request;


        $file = $request->file("photo");
        $newName = uniqid()."_photo.".$file->getClientOriginalExtension();
        $file->storeAs("public/photo",$newName);
        $img = Image::make($file);
        $img->fit(300,300)->save("storage/thumbnail/".$newName);

        if ($validation->fails()) {
            return response()->json([
               "status" => "errors",
               "message" => $validation->errors()
            ]);
        }

        $fruit = new Fruit();
        $fruit->name = $request->name;
        $fruit->price = $request->price;
        $fruit->photo = $newName;
        $fruit->save();

        return response()->json([
            "status" => "success",
            "info" => $request->all(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    public function show(Fruit $fruit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    public function edit(Fruit $fruit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFruitRequest  $request
     * @param  \App\Models\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFruitRequest $request, Fruit $fruit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fruit $fruit)
    {
        //
    }
}
