<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $is_active
 * @property string|null $type
 * @property string $name
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $api_token
 * @property string|null $avatar
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	final class User extends \Eloquent {}
}

namespace Agenciafmd\Admix\Models{
/**
 * @property int $id
 * @property bool $is_active
 * @property string|null $type
 * @property string $name
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $api_token
 * @property string|null $avatar
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Agenciafmd\Admix\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 */
	final class User extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable, \Filament\Models\Contracts\FilamentUser, \Filament\Models\Contracts\HasAvatar, \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace Agenciafmd\Postal\Models{
/**
 * @property int $id
 * @property bool $is_active
 * @property string $name
 * @property string $to
 * @property string $to_name
 * @property string $subject
 * @property array<array-key, mixed>|null $cc
 * @property array<array-key, mixed>|null $bcc
 * @property string $slug
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Agenciafmd\Postal\Database\Factories\PostalFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereBcc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereCc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereToName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Postal withoutTrashed()
 */
	final class Postal extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

