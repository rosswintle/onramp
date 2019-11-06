<?php

namespace App;

use App\Completable;
use App\Completion;
use App\Facades\Preferences;
use App\Module;
use App\Preferences\OperatingSystemPreference;
use App\Preferences\ResourceLanguagePreference;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model implements Completable
{
    const VIDEO_TYPE = 'video';
    const COURSE_TYPE = 'course';
    const AUDIO_TYPE = 'audio';
    const BOOK_TYPE = 'book';
    const ARTICLE_TYPE = 'article';

    const TYPES = [
        self::VIDEO_TYPE,
        self::COURSE_TYPE,
        self::AUDIO_TYPE,
        self::BOOK_TYPE,
        self::ARTICLE_TYPE,
    ];

    protected $guarded = ['id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function completions()
    {
        return $this->morphMany(Completion::class, 'completable');
    }

    public function scopeForLocalePreferences($query, $locale, $resourceLanguagePreference)
    {
        switch ($resourceLanguagePreference) {
            case 'local':
                $query->where(['language' => $locale]);
                break;
            case 'local-and-english':
                $query->where(function ($query) use ($locale) {
                    $query->where(['language' => $locale])
                        ->orWhere('language', 'en');
                });
            case 'all':
                break;
        }
    }

    public function scopeForCurrentSession($query)
    {
        if (auth()->check()) {
            return $this->scopeForLoggedInUser($query);
        }

        return $this->scopeForLocalePreferences(
            $query,
            locale(),
            Preferences::get((new ResourceLanguagePreference)->key())
        );
    }

    public function scopeForLoggedInUser($query)
    {
        $user = auth()->user();

        $this->scopeForLocalePreferences($query, locale(), Preferences::get((new ResourceLanguagePreference)->key()));

        $query->whereIn('os', [OperatingSystem::ANY, Preferences::get((new OperatingSystemPreference)->key())]);
    }
}
