<?php

namespace App\Http\Controllers;

use App\Models\AssetType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request) {
//        return assets which have a null team_id OR the ones that belong to my team
        $this->authorize('viewAny', AssetType::class);
        $globalAssetTypes = AssetType::whereNull('team_id')->get();
        $teamTypes = auth()->user()->currentTeam->assetTypes()->latest()->paginate();
        return view('assettype.index', compact('globalAssetTypes', 'teamTypes'));
    }
    public function view($id) {
//        TODO authz
        $assetType = AssetType::findOrFail($id);
        return view("assettype.view", compact("assetType"));
    }

    public function create(Request $request) {
        $this->authorize('create', AssetType::class);
        $asset = null;
        return view('assettype.new', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $asset = AssetType::findOrFail($id);
        $this->authorize('update', $asset);
        return view('assettype.new', compact('asset'));
    }

    // the edit handler?
    public function show($id) {
        // alias for the view page now
        return $this->view($id);
    }

    public function destroy($id) {
        $asset = AssetType::findOrFail($id);
        $this->authorize('delete', $asset);
        $asset->delete();
        return redirect()->route('structure.index');
    }
}
