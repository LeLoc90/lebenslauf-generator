<?php

namespace App\Service;

use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Tuupola\Base32;

class IDService
{
    public static function makeUUID(DateTimeInterface $date = null): UuidInterface {
        return $uuid = Uuid::uuid7($date);
    }

    public static function MakeULID(DateTimeInterface $date = null): string {
        return self::UUIDtoULID(self::makeUUID($date));
    }

    public static function UUIDtoULID(UuidInterface $uuid): string {
        $encoder = self::initEncoder();
        // First, we must pad the 16-byte string to 20 bytes
        // for proper conversion without data loss.
        $bytes = str_pad($uuid->getBytes(), 20, "\x00", STR_PAD_LEFT);

        // Use Crockford's Base 32 encoding algorithm.
        $encoded = $encoder->encode($bytes);

        // That 20-byte string was encoded to 32 characters to avoid loss
        // of data. We must strip off the first 6 characters--which are
        // all zeros--to get a valid 26-character ULID string.
        $ulid = substr($encoded, 6);

        return $ulid;
    }

    public static function ULIDtoUUID(string $ulid): UuidInterface {
        $encoder = self::initEncoder();
        // We stripped all leading 0s in the encoding, so
        // time to add them back to avoid data loss
        $decoded = $encoder->decode('000000'.$ulid);

        // After decoding we now must remove the padding we added,
        // so we get out orignal 16-byte uuid back
        $uuid = Uuid::fromBytes(substr($decoded, 4));
        return $uuid;
    }

    private static function initEncoder(): Base32 {
        return new Base32([
            'characters' => Base32::CROCKFORD,
            'padding' => false,
            'crockford' => true,
        ]);
    }
}