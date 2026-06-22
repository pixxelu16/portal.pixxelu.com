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
    //Get request id export inquery course type
    protected $course_type;

    public function __construct($course_type) {
        $this->course_type = $course_type;
    }

    //Function for get all inqueries 
    public function collection() {
        //Get inqueries details
        $query = Inquery::orderBy('id', 'DESC');
        //Filter inqueries acc course type
        if ($this->course_type !== 'all') {
            $query->where('course_type', $this->course_type);
        } 
        
        $inqueries = $query->get();
        
        $data = [];

        foreach ($inqueries as $inquery) {
            $data[] = [
                'name' => $inquery->name ?? '-',
                'mobile' => $inquery->mobile ?? '-',
                'address' => $inquery->address ?? '-',
                'course_type' => $inquery->course_type ?? '-',
                'created_at' => $inquery->created_at->format('Y-m-d') ?? '-',
                'priority' => $inquery->priority ?? '-',
                'visit' => $inquery->visit ?? '-',
                'total_fees' => isset($inquery->total_fees) ? number_format($inquery->total_fees, 0, '.', ',') : '-',
                'status' => $inquery->status ?? '-',
            ];
        }

        return collect($data);
    }

    //Function for heading CSV file
    public function headings(): array {
        return ['Name', 'Mobile', 'Address', 'Course Type', 'Inquery Date', 'Priority', 'Visit By', 'Total Fees', 'Status'];
    }
}
