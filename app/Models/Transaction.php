<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['date' => 'date'];

    const STATUSES = [
        'success' => 'Success',
        'failed' => 'Failed',
        'processing' => 'Proceessing',
    ];

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
