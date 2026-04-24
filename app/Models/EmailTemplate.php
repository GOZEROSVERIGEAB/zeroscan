<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'identifier',
        'name',
        'subject',
        'body',
        'variables',
    ];

    protected $casts = [
        'variables' => 'array',
    ];

    public static function getByIdentifier(string $identifier): ?self
    {
        return static::where('identifier', $identifier)->first();
    }

    public function render(array $data): string
    {
        $body = $this->body;

        foreach ($data as $key => $value) {
            $body = str_replace("{{{$key}}}", (string) $value, $body);
        }

        return $body;
    }

    public function renderSubject(array $data): string
    {
        $subject = $this->subject;

        foreach ($data as $key => $value) {
            $subject = str_replace("{{{$key}}}", (string) $value, $subject);
        }

        return $subject;
    }
}
