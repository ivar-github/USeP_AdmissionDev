<?php
    namespace App\Exports;

    use App\Models\ScheduleView;
    use Maatwebsite\Excel\Concerns\FromQuery;
    use Maatwebsite\Excel\Concerns\WithHeadings;

    class ScheduleOverallExport implements FromQuery, WithHeadings
    {
        protected $columns;
        protected $filters;

        public function __construct(array $columns, array $filters)
        {
            $this->columns = $columns;
            $this->filters = $filters;
        }

        public function query()
        {
            return ScheduleView::query()
                ->select($this->columns)
                ->where('TermID', $this->filters['termID'])
                ->when($this->filters['centerID'] != 0, fn($query) => $query->where('testCenterID', $this->filters['centerID']))
                ->when($this->filters['dateFromID'] && $this->filters['dateToID'], fn($query) => $query->whereBetween('testDate', [$this->filters['dateFromID'], $this->filters['dateToID']]))
                ->when($this->filters['dateFromID'] && !$this->filters['dateToID'], fn($query) => $query->where('testDate', '>=', $this->filters['dateFromID']))
                ->when(!$this->filters['dateFromID'] && $this->filters['dateToID'], fn($query) => $query->where('testDate', '<=', $this->filters['dateToID']))
                ->orderBy('Name', 'asc')
                ->when($this->filters['search'], function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('Name', 'LIKE', '%' . $search . '%')
                        ->orWhere('appNo', 'LIKE', '%' . $search . '%');
                    });
                });
        }

        public function headings(): array
        {
            return $this->columns;
        }
    }
?>