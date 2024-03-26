<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DOpsModel extends Model
{
    use HasFactory;

    protected $table = 'd_ops';
    protected $guarded = [];

    public function upsertData($req)
    {
        return $this->updateOrCreate(
            ['id' => $req['id'] ?? null],
            $req
        );
    }
}
