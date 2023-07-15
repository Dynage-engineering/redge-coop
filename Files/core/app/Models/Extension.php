<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GlobalStatus;

class Extension extends Model {

    use GlobalStatus;

    protected $casts = [
        'shortcode' => 'object',
    ];

    public function scopeGenerateScript() {
        $script = $this->script;
        foreach ($this->shortcode as $key => $item) {
            $script = str_replace('{{' . $key . '}}', $item->value, $script);
        }
        return $script;
    }
}
