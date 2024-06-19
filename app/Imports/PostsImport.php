<?php

namespace App\Imports;

use App\Models\Posts;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class PostsImport implements ToModel, WithValidation, SkipsOnFailure 
{
    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Posts([
            'title' => $row[0],
            'description' => $row[1],
            'public_flag' => $row[2],
            'user_id' => $row[3]
        ]);

    }

    /**
     * Validation for csv rows
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '0' => 'required|string|max:255',
            '1' => 'max:2000',
            '2' => 'nullable',
            '3' => 'required|integer'
        ];
    }
}
