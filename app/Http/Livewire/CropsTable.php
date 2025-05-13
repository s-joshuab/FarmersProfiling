<?php

namespace App\Http\Livewire;

use App\Models\crops;
use App\Models\Barangays;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Commodities;
use App\Models\FarmersProfile;
use App\Models\FarmersNumber;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class CropsTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        return [
            Exportable::make('Farmers Report')
                ->striped()
                ->type(Exportable::TYPE_XLS),
            Header::make()->showSearchInput()->withoutLoading(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

        public function datasource(): Builder
        {

            return Crops::query()
                ->join('farmersprofile', 'farmersprofile.id', '=', 'crops.farmersprofile_id')
                ->join('commodities', 'commodities.id', '=', 'crops.commodities_id')
                ->join('farmersnumber', 'farmersnumber.farmersprofile_id', '=', 'farmersprofile.id')
                ->join('barangays', 'barangays.id', '=', 'farmersprofile.barangays_id')
                ->select(
                    'crops.*',
                    'farmersprofile.fname',
                    'farmersprofile.sname',
                    'commodities.commodities',
                    'farmersnumber.farmersnumber',
                    // 'farmersprofile.status',
                    'barangays.barangays' // Select the 'barangays' column from 'barangays' and give it an alias
                );


        }

        public function relationSearch(): array
        {
            return [

                'farmersProfile' => ['fname', 'sname', 'farmersnumber', 'farm_size', 'farm_location'], // Use 'barangay_name' here
                'commodity' => ['commodities', 'category'],
            ];
        }

        public function addColumns(): PowerGridColumns
        {
            return PowerGrid::columns()
                ->addColumn('farmersnumber.farmersnumber')
                // ->addColumn('farmersprofile.sname'. ' ' .'farmersprofile.fname')
                ->addColumn('farmersprofile.fname')
                ->addColumn('farmersprofile.sname')
                ->addColumn('farmersprofile.barangays.barangays') // Display 'barangay_name' as 'Barangay'
                ->addColumn('commodities.commodities')
                ->addColumn('farm_size');
                // ->addColumn('farmersprofile.status');
        }


        public function columns(): array
        {
            return [
                Column::make('Farmers Number', 'farmersnumber','farmersnumber.farmersnumber'),
                // Column::make('FullName','farmersprofile.sname','farmersprofile.sname'),
                Column::make('Last Name', 'farmersprofile.sname'),
                Column::make('First Name', 'farmersprofile.fname'),
                Column::make('Barangays', 'barangays', 'barangays.barangays'), // Use 'barangay_name' here
                Column::make('Commodities', 'commodities', 'commodities.commodities'),
                Column::make('Farm size', 'farm_size'),
                Column::make('Farm location', 'farm_location'),
                // Column::make('Status', 'farmersprofile.status'),


            ];
        }


            public function filters(): array
            {
                return [
                Filter::select('commodities', 'commodities.commodities')
                        ->dataSource(Commodities::all())
                        ->optionValue('commodities') // Make sure 'id' is the primary key of Commodity model
                        ->optionLabel('commodities'),

                // Filter::multiSelect('barangays', 'barangays.barangays')
                //         ->dataSource(Barangays::all())
                //         ->optionValue('barangays') // Make sure 'id' is the primary key of Barangay model
                //         ->optionLabel('barangays'),

                        Filter::inputText('farmersnumber', 'farmersnumber.farmersnumber')
                        ->operators(['contains']),

                        Filter::inputText('farmersprofile.sname', 'farmersprofile.sname')
                        ->operators(['contains']),

                        Filter::inputText('farm_size', 'farm_size')
                        ->operators(['contains']),

                        Filter::inputText('farm_location', 'farm_location')
                        ->operators(['contains']),

                        Filter::select('barangays', 'barangays.barangays')
                        ->dataSource(Barangays::select('barangays')->distinct()->get())
                        ->optionValue('barangays')
                        ->optionLabel('barangays'),


                        // Filter::select('farmersprofile.status', 'farmersprofile.status')
                        // ->dataSource(FarmersProfile::select('farmersprofile.status')->distinct()->get())
                        // ->optionValue('status')
                        // ->optionLabel('status'),
                ];
            }


        // public function fetchAllFarmersProfiles()
        // {
        //     return FarmersProfile::all();
        // }

    }
