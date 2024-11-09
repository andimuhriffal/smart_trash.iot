<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganikLevel;
use App\Models\AnorganikLevel;

class DashboardController extends Controller
{
    public function getOrganikData()
    {
        $data = OrganikLevel::latest()->first();

        return response()->json([
            'distance1' => $data ? $data->distance1 : 0
        ]);
    }

    public function getAnorganikData()
    {
        $data = AnorganikLevel::latest()->first();

        return response()->json([
            'distance2' => $data ? $data->distance2 : 0
        ]);
    }

    public function storeOrganikData(Request $request)
    {
        $validatedData = $request->validate([
            'distance1' => 'required|numeric',
        ]);

        $organikLevel = new OrganikLevel();
        $organikLevel->distance1 = $validatedData['distance1'];
        $organikLevel->save();

        return response()->json([
            'message' => 'Data organik berhasil disimpan.',
            'data' => $organikLevel
        ], 201);
    }

    public function storeAnorganikData(Request $request)
    {
        $validatedData = $request->validate([
            'distance2' => 'required|numeric',
        ]);

        $anorganikLevel = new AnorganikLevel();
        $anorganikLevel->distance2 = $validatedData['distance2'];
        $anorganikLevel->save();

        return response()->json([
            'message' => 'Data anorganik berhasil disimpan.',
            'data' => $anorganikLevel
        ], 201);
    }
}
