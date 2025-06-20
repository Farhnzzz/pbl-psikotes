<?php

namespace App\Models;

use App\Notifications\VerifyEmailQueued;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use App\Notifications\ResetPasswordQueued;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, AuthenticationLoggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailQueued);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordQueued($token));
    }

    public function exam(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function getUserType(): string
    {
        return match ($this->user_type) {
            1 => 'Patient',
            2 => 'Admin',
            3 => 'Doctor',
            default => 'Unknown',
        };
    }

    public function personal_information(): HasOne
    {
        return $this->hasOne(PersonalInformation::class);
    }

    public function amIHaveUnassignedExam(): bool
    {
        return $this->exam()->whereNull('end_time')->exists();
    }

    public function amIUnstartedExam(): bool
    {
        return $this->exam()->whereNull('start_time')->exists();
    }
    public function getUnfinishedExam(): Model|HasMany|null
    {
        $exams = $this->exam()->whereNull('end_time')->get();
        foreach ($exams as $exam) {
            if (!$exam->isExpired()) {
                return $exam;
            }
        }
        return null;
    }

    public function getLatestExam(): Model|HasMany
    {
        return $this->exam()->latest()->first();
    }

    public function isAdmin(): bool
    {
        return $this->user_type == 2;
    }

    public function isDoctor(): bool
    {
        return $this->user_type == 3;
    }

    public function isDoctorOrAdmin(): bool
    {
        return $this->isAdmin() || $this->isDoctor();
    }

    public function isPersonalInformationFullFilled(): bool
    {
        $keys = [
            'nik', 'occupation', 'birthdate', 'phone_number',
            'marital_status', 'education', 'sex'
        ];

        if($this->user_type == 2 || $this->user_type == 3){
            return true;
        }elseif ($this->personal_information == null) {
            return false;
        }else{
            foreach ($keys as $key) {
                if ($this->personal_information->$key == null) {
                    return false;
                }
            }
            return true;
        }
    }
}
