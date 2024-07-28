<?php

namespace App\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;

class FileUpload extends Component
{
    use AuthorizesRequests;
    use InteractsWithBanner;


    public function getLinks($files)
    {
        $this->authorize('create', File::class);

        $res = [];
        foreach ($files as $file) {
            if (!isset($file['name'])) {
                throw new \Exception("File name is required");
            }
            // TODO we want to alias 'name' with an obfuscated name that maps to the real name
            $randomBytes = random_bytes(16);
            $randomId = bin2hex($randomBytes);
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $path = $randomId . '.' . $ext;

            ['url' => $url, 'headers' => $headers] = Storage::disk('s3')->temporaryUploadUrl(
                $path, now()->addMinutes(5)
            );
            $res []= [
                'name' => $file['name'],
                'path' => $path,
                'upload_url'=> $url,
                'headers'=> $headers,
            ];

        }
        return $res;
    }

    public function createFiles($files){

        $this->authorize('create', File::class);
        foreach ($files as $file) {
            if (!isset($file['name'])) {
                $this->addError("name", "File name is required");
            }
            if (!isset($file['path'])) {
                $this->addError("path", "File path is required");
            }
            if (count($this->getMessages()) > 0) {
                return;
            }
            auth()->user()->currentTeam->files()->create($file);
        }
    }

    public function render()
    {
        return <<<'HTML'
        <div x-data="fileupload">
            <div class="flex items-center justify-center w-full">
                <div class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100"
                    x-on:dragover.prevent="dragOver()" x-on:drop.prevent="dropHandler($event)">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Drag files here to upload</p>
                        <p class="text-xs text-gray-500">Any file, no maximum size.</p>
                          <template x-for="file in files">
                            <p class="text-sm text-gray-500">
                                <span x-text="file.file.name"></span>-
                                <span x-text="prettySize(file.file.size)"></span>
                            </p>
                        </template>
                    </div>
                </div>
            </div>
            <button class="mt-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:cursor-pointer hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150"
                x-on:click.prevent="submit(files)">
                Upload
            </button>
        </div>
        @script
        <script>
            Alpine.data('fileupload', () => ({

                files: [],
                prettySize(bytes) {
                    if (bytes < 1024) {
                        return bytes + ' b';
                    } else if (bytes < 1048576) {
                        return (bytes / 1024).toFixed(0) + ' kb';
                    }
                    return (bytes / 1048576).toFixed(1) + ' mb';
                },
                dragOver(ev) {
                //     do nothing

                },

                dropHandler(ev) {
                  console.log("File(s) dropped");


                  if (ev.dataTransfer.items) {
                    // Use DataTransferItemList interface to access the file(s)
                    [...ev.dataTransfer.items].forEach((item, i) => {
                      // If dropped items aren't files, reject them
                      if (item.kind === "file") {
                        const file = item.getAsFile();
                        this.files.push({file});
                      }
                    });
                  } else {
                    // Use DataTransfer interface to access the file(s)
                    [...ev.dataTransfer.files].forEach((file, i) => {
                        this.files.push({file});
                    });
                  }
                },
                async submit(files) {
                    const urls = await $wire.getLinks(files.map((f)=>({name: f.file.name})));
                    console.log('presigned urls:', urls);

                    const promises = [];
                    for (let i = 0; i < urls.length; i++) {
                        const url = urls[i];
                        const file = files[i]
                        promises.push(
                            (async (i, url, file) => {
                                const uploadToSignedURL = await fetch(url.upload_url, {
                                    headers: url.headers,
                                    method: "PUT",
                                    body: file.file
                                })
                                if (uploadToSignedURL.status === 200) {
                                    // create this file
                                    console.log('uploadOK:', url.path, file.file.name )
                                    this.files[i].ok = true
                                } else {
                                    console.error('file upload is not OK uhoh!', file.file.name)
                                    this.files[i].ok = false
                                }
                            })(i, url, file));
                    }
                    await Promise.all(promises);
                    console.log('finished uploading everything: creating models');
                    const createFilesRes = await $wire.createFiles(files.map((m, i) => ({
                        name: m.file.name,
                        path: urls[i].path
                    })))
                    console.log('finished creating files', createFilesRes);
                    window.location.reload();
                    // NOW signal the backend to create the file objects :O :O
                //     TODO redirect or put up banner or something...

                }
            }))

        </script>
        @endscript
        HTML;
    }
}
