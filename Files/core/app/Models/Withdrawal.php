<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\ApiQuery;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model {
    use Searchable, ApiQuery;

    protected $casts = [
        'withdraw_information' => 'object',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function method() {
        return $this->belongsTo(WithdrawMethod::class, 'method_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function branchStaff() {
        return $this->belongsTo(BranchStaff::class, 'branch_staff_id');
    }

    public function statusBadge(): Attribute {
        return new Attribute(
            get:fn() => $this->badgeData(),
        );
    }

    public function badgeData() {
        $html = '';
        if ($this->status == Status::PAYMENT_PENDING) {
            $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
        } elseif ($this->status == Status::PAYMENT_SUCCESS) {
            $html = '<span><span class="badge badge--success">' . trans('Approved') . '</span><br>' . diffForHumans($this->updated_at) . '</span>';
        } elseif ($this->status == Status::PAYMENT_REJECT) {
            $html = '<span><span class="badge badge--danger">' . trans('Rejected') . '</span><br>' . diffForHumans($this->updated_at) . '</span>';
        }
        return $html;
    }

    public function scopePending() {
        return $this->where('status', Status::PAYMENT_PENDING);
    }

    public function scopeApproved() {
        return $this->where('status', Status::PAYMENT_SUCCESS);
    }

    public function scopeRejected() {
        return $this->where('status', Status::PAYMENT_REJECT);
    }

    public function scopeLastDays($query, $days = 30) {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeSumAmount($query) {
        return $query->selectRaw("SUM(amount) as withdrawAmount");
    }
}
