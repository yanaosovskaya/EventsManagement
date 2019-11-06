<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Snippet\SnippetContractInterface;
use App\Http\Requests\SnippetRequest;
use App\Models\Slug;
use App\Models\Snippet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Itmaster\Manager\ManagerServiceProvider;

class SnippetController extends Controller
{
    /**
     * @var \Illuminate\Support\ServiceProvider|null
     */
    protected $hasModuleRole;

    /**
     * @var SnippetContractInterface
     */
    protected $snippetContract;

    /**
     * UserController constructor.
     * @param SnippetContractInterface $snippetContract
     */
    public function __construct(SnippetContractInterface $snippetContract)
    {
        $this->snippetContract = $snippetContract;

        $this->hasModuleRole = app()->getProvider(ManagerServiceProvider::class);

        if ($this->hasModuleRole) {
            $this->middleware(['permission:snippet.index'])->only(['index', 'show']);
            $this->middleware(['permission:snippet.update'])->only(['edit', 'update']);
            $this->middleware(['permission:snippet.create'])->only(['create', 'store']);
            $this->middleware(['permission:snippet.delete'])->only(['destroy']);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.snippet.index', [
            'snippets' => $this->snippetContract->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.snippet.create', [
            'snippet'    => [],
            'slugs' => Slug::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SnippetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SnippetRequest $request)
    {
        try {
            $snippet = new Snippet();
            $this->snippetContract->update($request, $snippet);
        } catch (\Exception $e) {
            return redirect()->route('admin.snippet.create')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.snippet.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Snippet $snippet
     * @return \Illuminate\Http\Response
     */
    public function edit(Snippet $snippet)
    {
        $slugs = Slug::all();
        return view('admin.snippet.edit', compact('snippet', 'slugs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SnippetRequest $request
     * @param Snippet $snippet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SnippetRequest $request, Snippet $snippet)
    {
        try {
            $this->snippetContract->update($request, $snippet);
        } catch (\Exception $e) {
            return redirect()->route('admin.snippet.edit', $snippet)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.snippet.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Snippet $snippet
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Snippet $snippet)
    {
        $this->snippetContract->delete($snippet);
        return redirect()->route('admin.snippet.index');
    }
}
