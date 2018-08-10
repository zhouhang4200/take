<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 代练订单留言
 * Class GameLevelingOrderMessage
 *
 * @package App\Models
 */
class GameLevelingOrderMessage extends Model
{
    public $fillable = [
        'initiator',
        'game_leveling_order_trade_no',
        'from_user_id',
        'from_parent_user_id',
        'from_username',
        'to_user_id',
        'to_username',
        'content',
        'type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function image()
    {
        return $this->morphMany(Attachment::class, 'attachment');
    }
}
