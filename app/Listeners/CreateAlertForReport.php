<?php

namespace App\Listeners;

use App\Events\ReportAuthorized;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Alerts;

class CreateAlertForReport {
  /**
   * Create the event listener.
   */
  public function __construct() {
    //
  }

  /**
   * Handle the event.
   */
  public function handle(ReportAuthorized $event): void {
    $report = $event->report;

    $alert = new Alerts();
    $alert->title = $report->title;
    $alert->content = $report->description;
    $alert->type = 'evacuacion';
    $alert->status = 'active';
    $alert->simulacrum = false;
    $alert->save();
  }
}
