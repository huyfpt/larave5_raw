<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<table border="1">
    <thead>
    <tr>
        @foreach($header as $h)
            <td>{{$h}}</td>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
        <tr>
            @foreach($row as $column)
                <td>{{ $column }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>