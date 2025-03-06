<?php
    namespace App\Exports;

    use App\Models\ScheduleViewSlot;
    use Maatwebsite\Excel\Concerns\FromQuery;
    use Maatwebsite\Excel\Concerns\WithHeadings;

    class ExportScheduleSlot implements FromQuery, WithHeadings
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
            return ScheduleViewSlot::query()
                ->select($this->columns)
                ->where('TermID', $this->filters['termID'])
                ->when($this->filters['centerID'] != 0, fn($query) => $query->where('testCenterID', $this->filters['centerID']))
                ->when($this->filters['dateFromID'] && $this->filters['dateToID'], fn($query) => $query->whereBetween('testDate', [$this->filters['dateFromID'], $this->filters['dateToID']]))
                ->when($this->filters['dateFromID'] && !$this->filters['dateToID'], fn($query) => $query->where('testDate', '>=', $this->filters['dateFromID']))
                ->when(!$this->filters['dateFromID'] && $this->filters['dateToID'], fn($query) => $query->where('testDate', '<=', $this->filters['dateToID']))
                ->when($this->filters['roomID'], fn($query) => $query->where('testRoomID', $this->filters['roomID']))
                ->when($this->filters['status'], fn($query) => $query->where('isActive', $this->filters['status']))
                ->when($this->filters['sort'] , fn($query) => $query->orderBy($this->filters['sort']))
                ->when($this->filters['search'], function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('testDate', 'LIKE', '%' . $search . '%')
                        ->orWhere('testTimeStartString', 'LIKE', '%' . $search . '%')
                        ->orWhere('testSessionName', 'LIKE', '%' . $search . '%')
                        ->orWhere('testRoomName', 'LIKE', '%' . $search . '%');
                    });
                });
        }

        public function headings(): array
        {
            return $this->columns;
        }
    }
?>