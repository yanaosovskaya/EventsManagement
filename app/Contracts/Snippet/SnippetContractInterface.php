<?php

namespace App\Contracts\Snippet;

use App\Http\Requests\SnippetRequest;
use App\Models\Exceptions\SnippetException;
use App\Models\Snippet;
use Illuminate\Support\Collection;

/**
 * Interface SnippetContractInterface
 * @package App\Contracts\Snippet
 */
interface SnippetContractInterface
{
    /**
     * @return Collection
     */
    public function get();

    /**
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function paginate($page = 10);

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findById($id);

    /**
     * @param SnippetRequest $request
     * @param Snippet $snippet
     * @return mixed
     * @throws SnippetException
     */
    public function update(SnippetRequest $request, Snippet $snippet);

    /**
     * @param Snippet $snippet
     * @return bool
     * @throws \Exception
     */
    public function delete(Snippet $snippet);
}
