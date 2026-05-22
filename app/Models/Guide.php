<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Guide extends Model
{
    use HasFactory;

    public const GENDER_MALE = 'male';

    public const GENDER_FEMALE = 'female';

    public const GENDER_OTHER = 'other';

    public const STATUS_AVAILABLE = 'available';

    public const STATUS_BUSY = 'busy';

    public const STATUS_INACTIVE = 'inactive';

    public const UPDATED_AT = null;

    protected $fillable = [
        'full_name',
        'gender',
        'phone',
        'email',
        'address',
        'experience_years',
        'description',
        'price_per_day',
        'avatar',
        'status',
    ];

    protected $casts = [
        'experience_years' => 'integer',
        'price_per_day' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'guide_languages');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'guide_locations');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function scopeForPublic($query)
    {
        return $query->whereIn('status', [self::STATUS_AVAILABLE, self::STATUS_BUSY]);
    }

    public function genderLabel(): ?string
    {
        return match ($this->gender) {
            self::GENDER_MALE => 'Nam',
            self::GENDER_FEMALE => 'Nữ',
            self::GENDER_OTHER => 'Khác',
            default => null,
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE => 'Sẵn sàng',
            self::STATUS_BUSY => 'Đang bận',
            self::STATUS_INACTIVE => 'Ngừng hoạt động',
            default => $this->status,
        };
    }

    public function canBeBooked(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function avatarUrl(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return Storage::url($this->avatar);
        }

        return '';
    }
}
