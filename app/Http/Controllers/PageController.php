<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($hash)
    {

        $pages = Page::where('hash_id', $hash)->get();

        return response()->json([
            $pages
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $user = auth()->user();

        

        $request->validate([
            'img_01' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_02' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_03' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descricao' => 'required|string|min:6|max:80',
        ]);


        $path01 = $request->file('img_01')->store('fotos', 'public');
        $path02 = $request->file('img_02')->store('fotos', 'public');
        $path03 = $request->file('img_03')->store('fotos', 'public');

        $page = Page::create([
            'img_01' => $path01,
            'img_02' => $path02,
            'img_03' => $path03,
            'descricao' => $request->descricao,
            'user_id' => $user->id,
            'hash_id' => $user->hash
        ]);


        return response()->json([
            'message' => 'Fotos enviadas com sucesso!',
            'path01' => asset('storage/' . $path01),
            'path02' => asset('storage/' . $path02),
            'path03' => asset('storage/' . $path03),
            'page_id' => $page->id,
            'hash_id' => $page->hash_id
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}
