<?php

namespace App\Models;

use App\Actions\Utils\GetCurrentLocale;
use App\Notifications\ResetPasswordQueued;
use App\Notifications\VerifyEmailQueued;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $locale
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Connection> $Connections
 * @property-read int|null $connections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $Likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserNotificationPreferences> $NotificationPreferences
 * @property-read int|null $notification_preferences_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Skin> $Skins
 * @property-read int|null $skins_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UnityLike> $UnityLikes
 * @property-read int|null $unity_likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UnitySkin> $UnitySkins
 * @property-read int|null $unity_skins_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HavenBag> $havenBags
 * @property-read int|null $haven_bags_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'locale',
        'selected_reward_image',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailQueued((new GetCurrentLocale)()));
    }

    /**
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $url = route('password.reset', [
            'token' => $token,
            'email' => $this->getEmailForPasswordReset(),
        ]);
        $this->notify(new ResetPasswordQueued($url));
    }

    /**
     * @return BelongsToMany<Role>
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return string[]
     */
    public function rolesName()
    {
        return $this->roles->pluck('name')->toArray();
    }

    /**
     * @param  string|string[]  $roles
     */
    public function hasRole(string|array $roles): bool
    {
        $roles = (array) $roles;

        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * @return HasMany<Skin>
     */
    public function Skins()
    {
        return $this->hasMany(Skin::class);
    }

    /**
     * @return HasMany<UnitySkin>
     */
    public function UnitySkins()
    {
        return $this->hasMany(UnitySkin::class);
    }

    /**
     * @return HasMany<Connection>
     */
    public function Connections()
    {
        return $this->hasMany(Connection::class);
    }

    /**
     * @return HasMany<UserNotificationPreferences>
     */
    public function NotificationPreferences()
    {
        return $this->hasMany(UserNotificationPreferences::class);
    }

    /**
     * @return HasMany<Like>
     */
    public function Likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * @return HasMany<UnityLike>
     */
    public function UnityLikes()
    {
        return $this->hasMany(UnityLike::class);
    }

    /**
     * @return MorphMany<DatabaseNotification>
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable');
    }

    /**
     * @return HasMany<HavenBag>
     */
    public function havenBags()
    {
        return $this->hasMany(HavenBag::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Vérifie si la récompense sélectionnée par l'utilisateur est encore valide
     *
     * @return bool
     */
    public function hasValidSelectedReward(): bool
    {
        if (!$this->selected_reward_image) {
            return false;
        }

        // Vérifier si le fichier existe (convertir le chemin /storage/ vers le path relatif)
        $filePath = str_replace('/storage/', '', $this->selected_reward_image);
        if (!Storage::disk('public')->exists($filePath)) {
            return false;
        }

        // Vérifier si la récompense est encore dans la liste actuelle
        $rewardsPath = storage_path('app/json/rewards.json');
        if (!File::exists($rewardsPath)) {
            return false;
        }

        $rewardsData = json_decode(File::get($rewardsPath), true);
        $rewards = $rewardsData['rewards'] ?? [];

        foreach ($rewards as $reward) {
            if (isset($reward['image']) && $reward['image'] === $this->selected_reward_image) {
                return true;
            }
        }

        return false;
    }

    /**
     * Récupère les données complètes de la récompense sélectionnée
     *
     * @return array|null
     */
    public function getSelectedRewardData(): ?array
    {
        if (!$this->hasValidSelectedReward()) {
            return null;
        }

        $rewardsPath = storage_path('app/json/rewards.json');
        $rewardsData = json_decode(File::get($rewardsPath), true);
        $rewards = $rewardsData['rewards'] ?? [];

        foreach ($rewards as $index => $reward) {
            if (isset($reward['image']) && $reward['image'] === $this->selected_reward_image) {
                return array_merge($reward, ['index' => $index]);
            }
        }

        return null;
    }
}
