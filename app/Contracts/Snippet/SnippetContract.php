<?php

namespace App\Contracts\Snippet;

use App\Http\Requests\SnippetRequest;
use App\Models\Exceptions\SnippetException;
use App\Models\Snippet;
use Illuminate\Support\Collection;
use DB;

/**
 * Class SnippetContract
 * @package App\Contracts\Snippet
 */
class SnippetContract implements SnippetContractInterface
{
    /**
     * @var Snippet
     */
    protected $model;

    /**
     * SnippetContract constructor.
     * @param Snippet $snippet
     */
    public function __construct(Snippet $snippet)
    {
        $this->model = $snippet;
    }

    /**
     * @return Collection
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function paginate($page = 10)
    {
        return $this->model->paginate($page);
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param SnippetRequest $request
     * @param Snippet $snippet
     * @return mixed
     * @throws SnippetException
     */
    public function update(SnippetRequest $request, Snippet $snippet)
    {
        DB::beginTransaction();
        try {
            $snippet->fill($request->all());
            if (!$snippet->save()) {
                throw new SnippetException('Snippet not saved.');
            }

            if ($request->has('slugs')) {
                $request->validate([
                    'slugs' => 'array',
                    'slugs.*' => 'integer|exists:slugs,id',
                ]);

                $snippet->slugs()->sync($request->slugs);
            } else {
                $snippet->slugs()->detach();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new SnippetException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param Snippet $snippet
     * @return bool
     * @throws \Exception
     */
    public function delete(Snippet $snippet)
    {
        return $snippet->delete();
    }
}
