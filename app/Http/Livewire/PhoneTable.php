<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Network;
use App\Models\Phone;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class PhoneTable extends PowerGridComponent
{
    use ActionButton;

    protected $listeners = [
        'eventRefresh-default',
    ];
    public $number;
    public function onUpdatedEditable($id, $field, $value): void
    {
        // if ($field == 'amount') {
        //     $value = Str::of($value)
        //         ->replace('.', '')
        //         ->replace(',', '.')
        //         ->replaceMatches('/[^Z0-9\.]/', '');
        // }
        // $this->validate();
        Phone::query()->find($id)->update([
            $field => $value,
        ]);
    }
    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();
        $this->persist(['columns', 'filters']);
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Phone>
     */
    public function datasource(): Builder
    {
        return Phone::query();
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [
            'city' => [ // relationship on dishes model
                'name', // column enabled to search
            ],
            'network' => [ // relationship on dishes model
                'name', // column enabled to search
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('number')

            /** Example of custom column using a closure **/
            ->addColumn('number_lower', function (Phone $model) {
                return strtolower(e($model->number));
            })

            ->addColumn('network', function (Phone $model) {
                return $model->network->name;
            })
            ->addColumn('city', function (Phone $model) {
                return isset($model->city) ? $model->city->name : "-";
            })
            ->addColumn('is_submit');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('#', 'id'),

            Column::make('Numéro', 'number')
                ->sortable()
                ->searchable()
                ->editOnClick(),

            Column::make('Réseau', 'network')
                ->makeInputSelect(Network::all(), 'name', 'network_id'),

            Column::make('Ville', 'city')
                ->makeInputSelect(City::all(), 'name', 'city_id'),

            Column::make('Envoyer', 'is_submit')
                ->field('is_submit')
                ->makeBooleanFilter('is_submit', 'Oui', 'Non')
                ->toggleable(true, true, false),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Phone Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        return [
            //    Button::make('edit', 'Edit')
            //        ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
            //        ->route('phone.edit', ['phone' => 'id']),

            Button::make('destroy', 'Delete')
                ->class('bg-red-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm btn-sm')
                ->emit('deleted', ['id' => 'id'])
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Phone Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($phone) => $phone->id === 1)
                ->hide(),
        ];
    }
    */
}
