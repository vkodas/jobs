<?php

namespace App\Models;

use App\Enums\JobStatusEnum;
use App\Models\AbstractInMemoryModel;

class Job extends AbstractInMemoryModel
{
    protected array $attributes = [
        'id',
        'status',
        'urls',
        'selectors',
        'content'
    ];

    protected string $id = '';
    public string $status = JobStatusEnum::NEW->value;
    public array $urls = [];
    public string $selectors = '';
    public array $content = [];
}
