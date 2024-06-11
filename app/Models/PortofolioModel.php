<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortofolioModel extends Model
{
    use HasFactory;
    protected $table = 'port';
    protected $fillable = ['foto', 'judul', 'isi', 'link'];
}
