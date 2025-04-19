<?php

namespace App\Http\Controllers\Admin\Assignment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assignment\StoreAssignmentRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Tables\Assignments;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\SpladeForm;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::assignment.index', [
            'title' => 'Наставничество',
            'assignments' => Assignments::class,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = \App\Models\User::whereIn('role', ['user', 'mentor'])->get();
        $form = SpladeForm::make()
            ->action(route('admin::assignment.store'))
            ->method('POST')
            ->fields([
                Select::make('user_id')
                    ->label('Пользователь')
                    ->options($users->where('role', 'user')->pluck('name', 'id')->toArray())
                    ->required(),
                Select::make('mentor_id')
                    ->label('Наставник')
                    ->options($users->where('role', 'mentor')->pluck('name', 'id')->toArray())
                    ->required(),
                Submit::make()->label('Сохранить'),
            ])->class('space-y-4');
        return view('admin::assignment.create', [
            'title' => 'Создать новую запись',
            'form' => $form,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentRequest $request)
    {
        Assignment::create($request->validated());
        return redirect()->route('admin::assignment.index')->with('success', 'Добавлена новая запис');
    }

    /**
     * Display the specified resource.
     */
    public function show(assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        $users = \App\Models\User::whereIn('role', ['user', 'mentor'])->get();
        $form = SpladeForm::make()
            ->action(route('admin::assignment.update', $assignment))
            ->method('PUT')
            ->fields([
                Select::make('user_id')
                    ->label('Пользователь')
                    ->options($users->where('role', 'user')->pluck('name', 'id')->toArray())
                    ->required(),
                Select::make('mentor_id')
                    ->label('Наставник')
                    ->options($users->where('role', 'mentor')->pluck('name', 'id')->toArray())
                    ->required(),
                Submit::make()->label('Сохранить'),
            ])->fill($assignment)->class('space-y-4');
        return view('admin::assignment.edit', [
            'title' => 'Редактировать запись',
            'form' => $form,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $assignment->update($request->validated());
        return redirect()->route('admin::assignment.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('admin::assignment.index')->with('success', 'Данные успешно удалены');
    }
}
