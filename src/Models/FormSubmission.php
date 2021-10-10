<?php namespace Phuclh\DKLogForm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;

class FormSubmission extends Model
{
    use Orbital;

    protected $guarded = [];

    public static $driver = 'json';

    protected static function booted()
    {
        static::deleted(fn(self $formSubmission) => $formSubmission->formSubmissionValues->each->delete());
    }

    public static function schema(Blueprint $table)
    {
        $table->id();
        $table->string('form_name');
        $table->string('form_id')->index();
        $table->text('referrer')->nullable();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
    }

    public function formSubmissionValues(): HasMany
    {
        return $this->hasMany(FormSubmissionValue::class);
    }
}
