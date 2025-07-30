<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'الفواتير ',
            'قائمة الفواتير',
            'الفواتير المدفوعة ',
            'الفواتير الغير المدفوعة',
            'الفواتيرالمدفوعة جزئيا ',
            'الفواتير المؤرشفة ',
            'التقارير',
            'تقارير الفواتير',
            'تقارير العملاء',
            'المستخدمين',
            'قائمة المستخدمين ' ,
            'صلاحيات المستخدمين ',
            'الاعدادات ',
            'الاقسام',
            'المنتجات',

            'اضافة فاتورة ',
            'حذف فاتورة ',
            'تصدير اكسيل ',
            'تغير حالة الدفع ',
            'تعديل فاتورة ',
            'ارشفة فاتورة',
            'طباعة فاتورة',
            'اضافة مرفق ',
            'حذف  مرفق ',

            'اضافة مستخدم ',
            'تعديل مستخدم ',
            'حذف مستخدم ',

            'عرض صلاحية ',
            'اضافة صلاحية ',
            'تعديل صلاحية ',
            'حذف صلاحية ',

            'اضافة منتج',
            'تعديل منتج',
            'حذف منتج ',

            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',


         ];

          // Looping and Inserting Array's Permissions into Permission Table
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}
