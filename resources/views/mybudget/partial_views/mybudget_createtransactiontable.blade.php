<table class='table view_transaction_table' id="TRANSACTION_TABLE">
    <thead>
        <tr>
            <th scope='col'>#</th>
            <th scope='col'>Name</th>
            <th scope='col'>Price</th>
            <th scope='col'>Category</th>
            <th scope='col'>Subcategory</th>
            <th scope='col'>Date</th>
            <th scope='col'>Source</th>
            <th scope='col'>Action</th>
            <!-- <th scope='col'>Description</th> -->
        </tr>
    </thead>
    <tbody>
        
@foreach($transactions as $transaction)
    <tr>
        

        @if (!empty($transaction->deleted_at))
            <td colspan="1" style="opacity: 0.4">{{$transaction->id}}</td>
            <td colspan="7" style="opacity: 0.4"> TRANSACTION {{$transaction->name}} DELETED. Click <a href="{{ config('app.url')}}/budgeting-app/app/transactions/delete_undo/{{$transaction->id}}">here</a> to undo. </td>

        @else
            <th>{{$transaction->id}}</th>
            
            @if($transaction->has_subtransactions == 1)
            <td>{{$transaction->name}}*</td>
            @else
            <td>{{$transaction->name}}</td>
            @endif
            
            <!-- If Price is Below £1000, Show Price to Two decimal places -->
            @if((int)$transaction->price_twodp < 1000)
            <td>£{{number_format($transaction->price_twodp, 2)}}</td>
            @else
            <td>£{{$transaction->price_twodp}}</td>
            @endif
            
            <td>{{$transaction->category_name}}</td>
            
            <td>{{$transaction->section_name}}</td>
            
            <td>{{date('d/m/Y', strtotime($transaction->created_at))}}</td>
            
            <td>{{$transaction->source_name}}</td>

            <td>
                <!-- Edit Transaction Button -->
                <a class="btn btn-warning" href="{{ config('app.url')}}/budgeting-app/app/transactions/edit/{{$transaction->id}}" type="submit"><i class="fas fa-pencil-alt"></i></a>
                
                <!-- Delete Transaction Button -->
                <a class="btn btn-danger" href="{{ config('app.url')}}/budgeting-app/app/transactions/delete/{{$transaction->id}}" type="submit"><i class="fas fa-trash-alt"></i></a>
                
                <!-- More Details Button -->
                <a class="btn btn-primary" href="{{ config('app.url')}}/budgeting-app/app/transactions/show/{{$transaction->id}}" type="submit"><i class="fas fa-plus"></i></a>
            </td>
        <!-- <td>{{-- $transaction->description --}}</td> -->                 
        @endif

    </tr>

@endforeach

</tbody>
</table>