<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Tables\Users;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\SpladeForm;
use ProtoneMedia\Splade\SpladeTable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::users.index', [
            'title' => 'Пользователи',
            'users' => Users::class,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::users.create', [
            'title' => 'Редактировать пользователя',
        ]);
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
    public function edit(User $user)
    {
        $form = SpladeForm::make()
            ->action(route('admin::user.update', $user))
            ->method('PUT')
            ->fields([
                Input::make('name')
                    ->label('Имя пользователя'),
                Input::make('email')
                    ->label('Email'),
                Select::make('role')
                    ->label('Роль')
                    ->options([
                       'user' => 'Пользователь',
                       'mentor' => 'Наставник',
                       'admin' => 'Администратор'
                    ]),
                Submit::make()->label('Сохранить'),
            ])->fill($user)->class('space-y-4');
        return view('admin::users.edit', [
            'title' => 'Редактировать пользователя',
            'form' => $form,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return to_route('admin::user.index')->with('success', 'Пользователь успешно обновлён');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin::user.index')->with('success', 'Пользователь успешно удален');
    }
}
