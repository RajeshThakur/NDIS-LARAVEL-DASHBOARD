<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BookingOrderMeta extends Model
{
    use SoftDeletes;

    public $table = 'booking_meta';

    protected $dates = [
        
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        'booking_order_id',
        'meta_key',
        'meta_value',      
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function order()
    {
        return $this->belongsTo(\App\BookingOrders::class);
    }

    public static function deleteMetaKey($booking_order_id, $key) {
        BookingOrderMeta::where("meta_key", $key)->where("booking_order_id", $booking_order_id)->delete();
    }

    public static function getMeta($booking_order_id) {
        $metaValues = [];
        $allMeta = BookingOrderMeta::where("booking_order_id", $booking_order_id)->get();

        foreach($allMeta as $meta)
            $metaValues[$meta->meta_key] = unserialize($meta->meta_value);
        
        return $metaValues;
    }

    public static function getMetaVal($booking_order_id, $key) {
        $meta = BookingOrderMeta::where("meta_key", $key)->where("booking_order_id", $booking_order_id)->first();
        if($meta)
            return unserialize($meta->meta_value);

        return null;
    }

    public static function saveMeta($booking_order_id, $key, $value){
        $meta = BookingOrderMeta::where("meta_key", $key)->where("booking_order_id", $booking_order_id)->first();
        if (!$meta) {
            $meta = new BookingOrderMeta;
            $meta->meta_key = $key;
            $meta->booking_order_id = $booking_order_id;
        }
        $meta->meta_value = serialize($value);
        $meta->save();
        return $meta;
    }

}
