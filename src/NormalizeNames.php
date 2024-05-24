<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Kikyt\NormalizeNames\Cli\Arguments;
use Kikyt\NormalizeNames\Bitrix24\Utils;
use App\Bitrix24\Bitrix24API;

// Parse cli arguments
$parser = new Arguments();
$parser->parseOptions();

// Create API client
$bx24 = new Bitrix24API($parser->getUrl());

// Get contacts
$contacts = [];
try {
    $contactsGenerator = $bx24->fetchContactList([], ['ID', 'NAME', 'SECOND_NAME', 'LAST_NAME']);
    foreach ($contactsGenerator as $contact) {
        if (empty($contacts)) {
            $contacts = $contact;
        } else {
            $contacts[] = $contact;
        }
    }
} catch (Bitrix24APIException $e) {
    printf('Error (%d): %s\n', $e->getCode(), $e->getMessage());
    exit(1);
}

// Check contacts
if (empty($contacts)) {
    printf('Contacts not found...');
    exit(1);
}

// Normalize contacts
$normalizedContacts = array_map([Utils::class, 'normalizeContact'], $contacts);

// Update contacts
try {
    $bx24->updateContacts($normalizedContacts);
} catch (Bitrix24APIException $e) {
    printf('Error (%d): %s\n', $e->getCode(), $e->getMessage());
    exit(1);
}