<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Pages",
 *     description="Páginas"
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
     *     summary="Lista de páginas a partir do hash do usuário",
     *     description="Retorna todas as páginas do usuário com o hash_id",
     *     @OA\Parameter(
     *         name="hash",
     *         in="path",
     *         description="Hash ID associado ao usuário",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista das Páginas",
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
        $validatedHash = filter_var($hash, FILTER_SANITIZE_STRING);
        $pages = Page::where('hash_id', $validatedHash)->get();

        return response()->json($pages);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/page/novo",
     *     tags={"Pages"},
     *     summary="Cria uma nova página",
     *     description="Salva uma nova página do usuário",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *              required={"img_01", "img_02", "img_03", "descricao"},
     *              @OA\Property(property="img_01", type="string", format="binary"),
     *              @OA\Property(property="img_02", type="string", format="binary"),
     *              @OA\Property(property="img_03", type="string", format="binary"),
     *              @OA\Property(property="descricao", type="string", example="Descrição da página")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Página criada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Fotos enviadas com sucesso!"),
     *             @OA\Property(property="path01", type="string", example="https://example.com/foto1.jpg"),
     *             @OA\Property(property="path02", type="string", example="https://example.com/foto2.jpg"),
     *             @OA\Property(property="path03", type="string", example="https://example.com/foto3.jpg"),
     *             @OA\Property(property="page_id", type="integer", example=1),
     *             @OA\Property(property="hash_id", type="string", example="4243242erwr")
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
            'img_01' => 'storage/' . $path01,
            'img_02' => 'storage/' . $path02,
            'img_03' => 'storage/' . $path03,
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
     * @OA\Post(
     *     path="/api/page/{id}",
     *     tags={"Pages"},
     *     summary="Atualiza a página",
     *     description="Atualiza uma página com o id",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da página a ser atualizada",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *              required={"img_01", "img_02", "img_03", "descricao"},
     *              @OA\Property(property="img_01", type="string", format="binary"),
     *              @OA\Property(property="img_02", type="string", format="binary"),
     *              @OA\Property(property="img_03", type="string", format="binary"),
     *              @OA\Property(property="descricao", type="string", example="Nesse fizemos nossa primeira ...")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Página atualizada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Página atualizada com sucesso"),
     *             @OA\Property(property="path01", type="string", example="https://example.com/foto1.jpg"),
     *             @OA\Property(property="path02", type="string", example="https://example.com/foto2.jpg"),
     *             @OA\Property(property="path03", type="string", example="https://example.com/foto3.jpg"),
     *             @OA\Property(property="page_id", type="integer", example=1),
     *             @OA\Property(property="hash_id", type="string", example="42523425234")
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
        $user = auth()->user();
        $page = Page::where('id', $id)->where('user_id', $user->id)->first();

        if (!$page) {
            return response()->json(['message' => 'Página não encontrada ou não pertence a você'], 403);
        }

        $request->validate([
            'img_01' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_02' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_03' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descricao' => 'required|string|min:6|max:80',
        ]);

        if ($request->hasFile('img_01')) {
            $path01 = $request->file('img_01')->store('fotos', 'public');
            $page->img_01 = 'storage/' . $path01;
        }

        if ($request->hasFile('img_02')) {
            $path02 = $request->file('img_02')->store('fotos', 'public');
            $page->img_02 = 'storage/' . $path02;
        }

        if ($request->hasFile('img_03')) {
            $path03 = $request->file('img_03')->store('fotos', 'public');
            $page->img_03 = 'storage/' . $path03;
        }

        $page->descricao = $request->descricao;
        $page->save();

        return response()->json([
            'message' => 'Página atualizada com sucesso',
            'page' => $page
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/page/{id}",
     *     tags={"Pages"},
     *     summary="Deleta página",
     *     description="Deleta página a partir do id",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da página para ser deletada",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Página deletada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Página deletada com sucesso")
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
        $user = auth()->user();
        $page = Page::where('id', $id)->where('user_id', $user->id)->first();

        if (!$page) {
            return response()->json(['message' => 'Página não encontrada ou não pertence a você'], 403);
        }

        $page->delete();

        return response()->json(['message' => 'Página deletada com sucesso']);
    }

}
