<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;

class egac extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'qualification_id',
        'region_name',
        'institution_name',
        'NameOfTrainer',
        'targetStart',
        'targetEnd',
        'Remarks',
        'NTTCNumber',
        'enrolled_female',
        'enrolled_male',
        'graduate_female',
        'graduate_male',
        'assessed_female',
        'assessed_male',
        'completers_female',
        'completers_male',
        'TrainingStatus',
    ]; 

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
            return $this->BelongsTo(Qualification::class);
        }

    public function request():BelongsTo
        {
            return $this->BelongsTo(Request::class);
        }

}
