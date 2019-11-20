<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * 获取订单金额
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalAttribute($value)
    {
        return $value / 100;
    }
    
    /**
     * 设置订单金额
     *
     * @param  string  $value
     * @return string
     */
    public function setTotalAttribute($value)
    {
        $this->attributes['total'] =  $value * 100;
    }

    /**
     * 设置实际收到金额
     *
     * @param  string  $value
     * @return string
     */
    public function getActualAttribute($value)
    {
        return $value / 100;
    }
    /**
     * 设置实际收到金额
     *
     * @param  string  $value
     * @return string
     */
    public function setActualAttribute($value)
    {
        $this->attributes['actual'] =  $value * 100;
    }

    /**
     * 获取优惠金额
     *
     * @param  string  $value
     * @return string
     */
    public function getDiscountAttribute($value)
    {
        return $value / 100;
    }
    /**
     * 设置优惠金额
     *
     * @param  string  $value
     * @return string
     */
    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] =  $value * 100;
    }

    /**
     * 获取分成金额
     *
     * @param  string  $value
     * @return string
     */
    public function getRoyaltyAttribute($value)
    {
        return $value / 100;
    }
    /**
     * 设置分成金额
     *
     * @param  string  $value
     * @return string
     */
    public function setRoyaltyAttribute($value)
    {
        $this->attributes['royalty'] =  $value * 100;
    }
    /**
     * 获取拖欠金额
     *
     * @param  string  $value
     * @return string
     */
    public function getArrearsAttribute($value)
    {
        return $value / 100;
    }
    /**
     * 设置拖欠金额
     *
     * @param  string  $value
     * @return string
     */
    public function setArrearsAttribute($value)
    {
        $this->attributes['arrears'] =  $value * 100;
    }
    /**
     * 获取退款金额
     *
     * @param  string  $value
     * @return string
     */
    public function getRefundAttribute($value)
    {
        return $value / 100;
    }
    /**
     * 设置退款金额
     *
     * @param  string  $value
     * @return string
     */
    public function setRefundAttribute($value)
    {
        $this->attributes['refund'] =  $value * 100;
    }
}
