<?php

namespace App\Exports;

use App\TdSalesDetail;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Excel;

class TransactionExport implements FromView, Responsable
{
    use Exportable;

    private $fileName = 'transaction.xlsx';

    private $writerType = Excel::XLSX;

    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function view(): View
    {
        $query = TdSalesDetail::query()->with([
            'transaction.customer',
            'cluster',
            'type',
        ]);

        if ($this->query['from']) {
            $from = $this->query['from'];

            $query = $query->whereHas('transaction', function ($q) use ($from) {
                $q->where('date', '>=', $from);
            });
        }

        if ($this->query['to']) {
            $to = $this->query['to'];

            $query = $query->whereHas('transaction', function ($q) use ($to) {
                $q->where('date', '<=', $to);
            });
        }

        if ($this->query['cluster']) {
            $cluster = $this->query['cluster'];

            $query = $query->whereHas('cluster', function ($q) use ($cluster) {
                $q->where('name', 'like', '%' . $cluster . '%');
            });
        }

        if ($this->query['type']) {
            $type = $this->query['type'];

            $query = $query->whereHas('type', function ($q) use ($type) {
                $q->where('name', 'like', '%' . $type . '%');
            });
        }

        return view('report', [
            'details' => $query->get()
        ]);
    }
}
