<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model {
    protected $casts = [
        'mail_config'        => 'object',
        'sms_config'         => 'object',
        'global_shortcodes'  => 'object',
        'modules'            => 'object',
        'wire_transfer_data' => 'object',
        'push_configuration' => 'object',
    ];

    public function scopeSiteName($query, $pageTitle) {
        $pageTitle = empty($pageTitle) ? '' : ' - ' . $pageTitle;
        return $this->site_name . $pageTitle;
    }

    protected static function boot() {
        parent::boot();
        static::saved(function () {
            \Cache::forget('GeneralSetting');
        });
    }

    // Accessor
    public function transferCharge() {
        $charge = '';

        if ($this->percent_transfer_charge > 0) {
            $charge .= getAmount($this->percent_transfer_charge) . '%';
        }

        if ($this->percent_transfer_charge > 0 && $this->fixed_transfer_charge > 0) {
            $charge .= ' + ';
        }

        if ($this->fixed_transfer_charge > 0) {
            $charge .= gs()->cur_sym . showAmount($this->fixed_transfer_charge);
        }

        return $charge;
    }
}
