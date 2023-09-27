<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['date' => 'date'];

    public function getStatusColorAttribute(){

        return [
            'processing' => 'gray',
            'success' => 'green',
            'failed' => 'red',
        ][$this->status] ?? 'gray';

    }

    public function getDateForHumansAttribute(){
        return $this->date->format('M, d Y');
    }

}
