<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: "Times New Roman", serif; color: #000; }
        .header-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .header-table td {
            vertical-align: top;
            font-size: 14px;
        }
        .header-left { text-align: left; }
        .header-right { text-align: right; }
        .label { font-weight: bold; }
        table.details { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table.details th, table.details td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        .criteria-title {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0 10px;
        }
        .no-doc { font-style: italic; color: #333; }
    </style>
</head>
<body>

    <div class="header-title">Evaluation Report</div>

    <table class="header-table">
        <tr>
            <td class="header-left">
                <div>
                    <span class="label">Name:</span> 
                    {{ strtoupper($applicant->firstname . ' ' . $applicant->middlename . ' ' . $applicant->lastname) }}
                </div>
                <div>
                    <span class="label">Address:</span> 
                    {{ $applicant->Address ?? 'N/A' }}
                </div>
            </td>
            <td class="header-right">
                <div><span class="label">Total Score:</span> {{ $totalPoints }}</div>
                <div><span class="label">Rank:</span> {{ $rank }}</div>
            </td>
        </tr>
    </table>

    <h3 style="text-align:center; font-weight: normal;">Evaluation Results</h3>

    @foreach ($criteria as $crit)
        <div class="criteria-title">Criteria for {{ $crit->criteriaDetail }}</div>

        <table class="details">
            <thead>
                <tr>
                    <th>Document Title</th>
                    <th>Level</th>
                    <th>Date Presented</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $docs = $evaluations->where('criteriaID', $crit->criteriaID);
                @endphp

                @if ($docs->isEmpty())
                    <tr class="no-doc">
                        <td colspan="4">No uploaded document</td>
                    </tr>
                @else
                    @foreach ($docs as $evaluation)
                    <tr>
                        <td>{{ $evaluation->title }}</td>
                        <td>{{ $evaluation->qualificationLevel->Level ?? '—' }}</td>
                        <td>{{ $evaluation->date_presented }}</td>
                        <td>{{ $evaluation->faculty_score }}</td>
                    </tr>
                    @endforeach

                @endif
            </tbody>
        </table>
    @endforeach

</body>
</html>
