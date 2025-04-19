<?php

namespace App\Tables;

use App\Models\MentorTalk;
use App\Models\Talk;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class MentorTalks extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Talk::with('assignment.user') // Загрузим пользователя вместо ментора
        ->whereHas('assignment', function ($q) {
            $q->where('mentor_id', auth()->id());
        })
            ->orderByDesc('created_at');
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table
            ->withGlobalSearch(columns: ['id'])
            ->column('id', sortable: true, label: 'ID')
            ->column('assignment.user.name', label: 'Пользователь') // теперь отображаем пользователя
            ->column('user_comment', label: 'Комментарий от пользователя')
            ->column('mentor_comment', label: 'Ваш комментарий')
            ->column('status', label: 'Статус')
            ->column('created_at', label: 'Получено', sortable: true)
            ->column('actions', 'Действия');
    }
}
