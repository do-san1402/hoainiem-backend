<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait WithCache
{
    protected static $oldKeys = [];

    /**
     * cache data
     *
     * @param  mixed  $column
     * @return mixed
     */
    public static function cacheData($column = 'id')
    {
        return Cache::rememberForever(self::$cacheKey, function () use ($column) {
            $query = static::orderBy($column, 'desc');
            if (isset(self::$cacheRelationshipKeys)) {
                foreach (self::$cacheRelationshipKeys as $key => $model) {
                    $query = $query->with($key);
                }
            }

            return $query->get();
        });
    }

    /**
     * cache data ASC
     *
     * @param  mixed  $column
     * @return mixed
     */
    public static function cacheDataASC($column = 'id')
    {
        return Cache::rememberForever(self::$cacheKey.'_latest_', function () use ($column) {
            $query = static::orderBy($column, 'asc');
            if (isset(self::$cacheRelationshipKeys)) {
                foreach (self::$cacheRelationshipKeys as $key => $model) {
                    $query = $query->with($key);
                }
            }

            return $query->get();
        });
    }

    /**
     * cache data first
     *
     * @return mixed
     */
    public static function cacheDataFirst()
    {
        return Cache::rememberForever(self::$cacheKey.'_first_', function () {
            $query = new static;
            if (isset(self::$cacheRelationshipKeys)) {
                foreach (self::$cacheRelationshipKeys as $key => $model) {
                    $query = $query->with($key);
                }
            }

            return $query->first();
        });
    }

    /**
     * cache data last
     *
     * @param  mixed  $column
     * @return mixed
     */
    public static function cacheDataLast($column = 'id')
    {
        return Cache::rememberForever(self::$cacheKey.'_last_', function () use ($column) {
            $query = static::orderBy($column, 'desc');
            if (isset(self::$cacheRelationshipKeys)) {
                foreach (self::$cacheRelationshipKeys as $key => $model) {
                    $query = $query->with($key);
                }
            }

            return $query->first();
        });
    }

    /**
     * cache data query
     *
     * @param  string  $cacheKey
     * @param  mixed  $query
     * @return mixed
     */
    public static function cacheDataQuery($cacheKey, $query)
    {
        return Cache::rememberForever(self::$cacheKey.$cacheKey, function () use ($query) {
            return $query;
        });
    }

    /**
     * Forget cache
     *
     * @param  string  $cacheKey
     */
    public static function forgetCache($cacheKey = null): void
    {
        if (isset(self::$cacheKeys)) {
            foreach (self::$cacheKeys as $key) {
                Cache::forget(self::$cacheKey.$key);
            }
        }

        if (isset(self::$cacheRelationshipKeys)) {
            foreach (self::$cacheRelationshipKeys as $key => $model) {
                if (in_array($key, self::$oldKeys)) {
                    break;
                }
                \array_push(self::$oldKeys, $key);
                $model::forgetCache();
            }
            self::$oldKeys = [];
        }

        Cache::forget(self::$cacheKey);
        Cache::forget(self::$cacheKey.'_latest_');
        Cache::forget(self::$cacheKey.'_first_');
        Cache::forget(self::$cacheKey.'_last_');
        if ($cacheKey) {
            Cache::forget(self::$cacheKey.$cacheKey);
        }
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($data) {
            $data->forgetCache();
        });

        static::updated(function ($data) {
            $data->forgetCache();
        });
        static::deleted(function ($data) {
            $data->forgetCache();
        });
    }
}
