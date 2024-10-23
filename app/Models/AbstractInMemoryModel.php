<?php

namespace App\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use JsonException;
use JsonSerializable;

class AbstractInMemoryModel implements Arrayable, Jsonable, JsonSerializable
{
    protected array $attributes = [];
    protected string $primaryKey = 'id';

    public static function find(string $pkValue): static|null
    {
        if ($cachedValue = Redis::get($pkValue)) {
            $values = json_decode($cachedValue, true);
            if (empty($values)) {
                return null;
            }
            $model = new static();
            foreach ($model->attributes as $attribute) {
                $model->{$attribute} = $values[$attribute] ?? null;
            }
            return $model;
        }

        return null;
    }

    public function toArray(): array
    {
        $attributes = [];
        foreach ($this->attributes as $attribute) {
            $attributes[$attribute] = $this->{$attribute};
        }
        return $attributes;
    }

    public function toJson($options = 0)
    {
        try {
            $json = json_encode($this->jsonSerialize(), $options | JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw JsonEncodingException::forModel($this, $e->getMessage());
        }

        return $json;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function save(array $options = [])
    {
        if (!$pkVal = $this->getPrimaryKey()) {
            $pkVal = $this->genPrimaryKeyVal();
        }

        $values = $this->toArray();
        Redis::set($pkVal, $this->toJson());
        //Store to redis
    }

    public function delete()
    {
        Redis::del($this->getPrimaryKey());
    }

    public function getPrimaryKey(): string
    {
        return $this->{$this->primaryKey};
    }

    private function genPrimaryKeyVal(): string
    {
        return $this->{$this->primaryKey} = Str::uuid()->toString();
    }
}
