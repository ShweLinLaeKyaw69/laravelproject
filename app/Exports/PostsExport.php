<?php

namespace App\Exports;

use App\Models\Posts;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Posts::all();
    }
}
