<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Http\Requests\RepositoryRequest;

class RepositoryConytroller extends Controller
{
    // public function index(Request $request)
    public function index()
    {
        return view('repositories.index', [
            // 'repositories' => $request->user()->repositories
            'repositories' => auth()->user()->repositories
        ]);
    }


    public function show(Repository $repository)
    {
        if(auth()->user()->id != $repository->user_id) {
            abort(403);
        }

        return view('repositories.show', compact('repository'));
    }


    public function create()
    {
        return view('repositories.create');
    }


    public function store(RepositoryRequest $request)
    {
        $request->user()->repositories()->create($request->all());

        return redirect()->route('repositories.index');
    }


    // public function edit(Request $request, Repository $repository)
    public function edit(Repository $repository)
    {
        $this->authorize('pass', $repository);

        return view('repositories.edit', compact('repository'));
    }

    public function update(RepositoryRequest $request, Repository $repository)
    {
        $this->authorize('pass', $repository);

        $repository->update($request->all());

        // dd($repository);

        return redirect()->route('repositories.index', $repository);
    }

    public function destroy(Repository $repository)
    {
        $this->authorize('pass', $repository);

        $repository->delete();

        return redirect()->route('repositories.index');
    }
}