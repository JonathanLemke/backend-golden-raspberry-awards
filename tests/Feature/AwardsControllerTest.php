<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Movie;

class AwardsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testImportCsvAndCallGetAwardsInterval()
    {

        $csvFilePath = storage_path('movies.csv');

        $csvData = file_get_contents($csvFilePath);

        $lines = explode("\n", $csvData);

        array_shift($lines);

        foreach ($lines as $line) {

            $data = str_getcsv($line, ';');

            if (count($data) === 5 && !empty($data[0]) && !empty($data[1]) && !empty($data[2]) && !empty($data[3]) && !empty($data[4])) {

                    Movie::create([
                        'year' => intval($data[0]),
                        'title' => $data[1],
                        'studios' => $data[2],
                        'producers' => $data[3],
                        'winner' => $data[4]
                    ]);
            }

        }

        $response = $this->get('/api/get-awards-interval');

        $response->assertStatus(200)->assertJsonStructure([
            'min' => [
                '*' => ['producer', 'interval', 'previousWin', 'followingWin'],
            ],
            'max' => [
                '*' => ['producer', 'interval', 'previousWin', 'followingWin'],
            ],
        ]);
    }
}
