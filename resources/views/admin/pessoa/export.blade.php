<h1>LISTA DE PESSOAS</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>NOME</th>
        <th>DOCUMENTO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $customer)
        <tr>
            <td>{{ $customer->ID }}</td>
            <td>{{ $customer->DOCUMENTO }}</td>
            <td>{{ $customer->NOME }}</td>
        </tr>
    @endforeach
    </tbody>
</table>