<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ActivityExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view( 'system.exports.activity', [
            'data' => $this->data
        ] );
    }

}
