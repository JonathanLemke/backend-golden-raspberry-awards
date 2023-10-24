<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportCsvToDatabase extends Command
{

    protected $signature = 'import:csv {path}';
    protected $description = 'Import a Cgit sSV file into the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $csvFilePath = $this->argument('path');

        if (!file_exists($csvFilePath)) {
            $this->error('CSV file not found.');
            return;
        }

        if (($handle = fopen($csvFilePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                TempCsv::create([
                    'year' => $data[0],
                    'title' => $data[1],
                    'studios' => $data[2],
                    'producers' => $data[3],
                    'winner' => $data[4],
                ]);
            }
            fclose($handle);
            $this->info('CSV data imported successfully.');
        } else {
            $this->error('Error reading CSV file.');
        }
    }
}
