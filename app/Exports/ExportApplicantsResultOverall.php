<?php
    namespace App\Exports;

    use App\Models\ResultOverallView;
    use Maatwebsite\Excel\Concerns\FromQuery;
    use Maatwebsite\Excel\Concerns\WithHeadings;

    class ExportApplicantsResultOverall implements FromQuery, WithHeadings
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
            return ResultOverallView::query()
                ->select($this->columns)
                ->where('TermID', $this->filters['termID'])
                ->when($this->filters['campus'] != 0, fn($query) => $query->where('CampusID', $this->filters['campus']))
                ->when($this->filters['program'] != 0, fn($query) => $query->where('QualifiedCourseID', $this->filters['program']))
                ->when($this->filters['major'] != 0, fn($query) => $query->where('QualifiedMajorID', $this->filters['major']))
                ->when($this->filters['status'] && $this->filters['status'] !== 'all' && $this->filters['status'] != '1', fn($query) => $query->where('Status', $this->filters['status']))
                ->when($this->filters['status'] == 1, fn($query) => $query->where('isEnlisted', $this->filters['status']))
                ->when($this->filters['search'], function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('ApplicantName', 'LIKE', '%' . $search . '%')
                        ->orWhere('AppNo', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['sort'] , fn($query) => $query->orderBy($this->filters['sort']));
        }

        public function headings(): array
        {
            return $this->columns;
        }
    }
?>