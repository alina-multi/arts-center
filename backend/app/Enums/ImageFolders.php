<?php

namespace App\Enums;

enum ImageFolders: string
{
    case Works = "works";
    case Photos = "photos";
    case Grids = "grids";
    case Preview = "preview";
    // todo: get rid of this and move to gridS
    case Grid = "grid";
    case Posts = "posts";
}
