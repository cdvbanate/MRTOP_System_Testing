<?php

namespace App\Models;

use App\Mail\MRTOP;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

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

        public function qualification()
        {
            return $this->belongsTo(Qualification::class);
        }
        

        public function egacs()
        {
            return $this->hasMany(Egac::class);
        }

        


        protected static function booted()
        {
            // Trigger email on creation
            static::created(function ($request) {
                Log::info('New request created', ['request_id' => $request->id]);
        
                // Get the user associated with the request
                $user = User::find($request->user_id);
        
                // Send email to the user who created the request
                if ($user) {
                    Mail::to($user->email)->send(new MRTOP($request, $user));
                    Log::info('Email sent on creation to user', ['email' => $user->email]);
                } else {
                    Log::info('Email not sent on creation: User not found');
                }
            });
        
        
            // Trigger email on update
            static::updated(function ($request) {
                Log::info('Request status updated', ['request_id' => $request->id]);
        
                // Get the user associated with the request
                $user = User::find($request->user_id);
        
                // Check if the RequestStatus was changed
                if ($request->isDirty('RequestStatus')) {
                    $originalStatus = $request->getOriginal('RequestStatus'); // Original status before update
                    $newStatus = $request->RequestStatus; // New status after update
        
                    Log::info('Request status changed', ['original_status' => $originalStatus, 'new_status' => $newStatus]);
        
                    // Send email based on status change
                    if ($originalStatus !== $newStatus && $user) {
                        Mail::to($user->email)->send(new MRTOP($request, $user));
                        Log::info('Email sent on update to user', ['email' => $user->email]);
                    } else {
                        Log::info('No status change detected or user not found, no email sent');
                    }
                } else {
                    Log::info('RequestStatus not dirty, no email sent');
                }
            });
        }
    }
