<?php
namespace App\Helpers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
class ExcelExportHelper {
    public static function exportAgents($agents) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'No HP');
        $row = 2;
        foreach ($agents as $agent) {
            $sheet->setCellValue('A'.$row, $agent->name);
            $sheet->setCellValue('B'.$row, $agent->email);
            $sheet->setCellValue('C'.$row, $agent->phone);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'agents_export_'.date('Ymd_His').'.xlsx';
        $path = storage_path('app/public/'.$filename);
        $writer->save($path);
        return $path;
    }
    public static function exportDevices($devices) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'User');
        $sheet->setCellValue('B1', 'Tipe');
        $sheet->setCellValue('C1', 'Merk');
        $sheet->setCellValue('D1', 'Model');
        $sheet->setCellValue('E1', 'Serial Number');
        $sheet->setCellValue('F1', 'Deskripsi');
        $row = 2;
        foreach ($devices as $device) {
            $sheet->setCellValue('A'.$row, $device->user->name ?? '-');
            $sheet->setCellValue('B'.$row, $device->type);
            $sheet->setCellValue('C'.$row, $device->brand);
            $sheet->setCellValue('D'.$row, $device->model);
            $sheet->setCellValue('E'.$row, $device->serial_number);
            $sheet->setCellValue('F'.$row, $device->description);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'devices_export_'.date('Ymd_His').'.xlsx';
        $path = storage_path('app/public/'.$filename);
        $writer->save($path);
        return $path;
    }

    public static function exportMaintenanceSchedules($schedules) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'User');
        $sheet->setCellValue('B1', 'Agent');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Status');
        $row = 2;
        foreach ($schedules as $schedule) {
            $sheet->setCellValue('A'.$row, $schedule->user->name ?? '-');
            $sheet->setCellValue('B'.$row, $schedule->agent->name ?? '-');
            $sheet->setCellValue('C'.$row, $schedule->scheduled_date);
            $sheet->setCellValue('D'.$row, $schedule->status);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'maintenance_schedules_export_'.date('Ymd_His').'.xlsx';
        $path = storage_path('app/public/'.$filename);
        $writer->save($path);
        return $path;
    }
}
