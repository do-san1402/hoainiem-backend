<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum DateFormatEnum: string
{
    /**
     * DATE FORMAT NAMING STANDARD
     *
     * YY = 2 digit year
     * YYYY = 4 digit year
     * MM = 2 digit month
     * DD = 2 digit day
     * DS = day without leading zero + english ordinal suffix for the day of the month, 2 characters
     * WD = 3 letters week day
     * HH = 24-hour format of an hour (00 to 23)
     * H = 12-hour format of an hour (01 to 12)
     * I = Minutes with leading zeros (00 to 59)
     * S = 2 digit seconds
     * FM = Full month in english
     * SM = Short textual representation of a month, three letters
     * AA = Uppercase Ante meridiem and Post meridiem (AM / PM)
     * A = Lowercase Ante meridiem and Post meridiem (am / pm)
     * JS = Used for javascript
     */

    use EnumToArray;

    case YYYY_MM_DD    = "Y-m-d";
    case MM_DD_YYYY    = "m/d/Y";
    case JS_MM_DD_YYYY = "mm/dd/yyyy";
    case H_I_AA        = "h:i A";
    case YY_MM_DD_HH_I = "ymd-Hi";
}
