<?php
    namespace App\Exports;

    use App\Models\ResultOverallView;
    use Maatwebsite\Excel\Concerns\FromQuery;
    use Maatwebsite\Excel\Concerns\WithHeadings;

    class ExportApplicantsResultNotQualified implements FromQuery, WithHeadings
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
                // ->distinct()
                ->select($this->columns)
                ->where('TermID', $this->filters['termID'])
                ->where('Status', 'NotQualified')
                ->when($this->filters['search'], function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('ApplicantName', 'LIKE', '%' . $search . '%')
                        ->orWhere('AppNo', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['sort'] , fn($query) => $query->orderBy($this->filters['sort']))
                ->groupBy($this->columns);  
        }

        public function headings(): array
        {
            return $this->columns;
        }
    }
?>