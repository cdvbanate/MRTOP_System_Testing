<?php

namespace App\Models;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request extends Model
{
    use HasFactory;
    use LogsActivity;

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


        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
            ->logOnly($this->fillable);
            // Chain fluent methods for configuration options
        }
    
        public function user():BelongsTo
        {
            return $this->BelongsTo(User::class);
        }

        public function qualification():BelongsTo
        {
            return $this->belongsTo(Qualification::class);
        }
    
}
