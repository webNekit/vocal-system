<?php

namespace App\Tables;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class Users extends AbstractTable
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
        return User::query()->orderByDesc('id')->where('id', '!=', auth()->id())->get();
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
            ->column('name', label: 'Имя пользователя', sortable: true, searchable: true )
            ->column('email', label: 'Email', sortable: true)
            ->column('role', label: 'Роль')
            ->column('created_at', label: 'Дата регистрации', sortable: true)
            ->column('action', label: 'Действие');
            // ->searchInput()
            // ->selectFilter()
            // ->withGlobalSearch()

            // ->bulkAction()
            // ->export()
    }
}
