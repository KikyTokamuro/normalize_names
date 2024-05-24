<?php

declare(strict_types=1);

namespace Kikyt\NormalizeNames\Bitrix24;

class Utils {
    public static function normalizeContact(array $contact): array {
        $nameParts = explode(' ', $contact['NAME']);

        if (count($nameParts) > 1) {
            $contact['SECOND_NAME'] = array_pop($nameParts);
            $contact['NAME'] = implode(' ', $nameParts);
        }

        return $contact;
    }
}