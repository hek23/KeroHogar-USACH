<?php

namespace App\Http\Controllers;

use App\TimeBlock;
use App\Http\Requests\TimeBlockRequest;

class TimeBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', TimeBlock::class);

        $timeBlocks = TimeBlock::orderedBlocksPaginated();
        return view('schedule.index', compact('timeBlocks'))
            ->with('rowItem', $this->rowNumber(request()->input('page', 1), TimeBlock::ITEMS_PER_PAGE));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', TimeBlock::class);

        return view('schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\TimeBlockRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimeBlockRequest $request)
    {
        $this->authorize('create', TimeBlock::class);

        if (TimeBlock::intersecting($request->start, $request->end)->exists()) {
            return redirect()->back()->withErrors(['start' => 'El bloque ingresado intersecta con el horario de algún otro bloque.'])
                ->withInput($request->input());
        }
        TimeBlock::create($request->validated());

        return redirect()->route('schedule.index')
            ->with('success', 'Bloque horario creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TimeBlock  $timeBlock
     * @return \Illuminate\Http\Response
     */
    public function show(TimeBlock $timeBlock)
    {
        $this->authorize('view', TimeBlock::class);

        return view('schedule.show', compact('timeBlock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TimeBlock  $timeBlock
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeBlock $timeBlock)
    {
        $this->authorize('update', TimeBlock::class);

        return view('schedule.edit', compact('timeBlock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\TimeBlockRequest  $request
     * @param  \App\TimeBlock  $timeBlock
     * @return \Illuminate\Http\Response
     */
    public function update(TimeBlockRequest $request, TimeBlock $timeBlock)
    {
        $this->authorize('update', TimeBlock::class);

        if (TimeBlock::where('id', '<>', $timeBlock->id)->intersecting($request->start, $request->end)->exists()) {
            return redirect()->back()->withErrors(['start' => 'El bloque ingresado intersecta con el horario de algún otro bloque.'])
                ->withInput($request->input());
        }
        $timeBlock->update($request->validated());

        return redirect()->route('schedule.index')
            ->with('success', 'Bloque horario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TimeBlock  $timeBlock
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeBlock $timeBlock)
    {
        $this->authorize('delete', TimeBlock::class);

        $timeBlock->delete();

        return redirect()->route('schedule.index')
            ->with('success', 'Bloque horario eliminado exitosamente');
    }
}
