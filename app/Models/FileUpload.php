<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $fillable = [
        'user_id',
        'date_submitted',
        'selected_months',
        'report_year',
        'municipality',
        'file_path',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
