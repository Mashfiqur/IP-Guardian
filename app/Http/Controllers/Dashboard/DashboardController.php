<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthenticationLog\AuthenticationLogResource;
use App\Models\AuthenticationLog;
use App\Models\IPAddress;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class DashboardController extends Controller 
{
    public function overview()
    {
        $overview = IPAddress::query()
            ->select([
                DB::raw('COUNT(*) as totalIPAddresses'),
                DB::raw('COUNT(CASE WHEN created_at >= DATE_FORMAT(NOW(), "%Y-%m-01") THEN 1 ELSE NULL END) as totalIPAddressesThisMonth'),
                DB::raw('COUNT(CASE WHEN created_at >= DATE_ADD(NOW(), INTERVAL -WEEKDAY(NOW()) DAY) THEN 1 ELSE NULL END) as totalIPAddressesThisWeek'),
            ])
            ->first();
        
        return response()->json([
            'total_ip_addresses'            => $overview->totalIPAddresses,
            'total_ip_addresses_this_month' => $overview->totalIPAddressesThisMonth,
            'total_ip_addresses_this_week'  => $overview->totalIPAddressesThisWeek,
        ]);
    }

    public function get_recent_login()
    {
        $logs = AuthenticationLog::query()
            ->with('user', function($query){
                $query->select('id', config('uuid.column'), 'name', 'email');
            })
            ->orderBy('login_at', 'DESC')
            ->take(10)
            ->get();

        return AuthenticationLogResource::collection($logs);
    }

}