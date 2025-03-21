<?php

namespace App\Enums;

enum UserIntents: string
{
    case ExploreArt = 'explore_art';
    case ShowcaseArt = 'showcase_art';
    case PromoteArt = 'promote_art';
    case Networking = 'networking';
    case BecomePatron = 'become_patron';
    case CreateArtSpace = 'create_art_space';
}
