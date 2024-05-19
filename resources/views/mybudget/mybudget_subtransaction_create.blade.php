<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyLifeline - Create Transaction</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="app">
        <x-navbar brandName="MyBudget" brandColor="green" >

            <x-slot name="items">
                
                <x-navbar-item url="/.." title="HOME" color="#198754" icon="home" />
                <div class="diagonal-divider"></div>
                <p style="color: white; margin-bottom: 0 !important;" class="skew10deg">APPS</p>
                <x-navbar-item url="/budgeting-app" title="BUDGET" color="green" icon="money-bill-alt" />
                <x-navbar-item url="/nutrition-app" title="HEALTH" color="orange" icon="dumbbell" />
                <x-navbar-item url="/journalling-app" title="WRITE" color="red" icon="pencil-alt" />
                <x-navbar-item url="/reviewing-app" title="REVIEW" color="blue" icon="star" />
                <div class="diagonal-divider"></div>
                <p style="color: white; margin-bottom: 0 !important;" class="skew10deg">USER</p>
                <x-navbar-item url="/login" title="LOGIN" color="lightblue" icon="user-alt"/>
                <x-navbar-item url="/register" title="REGISTER" color="skyblue" icon="user-plus"/>
                <x-navbar-item url="/settings" title="SETTINGS" color="grey" icon="cog"/>
    
            </x-slot>
            
        </x-navbar>
    </div>

    @isset($data)

            @for($i = 0; $i < count($data['names']); $i++)

               <!-- If First Iteration -->
               @if($i == 0)
                <h1 style='text-align: center; background-color: green; color: white; padding: 20px;'><i class="fas fa-check-circle"></i>Subtransactions Successfully Added!</h1>
                    <table class='table success-transactions-table'>
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Name</th>
                                <th scope='col'>Price</th>
                                <th scope='col'>Category</th>
                                <th scope='col'>Subcategory</th>
                                <th scope='col'>Date</th>
                                <th scope='col'>Source</th>
                            </tr>
                        </thead>
                        <tbody>

               @endif
                    
               <tr>
                <th scope='row'>{{$i+1}}</th>
                <td>{{$data['names'][$i]}}</td>
                <td>£{{number_format($data['prices'][$i], 2)}}</td>
                <td>{{$data['categories'][$i]}}</td>
                <td>{{$data['subcategories'][$i]}}</td>
                <td>{{date('d/m/Y', strtotime($data['dates'][$i]))}}</td>
                <td>{{$data['sources'][$i]}}</td>
               </tr>

            @endfor
                
            </tbody>
        </table>

        @endisset

    <div class="container subtransaction-container mt-3" >
        <div class="container-headings">
            <h1 style="color: green; font-weight: 800; transform: skew(-10deg);">ADD SUBTRANSACTIONS</h1>
            <i class="fas fa-chart-line statistics-icon"></i>
        </div>
        
        <form method="POST" action="/budgeting-app/app/create/subtransaction/{{$id}}/success" class="form-transaction mt-3" id="THE-FORM">
        @csrf

        <table class='table view_transaction_table view_one' id="SUBTRANSACTIONS-TABLE">
            <thead>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Name</th>
                    <th scope='col'>Price</th>
                    <th scope='col'>Category</th>
                    <th scope='col'>Subcategory</th>
                    <th scope='col'>Date</th>
                    <th scope='col'>Source</th>
                    <!-- <th scope='col'>Description</th> -->
                </tr>
            </thead>
            <tbody>
        
        @isset($transactions)
            @foreach($transactions as $transaction)
            <tr>
                
                <th id="THE-ID">{{$transaction->id}}</th>
                
                <td>{{$transaction->name}}</td>
                
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
                
                DESCRIPTION: {{$transaction->description}}
                <!-- <td>{{-- $transaction->description --}}</td> -->
            </tr>
            @endforeach
        @endisset

        @isset($subtransactions)

            @foreach($subtransactions as $subtransaction)
                @if($loop->first)
                        
                <th colspan="7" class="skew10deg" style="font-size:24px;">SUBTRANSACTIONS</th>

                </tr>

                <tr>

                @endif

                <th>{{$subtransaction->transaction_id}}.{{$loop->iteration}}</th>
                
                <td>{{$subtransaction->name}}</td>
                
                <!-- If Price is Below £1000, Show Price to Two decimal places -->
                @if((int)$subtransaction->price_twodp < 1000)
                <td>£{{number_format($subtransaction->price_twodp, 2)}}</td>
                @else
                <td>£{{$subtransaction->price_twodp}}</td>
                @endif
                
                <td>{{$subtransaction->category_name}}</td>
                
                <td>{{$subtransaction->section_name}}</td>
                
                <td>{{date('d/m/Y', strtotime($subtransaction->created_at))}}</td>
                
                <td>{{$subtransaction->source_name}}</td>

                </tr>

            @endforeach
        @endisset

        <tr class="upper-line-cutoff" id="subtransactions">

            <th><i class="fas fa-plus"></i></th>

            <td><input class="subtransaction-1 form-input" type="text" name="subtransaction-1-name" value="" required/></td>

            <td><input class="subtransaction-1 form-input" type="text" name="subtransaction-1-price" value="" required/></td>
            
            <td><select class="subtransaction-1 form-select" type="text" id="subtransaction-category-1" index="1" name="subtransaction-1-category" value="" required>
                @isset($categories)
                @foreach($categories as $category)
                    <option value={{$category->id}}>{{$category->name}}</option>
                @endforeach
                @endisset
            </select></td>

            <td><select class="subtransaction-1 form-select" type="text" id="subtransaction-subcategory-1" index="1" name="subtransaction-1-subcategory" value="" required></select></td>

            <td><input class="subtransaction-1 form-input" type="date" name="subtransaction-1-date" value="" required/></td>

            <td><input class="subtransaction-1 form-input" type="text" name="subtransaction-1-source" value="" required/></td>

        </tr>

        </tbody>
        
        </table>


    <div id="subtransaction-buttons">
        <input type="hidden" id="pages" name="subtransaction-pages" value="1"/>
        <input type="hidden" id="transaction-id" name="transaction-id" value="" />
        <button class="btn btn-success" type="button" id="add-subtransaction-btn" onclick=createNewSubtransaction()>ADD SUBTRANSACTION BUTTON</button>
        <button class="btn btn-primary" type="submit" id="submit-subtransaction-btn">SUBMIT</button>
    </div>

        </form>
    
    </div>
    <div class="container big-text-container">
        <h1 class="BIG-TEXT" style="font-size: 240px; opacity: 0.4; color: green;"> / / / / / / / </h1>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script
                  src="https://code.jquery.com/jquery-3.6.0.js"
                  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
                  crossorigin="anonymous"></script>
  

    
</body>

<script>
    // Subtransaction 1 is already made Above.
    var page_numbers = [1]
    var subtransaction_count = 2

    document.getElementById('transaction-id').value = document.getElementById('THE-ID').innerHTML;

    function createNewSubtransaction() {



        var table = document.getElementById("SUBTRANSACTIONS-TABLE")

        // Add New Row on the Last Element. In other words, Append new Row.
        var row = table.insertRow(-1);

        var icon_cell = row.insertCell(0);

        icon_cell.innerHTML = `<button class="btn btn-danger" onClick=deleteSubtransaction(${subtransaction_count})><i class="fas fa-trash-alt"></i></button>`
        
        var name_cell = row.insertCell(1);
        
        name_cell.innerHTML = `<input class="subtransaction-${subtransaction_count} form-input" type="text" name="subtransaction-${subtransaction_count}-name" required>`
        

        var price_cell = row.insertCell(2);

        price_cell.innerHTML = `<input class="subtransaction-${subtransaction_count} form-input" type="text" name="subtransaction-${subtransaction_count}-price" required>`

        var category_cell = row.insertCell(3);

        var page_content_toupdate_category = document.querySelector('#subtransaction-category-1');

        var page_content_toupdate_category_clone = page_content_toupdate_category.cloneNode(true);

        page_content_toupdate_category_clone.id = `subtransaction-category-${subtransaction_count}`;

        page_content_toupdate_category_clone.setAttribute('name', `subtransaction-${subtransaction_count}-category`);

        page_content_toupdate_category_clone.setAttribute('index', `${subtransaction_count}`)

        page_content_toupdate_category_clone = `<td class="transaction-${subtransaction_count}">` + page_content_toupdate_category_clone.outerHTML + `</td>`;

        category_cell.innerHTML = page_content_toupdate_category_clone;

        var subcategory_cell = row.insertCell(4);

        var page_content_toupdate_subcategory = `<div class="col m-3 transaction-${subtransaction_count}"><input class="form-control" id="transaction-subcategory-${subtransaction_count}" index="${subtransaction_count}" name="transaction-subcategory-${subtransaction_count}" required></input></div>`

        var page_content_toupdate_subcategory = document.querySelector(`#subtransaction-subcategory-1`);

        var page_content_toupdate_subcategory_clone = page_content_toupdate_subcategory.cloneNode(true);

        page_content_toupdate_subcategory_clone.id = `subtransaction-subcategory-${subtransaction_count}`;

        page_content_toupdate_subcategory_clone.setAttribute('name', `subtransaction-${subtransaction_count}-subcategory`);

        page_content_toupdate_subcategory_clone.setAttribute('index', `${subtransaction_count}`)

        page_content_toupdate_subcategory_clone = `<td class="subtransaction-${subtransaction_count}">` + page_content_toupdate_subcategory_clone.outerHTML + `</td>`;

        subcategory_cell.innerHTML = page_content_toupdate_subcategory_clone;

        var date_cell = row.insertCell(5);

        date_cell.innerHTML = `<input class="subtransaction-${subtransaction_count} form-input" type="date" name="subtransaction-${subtransaction_count}-date" required>`

        var source_cell = row.insertCell(6);

        source_cell.innerHTML = `<input class="subtransaction-${subtransaction_count} form-input" type="text" name="subtransaction-${subtransaction_count}-source" required>`

        page_numbers.push(subtransaction_count)

        console.log(page_numbers)

        updatePagesList()

        subtransaction_count += 1;

    }

    function updatePagesList() {

        document.getElementById('pages').value = page_numbers

    }

    function deleteSubtransaction(id) {
        $(`.subtransaction-${id}`).remove();
    }

    $(document).ready(function() {
        $(`[id^="subtransaction-category-"]`).on('click', function(){
          
          var id = this.value;
          var index = $(this).attr("index");
          var url=`/budgeting-app/app/getsubcategories/${id}`;

          $(`[id^="subtransaction-subcategory-${index}"]`).load(url);
            });
        });

    $(document).ready(function() {
     $('#add-subtransaction-btn').on('click', function() {
        $(`[id^="subtransaction-category-"]`).on('click', function(){
          
          var id = this.value;
          var index = $(this).attr("index");
          var url=`/budgeting-app/app/getsubcategories/${id}`;

          $(`[id^="subtransaction-subcategory-${index}"]`).load(url);
            });
        });
    });
    

    $('#THE-FORM').append('{{csrf_field()}}');

    
</script>

</html>
