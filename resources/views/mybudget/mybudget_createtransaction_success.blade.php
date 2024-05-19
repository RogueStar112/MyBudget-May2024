<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyBudget - Create Transaction</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
            <div class="container-fluid">
            
            <a class="navbar-brand ms-2 bg-success skew10deg fw-bolder" href="#">MyBudget</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample03">
                <ul class="navbar-nav me-auto mb-2 mb-sm-0">

                <div class="diagonal-divider"></div>

                <!-- budgeting -->
                <li class="nav-item bg-orange-skew-np m-1">
                    <a class="nav-link" aria-current="page" href="/.."><i class="fas fa-home"></i><p> | Budgeting</p><div class="label-bottom">HOME</div></a>
                </li>

                <!-- fitness/dieting -->
                <li class="nav-item bg-warning m-1">
                    <a class="nav-link" href="/fitness-app"><i class="fas fa-dumbbell"></i><p> | Fitness</p><div class="label-bottom">FITNESS</div></a>
                </li>

                <!-- journalling -->
                <li class="nav-item bg-danger m-1">
                    <a class="nav-link" href="/journalling-app" tabindex="-1" aria-disabled="true"><i class="fas fa-pencil-alt"></i><p> | Journalling</p><div class="label-bottom">JOURNAL</div></a>
                </li>

                <!-- reviews -->
                <li class="nav-item bg-info m-1">
                    <a class="nav-link" href="/reviewing-app" tabindex="-1" aria-disabled="true"><i class="fas fa-star"></i><p> | Reviewing</p><div class="label-bottom">REVIEWS</div></a>
                </li>
                
                <div class="diagonal-divider"></div>

                <!-- login -->
                <li class="nav-item bg-primary m-1 item-square flex-row-reverse">
                    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-user-alt"></i><p> | Settings</p><div class="label-bottom">LOGIN</div></a>
                </li>

                <!-- settings -->
                <li class="nav-item bg-secondary m-1 item-square flex-row-reverse">
                    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-cog"></i><p> | Settings</p><div class="label-bottom">SETTINGS</div></a>
                </li>


                <!--
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown03">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                -->

                </ul>

                <!--
                <form>
                <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                </form>
                 -->
            </div>
            </div>
        </nav>

        <!--
        <div class="d-flex justify-content-center full-height">
            <div class="content">
                <form method="POST" action="/products">
                    <h1> Enter Details to create a product</h1>
                    <div class="form-input">
                        <label>Name</label> <input type="text" name="name">
                    </div>

                    <div class="form-input">
                        <label>Description</label> <input type="text" name="description">
                    </div>

                    <div class="form-input">
                        <label>Count</label> <input type="number" name="count">
                    </div>

                    <div class="form-input">
                        <label>Price</label> <input type="number" name="price">
                    </div>

                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
        -->

        <!--
        <form>
            <div class="row">
                <div class="col">
                <input type="text" class="form-control" placeholder="First name">
                </div>
                <div class="col">
                <input type="text" class="form-control" placeholder="Last name">
                </div>
            </div>
        </form>
        -->

       <div class="container">
            <div class="row success-icon text-center">
                <i class="far fa-check-circle"></i>
            </div>
       </div>

    </div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>
		
</body>

<script>   
    
    // SS.0.1. Random Placeholder Text //
    // PURPOSE: For cosmetic reasons, to make it so item inputs have varying placeholders.
    var placeholder_text_JSON = [
            {
            'name': 'Frozen Peas 1kg',
            'price': '0.79',
            'category': 'Groceries',
            'subcategory': 'Frozen Food',
            'source': 'Aldi',
            'description': 'Half the price of fresh peas!'
            },

            {
            'name': 'Gaming PC',
            'price': '749.99',
            'category': 'Shopping',
            'subcategory': 'Electronics',
            'source': 'Currys',
            'description': '16GB RAM, Decent GPU and CPU.'
            },

            {
            'name': 'Microwave',
            'price': '60',
            'category': 'Essentials',
            'subcategory': 'Cooking Equipment',
            'source': 'Tesco',
            'description': 'To cook ready meals'
            },

            {
            'name': 'Coca Cola Cans (x6)',
            'price': '2.99',
            'category': 'Groceries',
            'subcategory': 'Junk Food',
            'source': 'Tesco',
            'description': 'For a party'
            },

            {
            'name': 'Thai Eatout',
            'price': '43.45',
            'category': 'Eating Out',
            'subcategory': 'Thai',
            'source': 'Thai Land',
            'description': 'An occasional treat. 7/10.'
            }
        ]
    
    r = Math.floor(Math.random() * placeholder_text_JSON.length);
    
    function randomPlaceholderText() {
        r = Math.floor(Math.random() * placeholder_text_JSON.length);

        $('#transaction-name-1').prop('placeholder',placeholder_text_JSON[r]['name']);
        $('#transaction-price-1').prop('placeholder',placeholder_text_JSON[r]['price']);
        $('#transaction-category-1').prop('placeholder',placeholder_text_JSON[r]['category']);
        $('#transaction-subcategory-1').prop('placeholder',placeholder_text_JSON[r]['subcategory']);
        $('#transaction-source-1').prop('placeholder',placeholder_text_JSON[r]['source']);
        $('#transaction-date-1').prop('placeholder',placeholder_text_JSON[r]['date']);
        $('#transaction-description-1').prop('placeholder',placeholder_text_JSON[r]['description']);

        //$('#search').prop('placeholder',list[r]);
    }

    randomPlaceholderText()

    // SS.0.2. Add Transaction //

    // *Page Number Stuff* //
    var pageNumber = 1;
    var noOfPages = 1;

    var page_content = {}

    function updatePageNumber() {
        $("#page-number-text").text("Page " + pageNumber + " out of " + noOfPages)
    }

    function createNewPage() {

        var page_content_toupdate_name = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-name-${noOfPages}">Name</label><input class="form-control" id="transaction-${noOfPages}-name" name="transaction-${noOfPages}-name" placeholder="${placeholder_text_JSON[r]['name']}" required></input></div>`
        var page_content_toupdate_price = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-price-${noOfPages}">Price</label><input class="form-control" id="transaction-${noOfPages}-price" name="transaction-price-${noOfPages}" placeholder="${placeholder_text_JSON[r]['price']}" required></input></div>`
        var page_content_toupdate_category = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-category-${noOfPages}">Category</label><input class="form-control" id="transaction-${noOfPages}-category" name="transaction-category-${noOfPages}" placeholder="${placeholder_text_JSON[r]['category']}" required></input></div>`
        var page_content_toupdate_subcategory = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-subcategory-${noOfPages}">Subcategory</label><input class="form-control" id="transaction-${noOfPages}-subcategory" name="transaction-subcategory-${noOfPages}" placeholder="${placeholder_text_JSON[r]['subcategory']}" required></input></div>`
        var page_content_toupdate_source = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-source-${noOfPages}">Source</label><input class="form-control" id=transaction-${noOfPages}-source" name="transaction-source-${noOfPages}" placeholder="${placeholder_text_JSON[r]['source']}" required></input></div>`
        var page_content_toupdate_date = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-date-${noOfPages}">Date</label><input class="form-control" type="date" id="transaction-${noOfPages}-date" name="transaction-date-${noOfPages}" placeholder="" required></input></div>`
        var page_content_toupdate_description = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-description-${noOfPages}">Description (optional)</label><input class="form-control" id="transaction-${noOfPages}-description" name="transaction-description-${noOfPages}" placeholder="${placeholder_text_JSON[r]['description']}" required></input></div>`

        //var baseStringArray = ['#transaction-name-', '#transaction-price-', '#transaction-category-', '#transaction-subcategory-', '#transaction-source-', 'transaction-date-', 'transaction-description-']
        

        //for (let i = 0; i < baseStringArray.length; i++) {
        //    $(baseStringArray[i] + pageNumber).text("Page " + pageNumber + " out of " + noOfPages)
        //} 
        
        // Name and Price
        $("#input-field-1").append(page_content_toupdate_name)
        $("#input-field-1").append(page_content_toupdate_price)

        // Category and Subcategory
        $("#input-field-2").append(page_content_toupdate_category)
        $("#input-field-2").append(page_content_toupdate_subcategory)

        // Source and Date
        $("#input-field-3").append(page_content_toupdate_source)
        $("#input-field-3").append(page_content_toupdate_date)

        // Description
        $("#input-field-4").append(page_content_toupdate_description)
        

        //var transaction_stuff = $(`[class^='transaction-']`).not(`[class^='transaction-${pageNumber}']`);

    }

    function storePageContent() {
        


    }

    function updatePageContents() {

        // FOR ALL Pages except the selected one, do not display them.
        var transaction_list = $(`div[class^="transaction-"],[class*="transaction-"]`).not(`.transaction-${pageNumber}`);
                
        for (let item of transaction_list) {
            $(item).addClass('d-none');
        }

        // Remove the display none class from the selected page.
        $(`.transaction-${pageNumber}`).removeClass('d-none');

    }

    function prevPage() {
        if (pageNumber > 1) {
         // If the page number basically isn't one, go to the previous page.
         pageNumber -= 1
       } else {
         // If Page Number is less than 1, go to the most recent page. THIS IS INTENDED so the user doesn't have to click a lot of times to get to a certain page.
         pageNumber = noOfPages;
       }
      updatePageNumber()
      updatePageContents()

    }

    function newPage() {
        
        noOfPages += 1;
        pageNumber = noOfPages;

        updatePageNumber()
        createNewPage()
        updatePageContents()
    }
 
    function nextPage() {
       if (pageNumber >= 1 && pageNumber < noOfPages) {
         pageNumber += 1
       } else {
         pageNumber = 1;
       }
       updatePageNumber()
       updatePageContents()
    }

    ////////////////////////////////////////////

    $("#transaction-add-btn, #transaction-edit-btn, #transaction-delete-btn, #transaction-view-btn").click(function() {
        console.log('Clicked')
        
        if($('#transaction-add-btn').is(':checked')) {
            $(".add_transaction_form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".add_transaction_form").addClass("d-none");
        }

        if($('#transaction-edit-btn').is(':checked')) {
            $(".edit_transaction_form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".edit_transaction_form").addClass("d-none");
        }

        if($('#transaction-delete-btn').is(':checked')) {
            $(".delete_transaction_form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".delete_transaction_form").addClass("d-none");
        }

        if($('#transaction-view-btn').is(':checked')) {
            $(".view_transaction_form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".view_transaction_form").addClass("d-none");
        }


    });

    /*
    $("#transaction-view-btn").click(function() {
        document.getElementById("CATEGORY_METHOD").setAttribute("value", "POST")
        document.getElementById("THE-FORM").setAttribute("action", "TESTOSTERONE")
    });
    */

</script>

</html>