<?php

use App\Models\Auction;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

//Schedule::call(function () {
//    $today = Carbon::now()->toDateString();
//    $deleted = Auction::whereDate('end_time', $today)->delete();
//
//    logger("$deleted expired auctions deleted.");
//})->daily();
