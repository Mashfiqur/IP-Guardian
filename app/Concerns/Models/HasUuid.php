<?php

namespace App\Concerns\Models;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Boot the HasUuid trait for a model.
     *
     * This method is automatically called by Laravel when the trait is booted.
     *
     * @return void
     */
    protected static function bootHasUuid(): void
    {
        $self = new static;

        static::creating(function ($model) use ($self) {
            $self->generateAndAssignUuid($model);
        });
    }

    /**
     * Generate a UUID and assign it to the specified column if UUID is enabled.
     *
     * @param mixed $model The model instance to which the UUID will be assigned.
     *
     * @return void
     */
    protected function generateAndAssignUuid($model): void
    {
        if ($this->isUuidEnabled()) {
            $model->{$this->getUuidColumnName()} = Str::orderedUuid();
        }
    }

    /**
     * Check if UUID is enabled in the configuration.
     *
     * @return bool Returns true if UUID is enabled; otherwise, returns false.
     */
    protected function isUuidEnabled(): bool
    {
        return config('uuid.enable', false);
    }

    /**
     * Get the UUID column name from the configuration.
     *
     * @return string The UUID column name.
     */
    protected function getUuidColumnName(): string
    {
        return config('uuid.column', 'uuid');
    }

    /**
     * Get the UUID as publishable key if UUID enabled otherwise id will be passed
     *
     * @return string
     */
    public function getId(): ?string
    {
        return $this->isUuidEnabled()
            ? ($this->attributes[$this->getUuidColumnName()] ?? $this->attributes['id'])
            : $this->attributes['id'];
    }
}
