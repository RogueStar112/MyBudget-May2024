<table class='table item_results' id="ITEM_RESULTS_TABLE">
    <thead>
        <tr>
            <th scope='col'>Name</th>
            <th scope='col'>Action</th>
        </tr>
    </thead>






    <tbody>
        @foreach($items as $item)
           <tr>
              <td>{{$item->name}}</td>
              
              <td>
                <!-- Edit Transaction Button -->
                <a class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                
                <!-- Delete Transaction Button -->
                <a class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                
                <!-- More Details Button -->
                <a class="btn btn-primary"><i class="fas fa-plus"></i></a>
              </td>
           
            </tr>


        @endforeach
    </tbody>
</table>