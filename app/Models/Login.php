<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = "login";
    protected $fillable = [];

    public function process(array $data)
    {
        dd($data);
    }
}