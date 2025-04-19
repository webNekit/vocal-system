<?php

namespace App\Http\Controllers\Mentor\Talk;

use App\Http\Controllers\Controller;
use App\Http\Requests\Talk\UpdateTalkRequest;
use App\Models\Assignment;
use App\Models\Talk;
use App\Tables\MentorTalks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\Splade\FormBuilder\File;
use ProtoneMedia\Splade\FormBuilder\Hidden;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\FormBuilder\Textarea;
use ProtoneMedia\Splade\SpladeForm;

class TalkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mentor::talks.index', [
            'title' => 'Обсуждение',
            'talks' => MentorTalks::class,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Talk $talk)
    {
//        dd(route('mentor::talk.update', $talk));
        $assignment = Assignment::findOrFail($talk->assignment_id);
        $userName = optional($assignment->user)->name ?? 'Ученик не найден';

        $form = SpladeForm::make()
            ->action(route('mentor::talk.update', $talk))
            ->method('PUT')
            ->fields([
                Input::make('assignment_id')->hidden(),

                Textarea::make('user_comment')
                    ->disabled(true)
                    ->label('Комментарий ученика'),

                Textarea::make('mentor_comment')
                    ->label('Ваш комментарий'),

                Select::make('status')
                    ->label('Статус обсуждения')
                    ->options([
                        'pending' => 'В ожидании',
                        'reviewed' => 'На рассмотрении',
                        'approved' => 'Одобрено',
                        'rejected' => 'Отклонено',
                    ])
                    ->required(),

                Submit::make()->label('Сохранить'),
            ])
            ->fill($talk->toArray())
            ->class('space-y-4');
        return view('mentor::talks.edit', [
            'title' => 'Редактировать обсуждение',
            'userName' => $userName,
            'form' => $form,
            'talk' => $talk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTalkRequest $request, Talk $talk)
    {
        $data = $request->validated();
        if (!isset($data['status'])) {
            $data['status'] = $talk->status;
        }

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('talks/vocals', 'public');
        }

        $talk->update($data);
        return redirect()->route('mentor::talk.index')->with('success', 'Обсуждение обновлено');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
