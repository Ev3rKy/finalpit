<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bill;
use Carbon\Carbon;

class BillSeeder extends Seeder
{
    public function run(): void
    {
        $bills = [
            ['bill_no'=>'#BL-2001','patient_name'=>'Juan Dela Cruz',    'patient_id'=>'P-001','ward_id'=>1,'service'=>'Room + Treatment',  'amount'=>12400,'due_date'=>'2026-04-10','status'=>'paid'],
            ['bill_no'=>'#BL-2002','patient_name'=>'Ana Santos',        'patient_id'=>'P-002','ward_id'=>2,'service'=>'Consultation',        'amount'=>3200, 'due_date'=>'2026-04-30','status'=>'pending'],
            ['bill_no'=>'#BL-2003','patient_name'=>'Carlo Reyes',       'patient_id'=>'P-003','ward_id'=>5,'service'=>'Services + Meds',     'amount'=>21300,'due_date'=>'2026-04-28','status'=>'pending'],
            ['bill_no'=>'#BL-2004','patient_name'=>'Sofia Lim',         'patient_id'=>'P-004','ward_id'=>2,'service'=>'Consultation',        'amount'=>2200, 'due_date'=>'2026-04-12','status'=>'paid'],
            ['bill_no'=>'#BL-2005','patient_name'=>'Mark Bautista',     'patient_id'=>'P-005','ward_id'=>3,'service'=>'Surgery + Room',      'amount'=>58000,'due_date'=>'2026-04-20','status'=>'paid'],
            ['bill_no'=>'#BL-2006','patient_name'=>'Lena Villanueva',   'patient_id'=>'P-006','ward_id'=>1,'service'=>'Room + Treatment',    'amount'=>9800, 'due_date'=>'2026-04-22','status'=>'paid'],
            ['bill_no'=>'#BL-2007','patient_name'=>'Jose Rizal Jr.',    'patient_id'=>'P-007','ward_id'=>4,'service'=>'Medicines',           'amount'=>1500, 'due_date'=>'2026-04-25','status'=>'paid'],
            ['bill_no'=>'#BL-2008','patient_name'=>'Grace Tan',         'patient_id'=>'P-008','ward_id'=>1,'service'=>'Room + Meds',         'amount'=>7600, 'due_date'=>'2026-04-27','status'=>'paid'],
            ['bill_no'=>'#BL-2009','patient_name'=>'Ramon Diaz',        'patient_id'=>'P-009','ward_id'=>3,'service'=>'Treatment',           'amount'=>4300, 'due_date'=>'2026-05-01','status'=>'pending'],
            ['bill_no'=>'#BL-2010','patient_name'=>'Cynthia Flores',    'patient_id'=>'P-010','ward_id'=>5,'service'=>'Surgery',             'amount'=>72000,'due_date'=>'2026-05-03','status'=>'pending'],
            ['bill_no'=>'#BL-2011','patient_name'=>'Ana Santos',        'patient_id'=>'P-002','ward_id'=>2,'service'=>'Follow-up',           'amount'=>5400, 'due_date'=>'2026-04-30','status'=>'pending'],
            ['bill_no'=>'#BL-2012','patient_name'=>'Pedro Mendoza',     'patient_id'=>'P-011','ward_id'=>4,'service'=>'Emergency',           'amount'=>18200,'due_date'=>'2026-04-18','status'=>'paid'],
            ['bill_no'=>'#BL-2013','patient_name'=>'Iris Castillo',     'patient_id'=>'P-012','ward_id'=>2,'service'=>'Services + Meds',     'amount'=>6700, 'due_date'=>'2026-05-05','status'=>'pending'],
            ['bill_no'=>'#BL-2014','patient_name'=>'Ben Aguilar',       'patient_id'=>'P-013','ward_id'=>1,'service'=>'Room + Treatment',    'amount'=>11000,'due_date'=>'2026-05-06','status'=>'pending'],
            ['bill_no'=>'#BL-2015','patient_name'=>'Carlo Reyes',       'patient_id'=>'P-003','ward_id'=>5,'service'=>'Post-op Care',        'amount'=>8900, 'due_date'=>'2026-04-28','status'=>'pending'],
            ['bill_no'=>'#BL-2016','patient_name'=>'Nora Buenaventura', 'patient_id'=>'P-014','ward_id'=>3,'service'=>'Consultation',        'amount'=>2800, 'due_date'=>'2026-04-29','status'=>'paid'],
            ['bill_no'=>'#BL-2017','patient_name'=>'Tony Ramos',        'patient_id'=>'P-015','ward_id'=>1,'service'=>'Surgery + Room',      'amount'=>95000,'due_date'=>'2026-05-08','status'=>'pending'],
            ['bill_no'=>'#BL-2018','patient_name'=>'Eileen Cruz',       'patient_id'=>'P-016','ward_id'=>4,'service'=>'Medicines',           'amount'=>3100, 'due_date'=>'2026-05-09','status'=>'paid'],
            ['bill_no'=>'#BL-2019','patient_name'=>'Maria Alcantara',   'patient_id'=>'P-017','ward_id'=>1,'service'=>'Services + Meds',     'amount'=>8750, 'due_date'=>'2026-04-25','status'=>'pending'],
            ['bill_no'=>'#BL-2020','patient_name'=>'Leo Santos',        'patient_id'=>'P-018','ward_id'=>2,'service'=>'Consultation',        'amount'=>1800, 'due_date'=>'2026-04-16','status'=>'paid'],
            ['bill_no'=>'#BL-2021','patient_name'=>'Mia Roque',         'patient_id'=>'P-019','ward_id'=>5,'service'=>'Room + Treatment',    'amount'=>13400,'due_date'=>'2026-05-01','status'=>'pending'],
            ['bill_no'=>'#BL-2022','patient_name'=>'Dante Aquino',      'patient_id'=>'P-020','ward_id'=>3,'service'=>'Emergency',           'amount'=>22000,'due_date'=>'2026-04-14','status'=>'paid'],
            ['bill_no'=>'#BL-2023','patient_name'=>'Rowena Gutierrez',  'patient_id'=>'P-021','ward_id'=>4,'service'=>'Surgery',             'amount'=>47500,'due_date'=>'2026-05-10','status'=>'pending'],
            ['bill_no'=>'#BL-2024','patient_name'=>'Roberto Cruz',      'patient_id'=>'P-022','ward_id'=>3,'service'=>'Surgery + Room',      'amount'=>45000,'due_date'=>'2026-04-15','status'=>'overdue'],
        ];

        foreach ($bills as $bill) {
            $data = $bill;
            if ($data['status'] === 'paid') {
                $data['paid_at'] = Carbon::parse($data['due_date'])->subDays(rand(1, 5));
            }
            Bill::create($data);
        }
    }
}
