<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static user()
 * @method static static admin()
 * @method static static moderator()
 */
final class UserType extends Enum
{
    const USER = 'user';
    const ADMIN = 'admin';
    const MODERATOR = 'moderator';

}
