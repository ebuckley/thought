<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AssetType $asset_type)
    {
        // TODO pagination page
        $assets = auth()->user()->currentTeam->assets()->where('asset_type_id', $asset_type->id)->paginate();
        return view('asset.index', compact('assets', 'asset_type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(AssetType $asset_type)
    {
        $assetType = $asset_type; // weird but the view depends on camelcase
        return view('assettype.view', compact('assetType'));
    }


    /**
     * Display the specified resource.
     */
    public function show(AssetType $asset_type, Asset $asset)
    {
        return view('asset.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetType $asset_type, Asset $asset)
    {
        $assetType = $asset_type;
        return view('asset.edit', compact('asset', 'assetType'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetType $asset_type, Asset $asset)
    {
        $asset->delete();
        return redirect()->route('structure.asset', [$asset_type]);
    }

    public function listExpirations()
    {
        $assetsWithExpiration = Asset::getAssetsWithExpiration();
        return view('asset.expirations', compact('assetsWithExpiration'));
    }

}
