<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Event"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", maxLength=32, example="John"),
 * @OA\Property(property="city", type="string", maxLength=32, example="ikeja"),
 * @OA\Property(property="country", type="string", maxLength=32, example="Nigeria"),
 * @OA\Property(property="startDate", format="date-time"),
 * @OA\Property(property="endDate", format="date-time"),
 * )
 * Class User
 *
 */

 
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "city",
        "country",
        "startDate",
        "endDate"
    ];

    public $timestamps = false;
}
