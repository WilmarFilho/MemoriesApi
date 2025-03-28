<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Page",
 *     title="Page",
 *     description="Modelo de uma Page",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="img_01", type="string", example="https://example.com/img_01.jpg"),
 *     @OA\Property(property="img_02", type="string", example="https://example.com/img_02.jpg"),
 *     @OA\Property(property="img_03", type="string", example="https://example.com/img_03.jpg"),
 *     @OA\Property(property="descricao", type="string", example="Declaração de amor sobre o dia que casamos ..."),
 *     @OA\Property(property="hash_id", type="integer", example=2),
 *     @OA\Property(property="user_id", type="integer", example=1)
 * )
 */

class Page extends Model
{
    protected $fillable = [
        'img_01',
        'img_02',
        'img_03',
        'descricao',
        'hash_id',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
