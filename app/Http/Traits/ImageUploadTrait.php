<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Boolean;

trait ImageUploadTrait
{

    public function uploadImage($name, $file, $folderNamePath): string
    {

            $fileName = $this->imageName($name, $file);

            $realPath = $folderNamePath . $fileName;

            Storage::disk('public')->put($realPath, File::get($file));

            $filePath   = 'storage/' . $realPath;

            return $filePath;

    }

    protected function imageName($fileName, $file): string
    {
        return Str::random(20) . '_' . date('d_m_Y_h_i_s') . $fileName . '.' . $file->getClientOriginalExtension();
    }

    protected function imageDelete($fileName): bool
    {
        if (file_exists(public_path($fileName))) {
            unlink(public_path($fileName));
            return true;
        } else {
            return false;
        }
    }
}
