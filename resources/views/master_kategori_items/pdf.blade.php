<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>

    <h3>Master Kategori Item</h3>

    <p><strong>Kode Kategori:</strong> {{ $data->kode }}</p>
    <p><strong>Nama Kategori:</strong> {{ $data->nama }}</p>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($item_list as $row)
            <tr>
                <td>{{ $row->kode }}</td>
                <td>{{ $row->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    @endphp


    {{-- FOOTER --}}
    <div class="footer">
        Dicetak pada: {{ now()->setTimezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB
    </div>

</body>

</html>