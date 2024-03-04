<?php

namespace App\Enums;

enum NotificationTypes: int
{
    // Site stuff
    case SiteNews = 1;

    // Featured/recommended content
    case FeaturedPosts = 20;

    // My content
    case MyContentComment = 40;
    case MyContentVote = 41;

    // Subscriptions
    case SubscriptionPost = 60;
    case SubscriptionWork = 61;

}
