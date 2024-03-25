<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected $fillable = [
        'user_id',
        'qualification_id',
        'region_name',
        'province_name',
        'institution_name',
        'withExistingTOPcourse',
        'targetStart',
        'targetEnd',
        'NameOfTrainer',
        'NTTCNumber',
        'contactNumber',
        'emailAddress',
        'Attachment',
        'RequestStatus',
        'TrainingStatus',
        'Remarks',]; 
    
        public function user():BelongsTo
        {
            return $this->BelongsTo(User::class);
        }

        public function qualification():BelongsTo
        {
            return $this->belongsTo(Qualification::class);
        }
    
}
