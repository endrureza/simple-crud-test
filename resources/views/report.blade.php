<table>
    <thead>
    <tr>
        <th>Document Number</th>
        <th>Cluster Name</th>
        <th>Type Rumah</th>
        <th>Customer</th>
        <th>Phone</th>
        <th>Description</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($details as $detail)
        <tr>
            <td>{{ $detail->transaction->document_number }}</td>
            <td>{{ $detail->cluster->name }}</td>
            <td>{{ $detail->type->name }}</td>
            <td>{{ $detail->transaction->customer->name }}</td>
            <td>{{ $detail->transaction->customer->phone }}</td>
            <td>{{ $detail->type->description }}</td>
            <td>{{ $detail->price }}</td>
            <td>{{ $detail->qty }}</td>
            <td>{{ $detail->total }}</td>
            <td>{{ $detail->transaction->date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
