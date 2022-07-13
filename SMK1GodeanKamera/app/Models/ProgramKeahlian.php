<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKeahlian extends Model
{
    use HasFactory;
    protected $table = 'program_keahlian';
    protected $fillable = [
    'nama_program'
    ];
}
