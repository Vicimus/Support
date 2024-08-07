<?php

declare(strict_types=1);

namespace Vicimus\Support\Database;

/**
 * Trait SoftDeletingTrait
 *
 * phpcs:disable
 */
trait SoftDeletingTrait
{

    /**
     * Indicates if the model is currently force deleting.
     */
    protected bool $forceDeleting = false;

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootSoftDeletingTrait(): void
    {
        static::addGlobalScope(new SoftDeletingScope());
    }

    /**
     * Force a hard delete on a soft deleted model.
     *
     * @return void
     */
    public function forceDelete(): void
    {
        $this->forceDeleting = true;

        $this->delete();

        $this->forceDeleting = false;
    }

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    protected function performDeleteOnModel(): void
    {
        if ($this->forceDeleting) {
            $this->withTrashed()->where($this->getKeyName(), $this->getKey())->forceDelete();
            return;
        }

        $this->runSoftDelete();
    }

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    protected function runSoftDelete(): void
    {
        $query = $this->newQuery()->where($this->getKeyName(), $this->getKey());

        $this->{$this->getDeletedAtColumn()} = $time = $this->freshTimestamp();

        $query->update([$this->getDeletedAtColumn() => $this->fromDateTime($time)]);
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function restore(): ?bool
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = null;

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('restored', false);

        return $result;
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function trashed(): bool
    {
        return ! is_null($this->{$this->getDeletedAtColumn()});
    }

    /**
     * Get a new query builder that includes soft deletes.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\SoftDeletingTrait
     */
    public static function withTrashed()
    {
        return (new static())->newQueryWithoutScope(new SoftDeletingScope());
    }

    /**
     * Get a new query builder that only includes soft deletes.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function onlyTrashed()
    {
        $instance = new static();

        $column = $instance->getQualifiedDeletedAtColumn();

        return $instance->newQueryWithoutScope(new SoftDeletingScope())->whereNotNull($column);
    }

    /**
     * Register a restoring model event with the dispatcher.
     *
     * @param  \Closure|string $callback
     * @return void
     */
    public static function restoring($callback): void
    {
        static::registerModelEvent('restoring', $callback);
    }

    /**
     * Register a restored model event with the dispatcher.
     *
     * @param  \Closure|string $callback
     * @return void
     */
    public static function restored($callback): void
    {
        static::registerModelEvent('restored', $callback);
    }

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function getDeletedAtColumn(): string
    {
        return defined('static::DELETED_AT') ? static::DELETED_AT : 'deleted_at';
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedDeletedAtColumn(): string
    {
        return $this->getTable().'.'.$this->getDeletedAtColumn();
    }
}
