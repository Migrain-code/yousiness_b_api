<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property string|null $icon
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Menu newModelQuery()
 * @method static Builder|Menu newQuery()
 * @method static Builder|Menu query()
 * @method static Builder|Menu whereCreatedAt($value)
 * @method static Builder|Menu whereIcon($value)
 * @method static Builder|Menu whereId($value)
 * @method static Builder|Menu whereName($value)
 * @method static Builder|Menu whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Page[] $pages
 * @property-read int|null $pages_count
 */
class Menu extends Model
{
    use HasFactory;

    public function pages()
    {
        return $this->hasMany(Page::class, 'menu_id', 'id');
    }
}
