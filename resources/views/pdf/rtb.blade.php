<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>RTB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header p {
            margin: 0 0 5px 0;
        }
        .header strong {
            display: inline-block;
            width: 130px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #b3e5a1;
            color: black;
        }
        .items-cell {
            line-height: 1.3;
        }
         .signature-section {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }
        .signature-block {
            display: inline-block;
            width: 32%;
            vertical-align: top;
            text-align: left;
        }
        .signature-name {
            font-weight: bold;
            margin-bottom: 2px;
        }
        .signature-title {
            font-size: 11px;
        }
        .generated-by{
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="header">
        <p><strong>Subject:</strong> {{ $rows[0]['subject'] ?? '' }}</p>
        <p><strong>Project Name:</strong> {{ $rows[0]['project_name'] ?? '' }}</p>
        <p><strong>Venue:</strong> {{ $venue }}</p>
        <p><strong>Event Date:</strong> {{ $event_date }}</p>
        <p><strong>Deadline:</strong> {{ $rows[0]['deadline'] ?? '' }}</p>
        <p><strong>Date of Request:</strong> {{ now()->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>COMPANY NAME/S</th>
                <th>ITEMS</th>
                <th>NOTES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr>
                <td>{{ $row['company'] }}</td>
                <td class="items-cell">{!! $row['items'] !!}</td>
                <td>{{ $row['notes'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-section">

        <div class="signature-block">
            <div>PREPARED BY:</div>
            <div class="signature-name generated-by">
                {{ auth()->user()->name ?? 'N/A' }}
            </div>
            <div class="signature-title">
                {{ auth()->user()->position ?? 'N/A' }}{{ auth()->user()->department ? ', ' . auth()->user()->department : '' }}
            </div>
        </div>

        <div class="signature-block">
                <div>NOTED BY:</div>
            <div class="signature-name">KATRINA C. PINEDA</div>
            <div class="signature-title">Division Chief, CBD TPS-CAS</div>
        </div>

        <div class="signature-block">
             <div>APPROVED BY:</div>
            <div class="signature-name">ROWENA G. MENDOZA</div>
            <div class="signature-title">Department Manager, CBD</div>
        </div>
    </div>
</body>
</html>