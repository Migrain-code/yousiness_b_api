<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Email
 *
 * @property int $id
 * @property string $code
 * @property string $subject
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Email newModelQuery()
 * @method static Builder|Email newQuery()
 * @method static Builder|Email query()
 * @method static Builder|Email whereCode($value)
 * @method static Builder|Email whereContent($value)
 * @method static Builder|Email whereCreatedAt($value)
 * @method static Builder|Email whereId($value)
 * @method static Builder|Email whereSubject($value)
 * @method static Builder|Email whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Email extends Model
{
    use HasFactory;
}
