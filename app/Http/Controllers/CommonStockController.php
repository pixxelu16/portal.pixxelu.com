<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Employee;
use App\Models\StudentAssignAccessories;
use App\Models\StudentDamageAccessories;
use App\Models\EmployeeAssignAccessories;
use App\Models\Stock;

class CommonStockController extends Controller
{

    public function submit_stock(Request $request) {
        //Get stock record
        $stock = Stock::first();
    
        //Calculate total assigned keyboards and mouse students and employees
        $totalKeyboardAssignedStudents = StudentAssignAccessories::sum('keyboard_assigned');
        $totalMouseAssignedStudents = StudentAssignAccessories::sum('mouse_assigned');
        $totalKeyboardAssignedEmployees = EmployeeAssignAccessories::sum('keyboard_assigned');
        $totalMouseAssignedEmployees = EmployeeAssignAccessories::sum('mouse_assigned');
    
        //Calculate combined total assigned keyboards and mouse
        $totalKeyboardAssigned = $totalKeyboardAssignedStudents + $totalKeyboardAssignedEmployees;
        $totalMouseAssigned = $totalMouseAssignedStudents + $totalMouseAssignedEmployees;
    
        if ($stock) {
                //Update existing stock
                $stock->total_keyboard_stock += $request->total_keyboard_stock;
                $stock->total_mouse_stock += $request->total_mouse_stock;
                $stock->assign_keyboard = $totalKeyboardAssigned;
                $stock->assign_mouse = $totalMouseAssigned;
                $stock->save();
    
                return back()->with('success', 'Stocks created successfully.');
     
        } else {
            //Create new stock record
            $newStock = Stock::create([
                'total_keyboard_stock' => $request->total_keyboard_stock,
                'total_mouse_stock' => $request->total_mouse_stock,
                'assign_keyboard' => $totalKeyboardAssigned,
                'assign_mouse' => $totalMouseAssigned,
            ]);
            
            //Check if stock is created or not
            return back()->with('success', 'Stocks created successfully.');
        }
    }   
}
