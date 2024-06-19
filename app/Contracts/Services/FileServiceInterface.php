<?php
namespace App\Contracts\Services;

use App\Http\Requests\CsvUploadRequest;

interface FileServiceInterface
{

    public function postCsvDownload();

    public function postCsvUpload(CsvUploadRequest $request);
}
