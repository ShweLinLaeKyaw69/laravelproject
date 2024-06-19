<?php

namespace App\Services;

use App\Contracts\Dao\PostDaoInterface;
use App\Contracts\Dao\UserDaoInterface;
use App\Contracts\Services\FileServiceInterface;
use App\Exports\PostsExport;
use App\Http\Requests\AdminPasswordStoreRequest;
use App\Http\Requests\CsvUploadRequest;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileService implements FileServiceInterface
{
    protected $userDao;
    protected $postDao;

    /**
     * Constructor for FileService class.
     *
     * @param UserDaoInterface $userDao
     * @param PostDaoInterface $postDao
     */
    public function __construct(UserDaoInterface $userDao, PostDaoInterface $postDao)
    {
        $this->userDao = $userDao;
        $this->postDao = $postDao;
    }

    /**
     * Download csv file
     *
     * @return BinaryFileResponse
     */
    public function postCsvDownload(): BinaryFileResponse
    {
        return Excel::download(new PostsExport, 'posts_' . time() . '.csv');
    }

    /**
     * Csv upload for post
     *
     * @param CsvUploadRequest $request
     * @return bool
     */
    public function postCsvUpload(CsvUploadRequest $request): bool
    {
        return $this->postDao->csvImport($request);
    }
}
