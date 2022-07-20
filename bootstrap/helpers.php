<?php

use App\Providers\Storage;
use Carbon\Carbon;
use Horizom\Auth\Auth;
use Horizom\Validation\Validation;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Str;

/**
 * Get a fluent database query builder instance.
 */
function db(string $table)
{
    return DB::table($table);
}

function carbon(string $date): Carbon
{
    return Carbon::parse($date)->locale('fr_FR');
}

/**
 * Date formater helper
 */
function moment(string $date, string $format)
{
    return carbon($date)->isoFormat($format);
}

/**
 * Get storage helper
 */
function storage(string $disk = 'local')
{
    return new Storage($disk);
}

/**
 * Get auth helper
 */
function auth(): Auth
{
    return app()->get(Auth::class);
}

/**
 * Check authenticated user roles
 */
function access(string $role)
{
    $roles = array_map('strtolower', auth()->getRoles());

    if (in_array(strtolower($role), $roles)) {
        return true;
    }

    return false;
}

/**
 * Slugify a string
 */
function slug(string $text)
{
    return Str::slug($text);
}

/**
 * Validation helper
 * 
 * @throws ValidationException
 */
function validate(array $data, array $rules, array $messages = [])
{
    $validator = new Validation(config('app.locale'));
    $validator->rules($rules);
    $validator->messages($messages);

    return $validator->run($data);
}

/**
 * Returns the portion of the string specified by length parameters.
 */
function truncate(string $chaine, int $length, $exact = true, $separ = '...')
{
    if (strlen($chaine) >= $length) {
        $chaine = substr($chaine, 0, $length);

        if ($exact) {
            $chaine = substr($chaine, 0, strrpos($chaine, " "));
        }

        $chaine .= $separ;
    }

    return $chaine;
}