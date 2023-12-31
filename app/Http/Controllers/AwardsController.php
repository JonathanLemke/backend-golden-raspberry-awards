<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class AwardsController extends Controller
{
//
    public function getAwardsInterval()
    {
        $longestGapProducers = Movie::select('movies.producers as producer')
            ->addSelect(DB::raw('MAX(movies.year - subq.lag) as interval'))
            ->addSelect(DB::raw('MAX(subq.lag) as previousWin'))
            ->addSelect(DB::raw('MAX(movies.year) as followingWin'))
            ->joinSub(
                Movie::select('producers', 'year', DB::raw('LAG(year) OVER (PARTITION BY producers ORDER BY year) as lag')),
                'subq',
                'movies.producers',
                'subq.producers'
            )
            ->groupBy('movies.producers')
            ->orderByDesc('interval')
            ->get();

        $fastestTwoAwardsProducers = Movie::select('producers as producer')
            ->addSelect(DB::raw('MIN(year) as previousWin'))
            ->addSelect(DB::raw('MAX(year) as followingWin'))
            ->groupBy('producers')
            ->havingRaw('COUNT(*) >= 2')
            ->orderByRaw('MAX(year) - MIN(year)')
            ->get();

        $response = [
            'min' => $fastestTwoAwardsProducers->map(function ($producer) {
                return [
                    'producer' => $producer->producer,
                    'interval' => $producer->followingWin - $producer->previousWin,
                    'previousWin' => $producer->previousWin,
                    'followingWin' => $producer->followingWin,
                ];
            }),
            'max' => $longestGapProducers->map(function ($producer) {
                return [
                    'producer' => $producer->producer,
                    'interval' => $producer->interval,
                    'previousWin' => $producer->previousWin,
                    'followingWin' => $producer->followingWin,
                ];
            }),
        ];

        return response()->json($response);
    }
}
