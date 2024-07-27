<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;

class FileUploadController extends Controller
{
    use AuthorizesRequests;
    use InteractsWithBanner;

    public function index(Request $request) {
//        why is this unauth
        $this->authorize('viewAny', File::class);
        $files = auth()->user()->currentTeam->files()->latest()->paginate();
        return view('files', compact('files'));
    }
    public function view($id) {
        $file = File::findOrFail($id);
        $this->authorize('view', $file);
        return view('file', compact('file'));
    }

    public function delete($id) {
        $file = File::findOrFail($id);
        $this->authorize('delete', $file);
        $file->delete();
        return redirect()->back();
    }

    private function storage(): string {
        $storage = 's3';
//        if (env('APP_ENV') != 'production') {
//            $storage = 'local';
//        }
        return $storage;
    }
    public function upload(Request $request) {
        $this->authorize('create', File::class);


        $request->validate(['file'=>'required|file']);
        $f = $request->file('file');

        if($f->isValid()) {
            $path = $f->store('uploads', $this->storage());
            auth()->user()->currentTeam->files()->create([
                'path' => $path,
                'name' => $f->getClientOriginalName()
            ]);
//            $this->banner("Uploaded ". $f->getClientOriginalName());
            return redirect()->back();
        }
//         it is an error with the upload

        return redirect()->back();
    }

//    TODO we should also be able to generate a presigned url for uploading a file

    /**
     * Link generates a presigned URL for viewing the file
     * @param $id
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function link($id) {
        $file = File::findOrFail($id);
        $this->authorize('view', $file);
        return $file->url;
    }
    public function download($id) {
        $file = File::findOrFail($id);
        $this->authorize('view', $file);
        return Storage::disk($this->storage())->download($file->path);
    }
}
