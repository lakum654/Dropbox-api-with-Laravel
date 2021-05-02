<html>
    <title>Dropbox File Read</title>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
<body>
<div class="container">

    <table class="table table-bordered table-sm table-condensed">
<tbody>
    @for($row = 1; $row <= $highestRow; ++$row)
   <tr>
    @for ($col = 1; $col <= $highestColumnIndex; ++$col)
        @if($row == 1)
        <th>{{ $worksheet->getCellByColumnAndRow($col, $row)->getValue() }}</th>
        @else
        <td>{{ $worksheet->getCellByColumnAndRow($col, $row)->getValue() }}</td>
        @endif
    @endfor
    </tr>
@endfor
</tbody>
</table>
</div>
</body>
</html>
