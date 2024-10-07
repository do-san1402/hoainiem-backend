<?php

namespace App\Enums;

enum AssetsFolderEnum: string {
    case PUBLIC_ASSETS   = "assets";
    case STORAGE_ASSETS  = "storage";
    case UPLOAD_ROOT_DIR = "public";

}
