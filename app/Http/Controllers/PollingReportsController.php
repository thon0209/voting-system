<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PollingResource as PollingResource;
use App\Polling;
use PDF;

class PollingReportsController extends Controller
{

    public function pdf()
    {
        $logs = Polling::all();
        $count = $logs->count();
        $output = '
            <title>Vote Logs</title>
            <div style="font-family:sans-serif;">
                <h4>Voting System</h4>
                <div style="margin-top: -110px; word-wrap: break-word;">
                    <h6>Print Date time: '.date("Y-m-d h:i").'</h6>
                </div>
            </div>

            <div style="margin-top: -20px;">

            <table style="border: 1px solid black; border-collapse: collapse; width:100%; ">
              <thead>
                <tr>
                    <th style="border: 1px solid black; border-collapse: collapse; text-align:center; font-size:12px; width:15%;">Student ID</th>
                    <th style="border: 1px solid black; border-collapse: collapse; text-align:center; font-size:12px;">Candidate Name</th>
                    <th style="border: 1px solid black; border-collapse: collapse; text-align:center; font-size:12px; width:15%;">Date Time Vote</th>
                </tr>
              </thead>
              <tbody>';
              
            foreach($logs as $item)
            { 
                $output .= '
                <tr>
                    <td style="border: 1px solid black; border-collapse: collapse; text-align:center; height:2%; font-size:12px;">'.$item->user->username.'</td>
                    <td style="border: 1px solid black; border-collapse: collapse; text-align:center; font-size:12px;">'.$item->candidate->full_name.'</td>
                    <td style="border: 1px solid black; border-collapse: collapse; text-align:center; font-size:12px;">'.$item->timestamp_vote.'</td>
                </tr>
                ';
            }
        $output .= '
            </tbody></table></div>
            <p style="font-size:12px;">Total votes: '.$count.'</p>
            </div>
        ';

        $pdf = \App::make('dompdf.wrapper');
        $pdf -> loadHTML($output)
             -> setPaper('folio','portrait');
        return $pdf->stream();
            
    }
}
