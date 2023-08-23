<?php

namespace App\Http\Controllers\File;

use App\Models\Attachment;
//use App\Models\Schedule_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Bbs_files;
//use Illuminate\Support\File;
use Illuminate\Support\Str;
//use Monolog\Logging;

/**
 * 파일 엄로드/다운로드
 *
 * Class FileController
 * @package App\Http\Controllers
 */
class FileController
{

    /**
     * 업로드
     *
     * @param Request $request
     * @param string $path
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, $path)
    {

        try {
            if ($request->hasFile('file')) {
                $file_arr = $request->file('file');
                $filename = $file_arr->getClientOriginalName();
                // other methods
                $time        = $file_arr->getATime();
                //$size        = $file_arr->getSize();
                $ext         = $file_arr->getClientOriginalExtension();
                //$mime_type = $file_arr->getClientMimeType();
                $rand = Str::random(40);
                $file_path = $time  . '_' . $rand . '.' . $ext;
                $stored_path = $file_arr->storeAs('public/upload/'.$path, $file_path);

                if ($stored_path !== false) {
                    \File::chmod(\Storage::path($stored_path), 0777);

                    return [
                        'result' => true,
                        'stored_path' => 'upload/'.$path.'/'.$file_path,
                        'real_name' => $filename
                        ,'stored_path' => $stored_path
                    ];
                } else {
                    return response()->json(['message' => '파일 업로드에 실패했습니다.'], 500);
                }
            }
        } catch (\Exception $e) {
            Logging::logWrite('error', 'File Upload Error : '.$e->getMessage());
        }

    }

    /**
     * 업로드
     *
     * @param Request $request
     * @param string $path
     * @param string $file_value
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload_array(Request $request, $path, $file_value)
    {
        try {
            if ($request->hasFile($file_value)) {
                $file_arr = $request->file($file_value);
                $filename = $file_arr->getClientOriginalName();
                // other methods
                $time        = $file_arr->getATime();
                //$size        = $file_arr->getSize();
                $ext         = $file_arr->getClientOriginalExtension();
                //$mime_type = $file_arr->getClientMimeType();
                $rand = str_random(40);

                $file_path = $time  . '_' . $rand . '.' . $ext;
                $stored_path = $file_arr->storeAs('public/upload/'.$path, $file_path);

                if ($stored_path !== false) {
                    \File::chmod(\Storage::path($stored_path), 0664);

                    return [
                        'result' => true,
                        'stored_path' => 'upload/'.$path.'/'.$file_path,
                        'real_name' => $filename
                    ];
                } else {

                    return [
                        'result' => false,
                        'stored_path' => '',
                        'real_name' => ''
                    ];
                }
            }
        } catch (\Exception $e) {
            Logging::logWrite('error', 'File Upload Error : '.$e->getMessage() . ' // ' .$stored_path);
        }

    }

    /**
     * 게시판 - 파일 다운로드
     *
     * @param Attachment $attachment
     * @return mixed
     */
    public function download2($sid)
    {

        $attachment = Attachment::find($sid);

//        var_dump($attachment->path); exit;
//
        if (Storage::exists($attachment->path) === false) {
            abort(404);
        }

        $attachment->downloads += 1;
        $attachment->save();

        return response()->download(Storage::path($attachment->path), $attachment->filename);
    }

    public function download($sid)
    {

        $bbs_files = Bbs_files::find($sid);

//        var_dump($attachment->path); exit;
//
        if (Storage::exists($bbs_files->path) === false) {
            abort(404);
        }

        $bbs_files->downloads += 1;
        $bbs_files->save();

        return response()->download(Storage::path($bbs_files->path), $bbs_files->filename);
    }


    /**
     * 연구 - 파일 다운로드
     *
     * @param Schedule_attachment $attachment
     * @return mixed
     */
    public function file_download(Schedule_attachment $attachment)
    {

        if (\Storage::exists('public/'.$attachment->path) === false) {
            abort(404);
        }

        $attachment->downloads += 1;
        $attachment->save();

        return response()->download(\Storage::path('public/'.$attachment->path), $attachment->filename);
    }

    /**
     * 삭제
     *
     * @param Attachment $attachment
     * @return mixed
     */
    public function delete($path)
    {
        try {
            if (Storage::exists('public/'.$path)) {
                Storage::delete('public/'.$path);
            }
        } catch (\Exception $e) {
            Logging::logWrite('error', 'File Delete Error : '.$e->getMessage());
        }

    }

    /**
     * 삭제
     *
     * @param Schedule_attachment $attachment
     * @return mixed
     */
    public function file_delete($attachment)
    {

        try {
            foreach ($attachment as $at){
                if (Storage::exists($at->path)) {
                    Storage::delete($at->path);
                }
            }
        } catch (Exception $e) {
            Logging::logWrite('error', 'File Delete Error : '.$e->getMessage());
        }

    }

}
