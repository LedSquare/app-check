<?php
namespace Aspect\Models;

use App\Models\User;
use Aspect\Interfaces\Units\AspectUnitInterface;
use Aspect\Units\AspectV1Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Fields
 * @property int $id
 * @property int $user_id
 * @property int $type_id
 * @property boolean $isEnded
 * @property \Aspect\Interfaces\Units\AspectUnitInterface $aspect_unit
 * @property \App\Models\User $user
 *
 * Realtions
 * @property \Aspect\Models\AspectType $type
 *
 * @method AspectUnitInterface getUnit()
 */
class Aspect extends Model
{
    use HasFactory;

    protected $table = 'aspects';

    protected $fillable = [
        'user_id',
        // 'type_id',
        'aspect_unit',
        'isEnded',
    ];

    protected $casts = [
        'user_id' => 'integer',
        // 'type_id' => 'integer',
        'aspect_unit' => 'array',
        'isEnded' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id');
    }

    // public function type(): HasOne
    // {
    //     return $this->hasOne(AspectType::class, 'type_id');
    // }

    /**
     * @return \Aspect\Interfaces\Units\AspectUnitInterface
     */
    public function getUnit(): AspectUnitInterface
    {
        return AspectV1Unit::makeInstance($this);
    }
}
