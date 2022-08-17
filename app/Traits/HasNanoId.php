<?php

namespace App\Traits;

use Hidehalo\Nanoid\Client;

trait HasNanoId
{
    public static function bootHasNanoId(): void
    {
        static::creating(function ($model) {

            $nanoIdFieldName = $model->getNanoIdFieldName();
            $nanoIdLowerCase = $model->getNanoIdLowerCase();
            $nanoIdPrefix = $model->getNanoIdPrefix();
            $nanoIdSize = $model->getNanoIdSize();

            if (empty($model->{$nanoIdFieldName})) {
                $model->{$nanoIdFieldName} = self::generateId($nanoIdSize, $nanoIdPrefix, $nanoIdLowerCase);
            }
        });
    }

    public function getNanoIdFieldName(): string
    {
        if (! empty($this->nanoIdFieldName)) {
            return $this->nanoIdFieldName;
        }

        return 'nanoid';
    }

    public function getNanoIdLowerCase(): bool
    {
        if (! empty($this->nanoIdLowerCase)) {
            return $this->nanoIdLowerCase;
        }

        return false;
    }

    public function getNanoIdPrefix(): string
    {
        if (! empty($this->nanoIdPrefix)) {
            return $this->nanoIdPrefix;
        }

        return '';
    }

    public function getNanoIdSize(): int
    {
        if (! empty($this->nanoIdSize)) {
            return $this->nanoIdSize;
        }

        return 21;
    }

    public function scopeByNanoId($query, $uid)
    {
        return $query->where($this->getNanoIdFieldName(), $uid);
    }

    public static function findByNanoId($uid)
    {
        return static::byNanoId($uid)->first();
    }

    protected static function generateId($length = 16, $prefix = '', $lowercase = false): string
    {
        $client = new Client();
        $customAlphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $uid = $client->formattedId($alphabet = $customAlphabet, $size = $length);
        $generated = $prefix ? $prefix.$uid : $uid;
        $finalStr = $lowercase === true ? strtolower($generated) : $generated;

        return (string) $finalStr;
    }
}
