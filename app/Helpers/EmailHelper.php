<?php

namespace App\Helpers;

class EmailHelper
{
    public static function parseList($value)
    {
        if (empty($value)) {
            return array();
        }

        // Convert comma-separated string into array
        $emails = is_array($value) ? $value : explode(',', $value);

        $cleaned = array();

        foreach ($emails as $email) {
            $email = trim($email);

            if (!empty($email)) {
                $cleaned[] = $email;
            }
        }

        return array_values($cleaned);
    }
}
