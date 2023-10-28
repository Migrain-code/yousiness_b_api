<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Sponsor
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $link
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Sponsor newModelQuery()
 * @method static Builder|Sponsor newQuery()
 * @method static Builder|Sponsor query()
 * @method static Builder|Sponsor whereCreatedAt($value)
 * @method static Builder|Sponsor whereId($value)
 * @method static Builder|Sponsor whereImage($value)
 * @method static Builder|Sponsor whereLink($value)
 * @method static Builder|Sponsor whereName($value)
 * @method static Builder|Sponsor whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Sponsor extends Model
{
    use HasFactory;
}
