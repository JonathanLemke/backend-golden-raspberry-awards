<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Movie;

class ImportCsvToDatabase extends Command
{

    protected $signature = 'import:csv {file}';
    protected $description = 'Import data from a CSV file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $csvFilePath = $this->argument('file');

        if (($handle = fopen($csvFilePath, 'r')) !== false) {
            $isFirstLine = true;
            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                if ($isFirstLine) {
                    $isFirstLine = false;
                    continue;
                }
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
            fclose($handle);
        }

        $this->info('CSV data imported successfully.');
    }
}
