<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    use AuthorizesRequests;

    public function view($id) {
        $note = Note::findOrFail($id);
        $this->authorize('view', $note);
        return view('note', compact('note'));
    }
}
