<?php

namespace App\Tables;

use App\Models\Talk;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class Talks extends AbstractTable
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
        return Talk::with('assignment.mentor')
        ->whereHas('assignment', function ($q) {
            $q->where('user_id', auth()->id());
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
            ->column('assignment.mentor.name', label: 'Наставник') // Имя наставника
            ->column('user_comment', label: 'Ваш комментарий')
            ->column('mentor_comment', label: 'Комментарий наставника')
            ->column('status', label: 'Статус')
            ->column('created_at', label: 'Отправлено', sortable: true)
            ->column('actions', 'Действия');
    }
}
