<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Province;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportCity implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        ini_set('max_execution_time', 180);
        $province = Province::where('name', $row[1])->first();
        $ifExist = City::where('name', '=', $row[0])->first();
        if (isset($province)) {
            if (!isset($ifExist)) {
                return new City([
                    'name' => $row[0],
                    'province_id' => $province->id
                ]);
            }
        }
    }
}
