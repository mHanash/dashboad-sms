<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Network;
use App\Models\Phone;
use Maatwebsite\Excel\Concerns\ToModel;

use function PHPUnit\Framework\isEmpty;

class ImportPhone implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // ini_set('max_execution_time', 180);
        $city = City::where('name', $row[1])->first();
        $network = Network::where('name', $row[2])->first();
        $ifExist = Phone::where('number', '=', $row[0])->first();
        if (isset($city) && isset($network) && isset($row[0])) {
            if (!isset($ifExist)) {
                return new Phone([
                    'number' => $row[0],
                    'city_id' => $city->id,
                    'network_id' => $network->id
                ]);
            }
        }
    }
}
