<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

use Illuminate\Support\Facades\Storage;

class Team extends JetstreamTeam
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'personal_team',
        'logo_path',
        'brn',
        'phone',
        'fax',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }
    
    public function getLogoUrlAttribute()
    {
        if ($this->logo_path) {
            return Storage::disk('public')->url($this->logo_path);
        }

        return $this->defaultLogoUrl();
    }

    protected function defaultLogoUrl()
    {
        // 팀 이름에서 이니셜 추출
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        // ui-avatars.com API 이용
        return 'https://ui-avatars.com/api/?name='
            .urlencode($name)
            .'&color=7F9CF5&background=EBF4FF';
    }
    public function address_detail()
    {
        return $this->hasOne(AddressDetail::class);
    }
    public function getFullAddressAttribute()
    {
        if ($this->address_detail && $this->address_detail->extra_address) {
            $extraAddress = $this->address_detail->extra_address;
            $road = $extraAddress->road;
            $city = $road->city;
            $state = $city->state;

            return sprintf(
                '%s %s %s %s, %s',
                $state->name,
                $city->name,
                $road->name,
                $extraAddress->extra_address,
                $this->address_detail->details
            );
        }

        return null;
    }
}
