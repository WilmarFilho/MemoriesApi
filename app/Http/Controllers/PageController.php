<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Pages",
 *     description="Endpoints for managing pages"
 * )
 */
class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/pages/{hash}",
     *     tags={"Pages"},
     *     summary="Get list of pages by hash",
     *     description="Retrieve all pages associated with a given hash_id",
     *     @OA\Parameter(
     *         name="hash",
     *         in="path",
     *         description="Hash ID associated with the pages",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of pages",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Page"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */
    public function index($hash)
    {
        $pages = Page::where('hash_id', $hash)->get();

        return response()->json([
            $pages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/page/novo",
     *     tags={"Pages"},
     *     summary="Create a new page",
     *     description="Store a new page with images and description",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"img_01", "img_02", "img_03", "descricao"},
     *             @OA\Property(property="img_01", type="string", format="binary"),
     *             @OA\Property(property="img_02", type="string", format="binary"),
     *             @OA\Property(property="img_03", type="string", format="binary"),
     *             @OA\Property(property="descricao", type="string", example="Descrição da página")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Page created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Fotos enviadas com sucesso!"),
     *             @OA\Property(property="path01", type="string", example="https://example.com/foto1.jpg"),
     *             @OA\Property(property="path02", type="string", example="https://example.com/foto2.jpg"),
     *             @OA\Property(property="path03", type="string", example="https://example.com/foto3.jpg"),
     *             @OA\Property(property="page_id", type="integer", example=1),
     *             @OA\Property(property="hash_id", type="string", example="some_hash")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
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
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/page/{id}",
     *     tags={"Pages"},
     *     summary="Update a page",
     *     description="Update an existing page by ID",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the page to be updated",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"img_01", "img_02", "img_03", "descricao"},
     *             @OA\Property(property="img_01", type="string", format="binary"),
     *             @OA\Property(property="img_02", type="string", format="binary"),
     *             @OA\Property(property="img_03", type="string", format="binary"),
     *             @OA\Property(property="descricao", type="string", example="Updated description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Page updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Page updated successfully"),
     *             @OA\Property(property="path01", type="string", example="https://example.com/foto1.jpg"),
     *             @OA\Property(property="path02", type="string", example="https://example.com/foto2.jpg"),
     *             @OA\Property(property="path03", type="string", example="https://example.com/foto3.jpg"),
     *             @OA\Property(property="page_id", type="integer", example=1),
     *             @OA\Property(property="hash_id", type="string", example="some_hash")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'img_01' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_02' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_03' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descricao' => 'required|string|min:6|max:80',
        ]);

        $path01 = $request->file('img_01')->store('fotos', 'public');
        $path02 = $request->file('img_02')->store('fotos', 'public');
        $path03 = $request->file('img_03')->store('fotos', 'public');

        $page->update([
            'img_01' => $path01,
            'img_02' => $path02,
            'img_03' => $path03,
            'descricao' => $request->descricao,
        ]);

        return response()->json([
            'message' => 'Page updated successfully',
            'path01' => asset('storage/' . $path01),
            'path02' => asset('storage/' . $path02),
            'path03' => asset('storage/' . $path03),
            'page_id' => $page->id,
            'hash_id' => $page->hash_id
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/page/{id}",
     *     tags={"Pages"},
     *     summary="Delete a page",
     *     description="Delete an existing page by ID",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the page to be deleted",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Page deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Page deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return response()->json([
            'message' => 'Page deleted successfully'
        ], 200);
    }
}
