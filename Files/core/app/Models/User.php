<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\ApiQuery;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, Searchable, ApiQuery;

    protected $hidden = [
        'password', 'remember_token', 'ver_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'address'           => 'object',
        'kyc_data'          => 'object',
        'ver_code_send_at'  => 'datetime',
    ];

    public function loginLogs() {
        return $this->hasMany(UserLogin::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits() {
        return $this->hasMany(Deposit::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function withdrawals() {
        return $this->hasMany(Withdrawal::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }
    public function fdr() {
        return $this->hasMany(Fdr::class, 'user_id');
    }

    public function dps() {
        return $this->hasMany(Dps::class, 'user_id');
    }
    public function loan() {
        return $this->hasMany(Loan::class, 'user_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function deviceTokens() {
        return $this->hasMany(DeviceToken::class);
    }

    public function branchStaff() {
        return $this->belongsTo(BranchStaff::class, 'branch_staff_id');
    }

    public function referrer() {
        return $this->belongsTo(User::class, 'ref_by');
    }

    public function referees() {
        return $this->hasMany(User::class, 'ref_by');
    }

    public function beneficiaryTypes() {
        return $this->morphMany(Beneficiary::class, 'beneficiary', 'beneficiary_type', 'beneficiary_id');
    }

    public function allReferees() {
        return $this->referees()->with('allReferees:id,ref_by,username');
    }

    // SCOPES
    public function scopeActive() {
        return $this->where('status', Status::USER_ACTIVE)->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED);
    }

    public function scopeBanned() {
        return $this->where('status', Status::USER_BAN);
    }

    public function scopeEmailUnverified() {
        return $this->where('ev', Status::UNVERIFIED);
    }

    public function scopeMobileUnverified() {
        return $this->where('sv', Status::UNVERIFIED);
    }

    public function scopeKycUnverified() {
        return $this->where('kv', Status::KYC_UNVERIFIED);
    }

    public function scopeKycPending() {
        return $this->where('kv', Status::KYC_PENDING);
    }

    public function scopeEmailVerified() {
        return $this->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified() {
        return $this->where('sv', Status::VERIFIED);
    }

    public function scopeWithBalance() {
        return $this->where('balance', '>', 0);
    }

    // Accessors
    public function fullname(): Attribute {
        return new Attribute(
            get:fn() => $this->firstname . ' ' . $this->lastname,
        );
    }

    public function statusBadge(): Attribute {
        return Attribute::make(get:function () {
            if ($this->status == Status::USER_ACTIVE) {
                return createBadge('success', 'Active');
            } else {
                return createBadge('danger', 'Banned');
            }
        });
    }
}
