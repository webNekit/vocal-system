<?php

namespace App\Tables;

use App\Models\Assignment;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class Assignments extends AbstractTable
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
        return Assignment::query()->orderByDesc('created_at')->get();
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
            ->column('id', sortable: true)
            ->column('user.name', label: 'Имя пользователя')
            ->column('mentor.name', label: 'Имя наставника')
            ->column('created_at', label: 'Дата создания')
            ->column('action', 'Действие');
            // ->searchInput()
            // ->selectFilter()
            // ->withGlobalSearch()

            // ->bulkAction()
            // ->export()
    }
}
