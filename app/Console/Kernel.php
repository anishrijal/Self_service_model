<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\image;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->call(function (){
             $pictures = image::all()->pluck('img_url');
             $images = Storage::files('/');
             foreach ($images as $i) {
                 $image = '/uploads/' . $i;
                 if (!in_array($image, $pictures->toArray())) {
                     Storage::delete($i);
                 }
             }
         })->cron('59 2 1 * *');
    }
}
