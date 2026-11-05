<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/** Shared helpers for searchable, sortable admin lists. */
trait FiltersLists
{
    /** Escape LIKE wildcards so user input is matched literally. */
    protected function escapeLike(string $value): string
    {
        return str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $value);
    }

    /** @param  list<string>  $columns */
    protected function applySearch(Builder $query, ?string $term, array $columns): void
    {
        $term = trim((string) $term);
        if ($term === '' || $columns === []) {
            return;
        }

        $like = '%'.$this->escapeLike(mb_substr($term, 0, 100)).'%';

        $query->where(function (Builder $q) use ($columns, $like): void {
            foreach ($columns as $column) {
                $q->orWhereRaw($q->getGrammar()->wrap($column)." LIKE ? ESCAPE '!'", [$like]);
            }
        });
    }

    /**
     * Apply a whitelisted sort. Falls back to the default column, newest first.
     *
     * @param  list<string>  $allowed
     * @return array{0: string, 1: string} resolved [column, direction]
     */
    protected function applySort(Builder $query, Request $request, array $allowed, string $defaultColumn, string $defaultDir = 'desc', string $tieBreaker = 'id'): array
    {
        $column = in_array($request->query('sort'), $allowed, true) ? (string) $request->query('sort') : $defaultColumn;
        $dir = $request->query('sort') !== null && in_array($request->query('dir'), ['asc', 'desc'], true)
            ? (string) $request->query('dir')
            : $defaultDir;

        $query->orderBy($column, $dir)->orderBy($tieBreaker, $tieBreaker === 'id' ? 'desc' : 'asc');

        return [$column, $dir];
    }
}
