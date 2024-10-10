<?php

namespace App\Models;

use CodeIgniter\Model;

class Student extends Model
{

    protected $table='students';
    protected $primaryKey='id';
    protected $useAutoIncrement='id';
    protected $allowedFields=[
     'name','email','course','phone'
    ];
}