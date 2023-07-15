<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\ApiQuery;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Fdr extends Model {
    use Searchable, ApiQuery;

    protected $guarded = ['id'];

    protected $casts = [
        'closed_at'             => 'datetime',
        'locked_date'           => 'datetime',
        'next_installment_date' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function plan() {
        return $this->belongsTo(FdrPlan::class, 'plan_id', 'id');
    }

    public function installments() {
        return $this->morphMany(Installment::class, 'installmentable');
    }

    public function scopeRunning($query) {
        return $query->where('status', Status::FDR_RUNNING);
    }

    public function scopeClosed($query) {
        return $query->where('status', Status::FDR_CLOSED);
    }

    public function scopeDue($query) {
        return $query->where('status', Status::FDR_RUNNING)->whereDate('next_installment_date', '<', today());
    }

    public function interestRate(): Attribute {
        return Attribute::make(get:fn() => $this->per_installment / $this->amount * 100);
    }

    public function totalInstallment() {
        $totalDays = $this->created_at->endOfDay()->diffInDays(today());
        return (int) ($totalDays / $this->installment_interval);
    }

    public function receivedInstallment() {
        return $this->profit / $this->per_installment;
    }

    public function dueAmount() {
        return $this->dueInstallment() * $this->per_installment;
    }

    public function dueInstallment() {
        return $this->totalInstallment() - $this->receivedInstallment();
    }

    public function statusBadge(): Attribute {
        return Attribute::make(get:function () {
            if ($this->status == 1 && $this->next_installment_date < today()) {
                return '<span class="badge badge--warning">' . trans('Due') . '</span>';
            } elseif ($this->status == 1) {
                return '<span class="badge badge--success">' . trans('Running') . '</span>';
            } else {
                return '<span class="badge badge--dark">' . trans('Closed') . '</span>';
            }
        });
    }
}
