<?php namespace Phuclh\DKLogForm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;

class FormSubmissionValue extends Model
{
    use Orbital;

    protected $guarded = [];

    public static $driver = 'json';

    public static function schema(Blueprint $table)
    {
        $table->id();
        $table->foreignIdFor(FormSubmission::class)->index();
        $table->string('key');
        $table->text('value');
    }

    public function formSubmission(): BelongsTo
    {
        return $this->belongsTo(FormSubmission::class);
    }
}
