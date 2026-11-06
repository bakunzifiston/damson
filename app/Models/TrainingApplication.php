<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** An application to attend DAMSON mushroom farming training (submitted from the public Learning section). */
class TrainingApplication extends Model
{
    /** @var array<string, string> value => label */
    public const MODES = [
        'online' => 'Online Training',
        'on_site' => 'On-Site Training (at DAMSON MUSHROOM FARM LTD)',
    ];

    /** @var list<string> Stored as the label text so exports and the admin read naturally. */
    public const INTERESTS = [
        'Beginner Mushroom Farming',
        'Advanced Mushroom Production',
        'Mushroom Spawn Production',
        'Substrates Preparation and Tube Filling',
        'Mushroom Farming, Tube Production and DMMS',
        'Substrate Preparation and Tube Filling',
        'Commercial Mushroom Farming and Business Development',
    ];

    /** @var array<string, string> */
    public const EXPERIENCE = [
        'yes' => 'Yes',
        'no' => 'No',
        'basic' => 'I have basic knowledge',
    ];

    /** @var array<string, string> */
    public const START_PREFERENCES = [
        'asap' => 'As soon as possible',
        'within_month' => 'Within the next month',
        'flexible' => 'I am flexible to start this week',
    ];

    /** @var array<string, string> */
    public const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'accepted' => 'Accepted',
        'waitlisted' => 'Waitlisted',
        'declined' => 'Declined',
    ];

    protected $fillable = [
        'full_name', 'phone', 'email', 'district', 'training_mode', 'interests',
        'experience', 'start_preference', 'objective', 'status', 'admin_notes',
    ];

    protected function casts(): array
    {
        return ['interests' => 'array'];
    }

    public function getModeLabelAttribute(): string
    {
        return self::MODES[$this->training_mode] ?? ucfirst((string) $this->training_mode);
    }

    public function getExperienceLabelAttribute(): string
    {
        return self::EXPERIENCE[$this->experience] ?? ucfirst((string) $this->experience);
    }

    public function getStartPreferenceLabelAttribute(): string
    {
        return self::START_PREFERENCES[$this->start_preference] ?? ucfirst((string) $this->start_preference);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }

    /** Digits-only phone number, handy for a wa.me link. */
    public function getWhatsappNumberAttribute(): string
    {
        return preg_replace('/\D+/', '', $this->phone) ?? '';
    }
}
