<?php

namespace App\Exports;

use App\Models\Inquery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportInquery implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    //Function for get all inqueries 
    public function collection() {
        //Get inqueries details
        $inqueries = Inquery::orderBy('id', 'DESC')->get(); 
        $data = [];

        foreach ($inqueries as $inquery) {
            $data[] = [
                'name' => $inquery->name,
                'mobile' => $inquery->mobile,
                'address' => $inquery->address,
                'course_type' => $inquery->course_type,
                'created_at' => $inquery->created_at->format('Y-m-d'),
                'priority' => $inquery->priority,
                'status' => $inquery->status,
            ];
        }

        return collect($data);
    }

    //Function for heading CSV file
    public function headings(): array {
        return ['Name', 'Mobile', 'Address', 'Course Type', 'Inquery Date', 'Priority', 'Status'];
    }
}
