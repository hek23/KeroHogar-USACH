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
        $timeBlocks = TimeBlock::latestOrdersPaginated();
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
        $timeBlock->delete();

        return redirect()->route('schedule.index')
            ->with('success', 'Bloque horario eliminado exitosamente');
    }
}
