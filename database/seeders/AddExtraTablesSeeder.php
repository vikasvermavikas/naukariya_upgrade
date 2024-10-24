<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class AddExtraTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $migrations = [
            '2024_07_04_123223_add_column_delete_at_to_newsletters.php',
            '2024_07_31_105655_add_column_reason_to_newsletters.php',
            '2024_08_05_163230_add_column_remember_token_to_sub_users.php',
            '2024_08_20_101916_create_blogs_table.php',
            '2024_08_27_131533_create_parent_industries_table.php',
            '2024_08_27_150359_add_column__parent_id_to_parent_industries.php',
            '2024_08_27_171830_add_column_image_to_parent_industries.php',
            '2024_09_05_154000_add_column_index_to_trackers.php',
            '2024_09_09_114109_create_mail_messages_table.php',
            '2024_09_10_124903_add_column_google_token_to_all_users.php',
            '2024_09_11_102926_create_mail_resume_datas_table.php',
            '2024_09_14_102830_add_column_google_token_to_sub_users.php',
            '2024_09_14_111957_add_column_exported_by_to_mail_messages.php',
            '2024_09_16_153022_create_job_seeker_notifications_table.php',
            '2024_09_18_163410_add_column_status_url_to_mail_resume_datas.php',
            '2024_10_09_142040_create_tracker_selections_table.php',
            '2024_10_09_172112_create_tracker_interviews_table.php'
        ];

        for ($i=0; $i <count($migrations) ; $i++) { 
             Artisan::call('migrate', [
            '--path' => '/database/migrations/'.$migrations[$i].''
            ]);   
        }
       
          // Now run your seeders
        $this->call([
            
            ]);
        

    }
}
