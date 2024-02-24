<?php

namespace App\Enums;

enum NotificationTypes: int
{
    // Site stuff
    case SiteNews = 1;
    case SiteMarketing = 2;

    // Featured/recommended content
    case FeaturedPosts = 20;
    case FeaturedWorks = 21;

    // My content
    case MyContentComment = 40;
    case MyContentLike = 41;

    // Subscriptions
    case SubscriptionPost = 60;
    case SubscriptionWork = 61;

}
