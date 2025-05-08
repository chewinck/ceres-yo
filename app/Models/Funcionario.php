<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    //

    protected $table = 'funcionarios';
    protected $primaryKey = 'id';
    protected $fillable = [
        'dependencia',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
