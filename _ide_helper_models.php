<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Blacklist
 *
 * @property int $id
 * @property int $user_id
 * @property int $blacklist_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $blacklist
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\BlacklistFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Blacklist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blacklist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blacklist query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blacklist whereBlacklistUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blacklist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blacklist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blacklist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blacklist whereUserId($value)
 */
	class Blacklist extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Blog
 *
 * @property int $id
 * @property int $featured
 * @property int|null $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $owners
 * @property-read int|null $owners_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BlogTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Database\Factories\BlogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog withoutTrashed()
 */
	class Blog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BlogTranslation
 *
 * @property int $id
 * @property int $blog_id
 * @property string $language
 * @property string $title
 * @property array $about
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\BlogTranslationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation withoutTrashed()
 */
	class BlogTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $commentable_id
 * @property string $commentable_type
 * @property array $body
 * @property string|null $text
 * @property int|null $comment_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $depth
 * @property int $rating
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read Comment|null $parent
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vote> $votes
 * @property-read int|null $votes_count
 * @method static \Database\Factories\CommentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment withoutTrashed()
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Feed
 *
 * @property int $id
 * @property int $feedable_id
 * @property string $feedable_type
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $feedable
 * @property-read mixed $comment
 * @property-read mixed $work
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\FeedFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Feed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereFeedableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereFeedableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereUserId($value)
 */
	class Feed extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Feedback
 *
 * @property int $id
 * @property int $rating
 * @property int $comments
 * @property int $user_id
 * @property string|null $category
 * @property array|null $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $title
 * @property string $type
 * @property string $language
 * @property string|null $feedbackable_type
 * @property string|null $feedbackable_id
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Nova\Actions\ActionEvent> $actions
 * @property-read int|null $actions_count
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vote> $votes
 * @property-read int|null $votes_count
 * @method static \Database\Factories\FeedbackFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereFeedbackableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereFeedbackableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUserId($value)
 */
	class Feedback extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Follow
 *
 * @property int $id
 * @property int $user_id
 * @property string $followable_type
 * @property int $followable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $followable
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\FollowFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow query()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereFollowableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereFollowableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereUserId($value)
 */
	class Follow extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int|null $work_id
 * @property int|null $old_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $folder
 * @property int $w300
 * @property int $w600
 * @property int $w1200
 * @property int $w2400
 * @property string $extension
 * @property-read mixed $original
 * @property-read mixed $path
 * @property-read mixed $src
 * @property-read mixed $srcset
 * @method static \Database\Factories\ImageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereOldUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereW1200($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereW2400($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereW300($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereW600($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereWorkId($value)
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ImageVariant
 *
 * @property int $id
 * @property int $image_id
 * @property string $folder
 * @property string $extension
 * @property int $width
 * @property int $height
 * @property int $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant whereFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageVariant whereWidth($value)
 */
	class ImageVariant extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $blog_id
 * @property int|null $rating
 * @property int|null $comments
 * @property \App\Models\Carbon $published_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Blog|null $blog
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post unpublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post withoutTrashed()
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostTranslation
 *
 * @property int $id
 * @property int $post_id
 * @property string $language
 * @property string $title
 * @property array $body
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PostTranslationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation withoutTrashed()
 */
	class PostTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property int|null $count
 * @property int|null $group_id
 * @property int $groups_main
 * @property int $type_id
 * @property int $old_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TagTitle> $titles
 * @property-read int|null $titles_count
 * @method static \Database\Factories\TagFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereGroupsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereOldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTypeId($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TagGroup
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup whereUpdatedAt($value)
 */
	class TagGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TagTitle
 *
 * @property int $id
 * @property int $tag_id
 * @property string $language
 * @property string $title
 * @property-read \App\Models\Tag|null $tag
 * @method static \Database\Factories\TagTitleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TagTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TagTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TagTitle query()
 * @method static \Illuminate\Database\Eloquent\Builder|TagTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagTitle whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagTitle whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagTitle whereTitle($value)
 */
	class TagTitle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TagType
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $max_tags
 * @property int $allow_user_input
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TagType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TagType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TagType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TagType whereAllowUserInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagType whereMaxTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagType whereUpdatedAt($value)
 */
	class TagType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $username
 * @property int|null $old_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property int|null $image_id
 * @property string|null $country
 * @property int $rating
 * @property-read \App\Models\Image|null $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserBio> $bios
 * @property-read int|null $bios_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Blacklist> $blacklists
 * @property-read int|null $blacklists_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Feed> $feeds
 * @property-read int|null $feeds_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Follow> $follows
 * @property-read int|null $follows_count
 * @property-read mixed $highlights
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Image|null $photo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserRatings> $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Work> $works
 * @property-read int|null $works_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserBio
 *
 * @property int $id
 * @property int $user_id
 * @property string $language
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserBioFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserBio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBio query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBio whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBio whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBio whereUserId($value)
 */
	class UserBio extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserRatings
 *
 * @property int $id
 * @property string $ratable_type
 * @property int $ratable_id
 * @property int $rating
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $language
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $ratable
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\UserRatingsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings whereRatableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings whereRatableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRatings whereUserId($value)
 */
	class UserRatings extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Vote
 *
 * @property int $id
 * @property string $votable_type
 * @property int $votable_id
 * @property int $user_id
 * @property string $ip
 * @property int $vote
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\VoteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Vote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereVotableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereVotableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereVote($value)
 */
	class Vote extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Work
 *
 * @property int $id
 * @property int $image_id
 * @property int $rating
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property int $hosts
 * @property int $price
 * @property int|null $old_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Carbon $published_at
 * @property int $show_en
 * @property int $show_ru
 * @property int $show_uk
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkBlock> $blocks
 * @property-read int|null $blocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $category
 * @property-read int|null $category_count
 * @property-read int|null $comments_count
 * @property-read \App\Models\WorkDetails|null $details
 * @property-read mixed $title
 * @property-read \App\Models\Image|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $owners
 * @property-read int|null $owners_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkTitle> $titles
 * @property-read int|null $titles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vote> $votes
 * @property-read int|null $votes_count
 * @method static \Database\Factories\WorkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Work newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Work published()
 * @method static \Illuminate\Database\Eloquent\Builder|Work query()
 * @method static \Illuminate\Database\Eloquent\Builder|Work unpublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereHosts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereOldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereShowEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereShowRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereShowUk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Work withoutTrashed()
 */
	class Work extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WorkBlock
 *
 * @property int $id
 * @property int $work_id
 * @property string $language
 * @property string $type
 * @property int $order
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Work|null $work
 * @method static \Database\Factories\WorkBlockFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkBlock whereWorkId($value)
 */
	class WorkBlock extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WorkDetails
 *
 * @property int $id
 * @property int $work_id
 * @property string|null $year
 * @property int|null $width
 * @property int|null $height
 * @property int|null $length
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Work|null $work
 * @method static \Database\Factories\WorkDetailsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails whereWorkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetails whereYear($value)
 */
	class WorkDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WorkTitle
 *
 * @property int $id
 * @property int $work_id
 * @property string $language
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Work|null $work
 * @method static \Database\Factories\WorkTitleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereWorkId($value)
 */
	class WorkTitle extends \Eloquent {}
}

