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

namespace Agenciafmd\Articles\Models{
/**
 * @property int $id
 * @property bool $is_active
 * @property bool $star
 * @property string $title
 * @property string|null $subtitle
 * @property string|null $author
 * @property string|null $summary
 * @property string|null $content
 * @property string|null $video
 * @property int|null $published_at
 * @property array<array-key, mixed>|null $tags
 * @property string|null $image
 * @property array<array-key, mixed>|null $images
 * @property string $slug
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Agenciafmd\Articles\Database\Factories\ArticleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article isActive()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article sort()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article withoutTrashed()
 */
	final class Article extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace Agenciafmd\Banners\Models{
/**
 * @property int $id
 * @property bool $is_active
 * @property bool $star
 * @property string|null $location
 * @property string $name
 * @property array<array-key, mixed>|null $meta
 * @property string|null $link
 * @property string|null $target
 * @property int|null $published_at
 * @property int|null $until_then
 * @property string|null $desktop
 * @property string|null $notebook
 * @property string|null $mobile
 * @property string|null $video
 * @property string $slug
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Agenciafmd\Banners\Database\Factories\BannerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereNotebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereUntilThen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner withoutTrashed()
 */
	final class Banner extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace Agenciafmd\BigNumbers\Models{
/**
 * @property int $id
 * @property bool $is_active
 * @property string $big_number
 * @property string $description
 * @property int|null $sort
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Agenciafmd\BigNumbers\Database\Factories\BigNumberFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber isActive()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber sort()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber whereBigNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BigNumber withoutTrashed()
 */
	final class BigNumber extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace Agenciafmd\Faqs\Models{
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Agenciafmd\Faqs\Database\Factories\FaqFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq withoutTrashed()
 */
	final class Faq extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace Agenciafmd\HttpLogs\Models{
/**
 * @property int $id
 * @property string $url
 * @property string $method
 * @property array<array-key, mixed>|null $request_headers
 * @property array<array-key, mixed>|null $request_body
 * @property int|null $status
 * @property array<array-key, mixed>|null $response_headers
 * @property array<array-key, mixed>|null $response_body
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Agenciafmd\HttpLogs\Database\Factories\HttpLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog whereRequestBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog whereRequestHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog whereResponseBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog whereResponseHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HttpLog whereUrl($value)
 */
	final class HttpLog extends \Eloquent {}
}

namespace Agenciafmd\Leads\Models{
/**
 * @property int $id
 * @property bool $is_active
 * @property string|null $source
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $description
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Agenciafmd\Leads\Database\Factories\LeadFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead withoutTrashed()
 */
	final class Lead extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace Agenciafmd\Partners\Models{
/**
 * @property int $id
 * @property bool $is_active
 * @property bool $star
 * @property string $name
 * @property string|null $description
 * @property string|null $url
 * @property string|null $image
 * @property string $slug
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Agenciafmd\Partners\Database\Factories\PartnerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner isActive()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner sort()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner withoutTrashed()
 */
	final class Partner extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
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

namespace Agenciafmd\Redirects\Models{
/**
 * @property int $id
 * @property bool $is_active
 * @property string $from
 * @property string $to
 * @property string $type
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Agenciafmd\Redirects\Database\Factories\RedirectFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect isActive()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Redirect withoutTrashed()
 */
	final class Redirect extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace Agenciafmd\Testimonials\Models{
/**
 * @property int $id
 * @property bool $is_active
 * @property bool $star
 * @property string $name
 * @property string|null $short_description
 * @property string|null $description
 * @property string|null $video
 * @property string|null $image
 * @property string $slug
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Agenciafmd\Testimonials\Database\Factories\TestimonialFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial withoutTrashed()
 */
	final class Testimonial extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

