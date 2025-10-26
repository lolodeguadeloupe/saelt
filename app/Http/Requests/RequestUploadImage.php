<?php

namespace App\Http\Requests;

class RequestUploadImage
{
    public static function upload($image, $repertoire)
    {
        $file = explode(";base64,", $image);
        /** */
        if (count($file) >= 2) {
            $fileSystem = new \Illuminate\Filesystem\Filesystem();
            /* */
            @list($encode, $base64string) = explode(',', $image);
            $base64data = base64_decode($base64string, true);
            /** */
            $fileExt = explode("/", $file[0])[1];
            $newFileName = \Illuminate\Support\Str::random(25) . '.' . $fileExt;

            if (!$fileSystem->isDirectory(public_path('uploads'))) {
                $fileSystem->makeDirectory(public_path('uploads'));
            }

            if (!$fileSystem->isDirectory(public_path('uploads/' . $repertoire))) {
                $fileSystem->makeDirectory(public_path('uploads/' . $repertoire));
            }
            $fileSystem->put(public_path('uploads/' . $repertoire . '/') . $newFileName, $base64data);
            /** */
            return 'uploads/' . $repertoire . '/' . $newFileName;
        }
        return $image;
    }
}

/**
 * public function download(Request $request) {
        $item = Tbc_AutomezzoAllegati::find($request->id);

        if (is_null($item)) {
            return response()->json(['op' => false, 'error' => Lang::get('errors.record_no_found')]);
        }

        $file_contents = base64_decode($item->file_upload);

       return response($file_contents)
                        ->header('Cache-Control', 'no-cache private')
                        ->header('Content-Description', 'File Transfer')
                        ->header('Content-Type', 'application/octet-stream')
                        ->header('Content-length', strlen($file_contents))
                        ->header('Content-Disposition', 'attachment; filename=' . $item->file_name)
                        ->header('Content-Transfer-Encoding', 'binary');
    }
 */