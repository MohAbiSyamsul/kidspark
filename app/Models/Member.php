<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use Notifiable;

    protected $table = 'members';
    protected $primaryKey = 'id_member';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'no_telepon',
        'no_member',
        'tier',
        'total_kunjungan',
        'total_belanja',
        'is_active',
        'foto',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'total_belanja' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Tier thresholds (berdasarkan total kunjungan)
     */
    public static array $tierLevels = [
        'Bronze'   => ['min' => 0,  'max' => 4,   'color' => '#cd7f32', 'icon' => '🥉', 'disc' => 0],
        'Silver'   => ['min' => 5,  'max' => 14,  'color' => '#9e9e9e', 'icon' => '🥈', 'disc' => 5],
        'Gold'     => ['min' => 15, 'max' => 29,  'color' => '#FFD700', 'icon' => '🥇', 'disc' => 10],
        'Platinum' => ['min' => 30, 'max' => PHP_INT_MAX, 'color' => '#4ECDC4', 'icon' => '💎', 'disc' => 15],
    ];

    /**
     * Compute tier label based on total_kunjungan.
     */
    public static function computeTier(int $kunjungan): string
    {
        foreach (array_reverse(self::$tierLevels, true) as $tier => $info) {
            if ($kunjungan >= $info['min']) {
                return $tier;
            }
        }
        return 'Bronze';
    }

    /**
     * Generate no_member (e.g. KP-M-00001)
     */
    public static function generateNoMember(): string
    {
        $last = static::max('id_member') ?? 0;
        return 'KP-M-' . str_pad($last + 1, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Discount percentage for this member's tier.
     */
    public function getDiskonAttribute(): int
    {
        return self::$tierLevels[$this->tier]['disc'] ?? 0;
    }

    /**
     * Progress to next tier (percentage).
     */
    public function getTierProgressAttribute(): array
    {
        $info = self::$tierLevels[$this->tier];
        $kunjungan = $this->total_kunjungan;

        if ($this->tier === 'Platinum') {
            return ['percent' => 100, 'next' => null, 'remaining' => 0];
        }

        $tiers = array_keys(self::$tierLevels);
        $nextTierKey = $tiers[array_search($this->tier, $tiers) + 1] ?? null;

        if (!$nextTierKey) {
            return ['percent' => 100, 'next' => null, 'remaining' => 0];
        }

        $nextMin = self::$tierLevels[$nextTierKey]['min'];
        $curMin  = $info['min'];
        $span    = $nextMin - $curMin;
        $done    = $kunjungan - $curMin;
        $percent = $span > 0 ? min(100, (int)(($done / $span) * 100)) : 100;

        return [
            'percent'   => $percent,
            'next'      => $nextTierKey,
            'remaining' => max(0, $nextMin - $kunjungan),
        ];
    }

    public function pesanan()
    {
        return $this->hasMany(PesananTiket::class, 'id_member', 'id_member');
    }
}
