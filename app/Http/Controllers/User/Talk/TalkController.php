<?php

namespace App\Http\Controllers\User\Talk;

use App\Http\Controllers\Controller;
use App\Http\Requests\Talk\StoreTalkRequest;
use App\Http\Requests\Talk\UpdateTalkRequest;
use App\Models\Assignment;
use App\Models\Talk;
use App\Tables\Talks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\Splade\FormBuilder\File;
use ProtoneMedia\Splade\FormBuilder\Hidden;
use ProtoneMedia\Splade\FormBuilder\Input;
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
        return view('user::talks.index', [
            'title' => 'Обсуждения',
            'talks' => Talks::class,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assignment = Assignment::where('user_id', Auth::id())->firstOrFail();
        $mentorName = optional($assignment->mentor)->name ?? 'Наставник не найден';

        $form = SpladeForm::make()
            ->action(route('user::talks.store'))
            ->method('POST')
            ->fields([
                Input::make('assignment_id')->hidden(),

                Textarea::make('user_comment')
                    ->label('Комментарий')
                    ->required(),

                File::make('file')
                    ->label('Файл вокала')
                    ->required(),

                Submit::make()->label('Отправить'),
            ])
            ->fill(['assignment_id' => $assignment->id])
            ->class('space-y-4');

        return view('user::talks.create', [
            'title' => 'Создать новое обсуждение',
            'mentorName' => $mentorName,
            'form' => $form,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTalkRequest $request)
    {
//        dd($request->all(), $request->validated(), $request->file('file'));  // Выведет все данные, валидированные данные и файл

        $data = $request->validated();
        $data['file'] = $request->file('file')->store('talks/vocals', 'public');
        $data['status'] = 'pending';

        Talk::create($data);

        return redirect('user/talks/')->with('success', 'Обсуждение успешно создано');
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
        $assignment = Assignment::findOrFail($talk->assignment_id);
        $mentorName = optional($assignment->mentor)->name ?? 'Наставник не найден';

        $form = SpladeForm::make()
            ->action(route('user::talks.update', $talk))
            ->method('PUT')
            ->fields([
                Hidden::make('assignment_id'),

                Textarea::make('user_comment')
                    ->label('Комментарий'),

                File::make('file')
                    ->label('Новый файл (если нужно заменить)'),

                Submit::make()->label('Сохранить'),
            ])
            ->fill($talk->toArray())
            ->class('space-y-4');

        return view('user::talks.edit', [
            'title' => 'Редактировать обсуждение',
            'mentorName' => $mentorName,
            'form' => $form,
            'talk' => $talk, // <--- передаём объект
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTalkRequest $request, Talk $talk)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('talks/vocals', 'public');
        } else {
            $data['file'] = $talk->file;
        }

        $talk->update($data);

        return redirect()->route('user::talks.index')->with('success', 'Успешно обновлено');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Talk $talk)
    {
        $talk->delete();
        return redirect()->route('user::talks.index')->with('success', 'Успешно удалено');
    }
}
