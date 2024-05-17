<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyLifeline - Create Transaction</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/mybudget_transactions.css') }}" rel="stylesheet" type="text/css">

    <!-- Mobile Media Queries -->
    <link href="{{ asset('css/mybudget_transactions_MOBILE.css') }}" rel="stylesheet" type="text/css">
    
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

        <div id="TRANSACTIONS-CONTAINER" class="container-fluid mt-3">

            <div id="TRANSACTIONS-HEADER">

                <div id="TRANSACTIONS-HEADER-TITLE">
                TRANSACTIONS          
                </div>
                
                <div id="TRANSACTIONS-HEADER-ICON"><i class="fas fa-cash-register"></i>
                
                </div>

            </div>


            <form method="POST" id="TRANSACTIONS-FORM-CHOOSE-1" action="{{ config('app.url')}}/budgeting-app/app/" class="form-transaction mt-3">
                
                <div id="CHOOSE-1-HEADER">SELECT AN ACTION</div>
                
                <div id="TRANSACTIONS-FORM-CHOOSE-1-FIELDS">

                    <div id="TRANSACTION-CREATE-FIELD">
                    <input type="radio" id="transaction_radio_1"
                     name="transactions_form_radio" value="CREATE" />
                    <label for="transaction_radio_1">CREATE</label>
                    
                    <i class="fas fa-cart-plus"></i>
                    </div>

                    <div id="TRANSACTION-EDIT-FIELD">
                    <input type="radio" id="transaction_radio_2"
                     name="transactions_form_radio" value="EDIT" />
                    <label for="transaction_radio_2">EDIT</label>

                    <i class="fas fa-pencil-alt"></i>
                    </div>

                    <div id="TRANSACTION-VIEW-FIELD">
                    <input type="radio" id="transaction_radio_3"
                     name="transactions_form_radio" value="VIEW" />
                    <label for="transaction_radio_3">VIEW</label>

                    <i class="fas fa-search"></i>
                    </div>
                    
                </div>


            </form>

            <div id="TRANSACTION-DIVS">
                <div class="transaction-selection mt-3" id="TRANSACTIONS-FORM-CREATE">
                    
                    <div class="transactions-bottom-border">
                        CREATE TRANSACTIONS

                    </div>

                    <div class="transactions-icon-container">
                        <div class="transactions-icon create-icon">
                         <i class="fas fa-cart-plus" aria-hidden="true"></i>
                        </div>
                    </div>

                    <!-- Create Transactions -->
                    <form id="TRANSACTION-FORM-CREATE_FORM">
                        
                        
                        <div class="TRANSACTION-GRID" class="">
                            <div class="header-columns">
                                <div class="field-id transactions-bottom-border">#</div>
                                <div class="field-category transactions-bottom-border">CATEGORY</div>
                                <div class="field-section transactions-bottom-border">SECTION</div>
                                <div class="field-name transactions-bottom-border">NAME</div>
                                <div class="field-price transactions-bottom-border">PRICE</div>
                                <div class="field-source tablet-hidden mobile-hidden transactions-bottom-border">SOURCE</div>
                                <div class="field-date tablet-hidden mobile-hidden transactions-bottom-border">DATE</div>
                                <div class="field-actions transactions-bottom-border">ACTIONS</div>
                            </div>
                            

                            <div class="transaction-row">
                                <div class="field-id ">0</div>
                                <select class="field-category" id="transaction-category-1" index="1">
                                    
                                    @isset($categories)
                                    @foreach($categories as $category)
                                        <option value={{$category->id}}>{{$category->name}}</option>
                                    @endforeach
                                    @endisset
                                    <!--
                                    <div class="field-category-line"></div>
                                    <div class="field-dropdown"><i class="fas fa-caret-down"></i></div>
                                    -->

                                </select>
                                <select class="field-section"  id="transaction-subcategory-1"><p>Electronics</p>

                                    <div class="field-category-line"></div>
                                    <div class="field-dropdown"><i class="fas fa-caret-down"></i></div>
                                    
                                </select>
                                <div class="field-name"><input class="field-name_input" id="" /></div>
                                <div class="field-price"><span class="field-price-currency">£</span><input name="field-price_input_1" class="field-price_input" /></div>
                                <div class="field-source tablet-hidden mobile-hidden"><input name="field-source_input_1" class="field-source_input" /></div>
                                <div class="field-date tablet-hidden mobile-hidden"><input type="date" name="field-date_input_1" class="field-date_input" /></div>
                                <div class="field-actions">

                                    <button class="btn custom-btn-more" id="transaction-btn-more-1" title="Click for more optional fields" type="button" index="1"><i class="fas fa-plus"></i></button>
                                    <button class="btn custom-btn-view" id="transaction-btn-view-1" title="Click to view transaction in detail" type="button" index="1"><i class="fas fa-eye"></i></button>
                                </div>

                                <div class="transaction-row-extra d-none" id="transaction-1-extra_fields">
                                <div class="field-filler"></div>
                                <div class="field-description">
                                    <label for="description_field">Description (Max 100 characters)</label>
                                    <textarea maxlength="100" colspan="6" name="description_field"></textarea>
                                </div>
                                </div>
                            </div>

                            <div class="transaction-row">
                                <div class="field-id ">1</div>
                                <div class="field-category"><p>Groceries</p>

                                    <div class="field-category-line"></div>
                                    <div class="field-dropdown"><i class="fas fa-caret-down"></i></div>
                                </div>
                                <div class="field-section">
                                    
                                    <p>Food</p>

                                    <div class="field-category-line"></div>
                                    <div class="field-dropdown"><i class="fas fa-caret-down"></i></div>
                                </div>
                                <div class="field-name">Peanut Butter</div>
                                <div class="field-price">£1.99</div>
                                <div class="field-source tablet-hidden mobile-hidden">Lidl</div>
                                <div class="field-date tablet-hidden mobile-hidden">11/08/2022</div>
                                <div class="field-actions">

                                    <button class="btn custom-btn-more" index="2"><i class="fas fa-plus"></i></button>
                                    <button class="btn custom-btn-view" index="2"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>

                            <div class="submit-row">
                                <div class="field-id "></div>
                                <div class="field-category">
                                </div>
                                <div class="field-section">
                                    
                                 
                                </div>
                                <div class="field-name"></div>
                                <div class="field-price"></div>
                                <div class="field-source tablet-hidden mobile-hidden"></div>
                                <div class="field-date tablet-hidden mobile-hidden"></div>
                                <div class="field-actions">
                                    <button class="btn btn-danger" style="font-weight:800; position: absolute; left: 15px;">CLEAR</button>
                                    <button class="btn btn-primary" style="font-weight: 800;">ADD</button>
                                    <button class="btn btn-success" style="font-weight:800;">SUBMIT</button>
                                </div>
                            </div>
                        </div>

                        

                    </form>

                </div>

                <div class="transaction-selection mt-3" id="TRANSACTIONS-FORM-EDIT">

                    <div class="transactions-bottom-border">
                        
                    EDIT TRANSACTIONS
                    </div>

                    <div class="transactions-icon-container">
                        <div class="transactions-icon edit-icon">
                            <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <!-- View Transactions -->
                <div class="transaction-selection mt-3" id="TRANSACTIONS-FORM-VIEW">
                    
                    <div class="transactions-bottom-border">

                    VIEW TRANSACTIONS

                    </div>

                    <div class="transactions-icon-container">
                        <div class="transactions-icon view-icon">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </div>
                    </div>


                    <div class="TRANSACTION-GRID" class="">
                        <div class="header-columns">
                            <div class="field-id  transactions-bottom-border">#</div>
                            <div class="field-category transactions-bottom-border">CATEGORY</div>
                            <div class="field-section transactions-bottom-border">SECTION</div>
                            <div class="field-name transactions-bottom-border">NAME</div>
                            <div class="field-price transactions-bottom-border">PRICE</div>
                            <div class="field-source tablet-hidden mobile-hidden transactions-bottom-border">SOURCE</div>
                            <div class="field-date tablet-hidden mobile-hidden transactions-bottom-border">DATE</div>
                            <div class="field-actions transactions-bottom-border">ACTIONS</div>
                        </div>

                        <!--
                        <div class="submit-row">
                            <div class="field-id "></div>
                            <div class="field-category">
                            </div>
                            <div class="field-section">
                                
                             
                            </div>
                            <div class="field-name"></div>
                            <div class="field-price"></div>
                            <div class="field-source tablet-hidden mobile-hidden"></div>
                            <div class="field-date tablet-hidden mobile-hidden"></div>
                            <div class="field-actions">
                                <button class="btn btn-danger" style="font-weight:800; position: absolute; left: 15px;">CLEAR</button>
                                <button class="btn btn-primary" style="font-weight: 800;">ADD</button>
                                <button class="btn btn-success" style="font-weight:800;">SUBMIT</button>
                            </div>
                        </div>
                        -->
                        
                        @foreach($transactions as $transaction)
                        <div class="transaction-row">
                            <div class="field-id ">{{$transaction->id}}</div>
                            <div class="field-category" style="background-color: {{$transaction->color_bg}}; color: {{$transaction->color_text}}">
                                <i class="fas transaction-icon">{{html_entity_decode($transaction->icon_code)}}</i>
                                {{$transaction->category_name}}
                                <!--
                                <p>Shopping</p>
                                <div class="field-category-line"></div>
                                <div class="field-dropdown"><i class="fas fa-caret-down"></i></div>
                                -->

                            </div>
                            <div class="field-section" style="background-color: {{$transaction->color_bg}}; color: {{$transaction->color_text}}">

                                {{$transaction->section_name}}
                                <!--
                                <div class="field-category-line"></div>
                                <div class="field-dropdown"><i class="fas fa-caret-down"></i></div>
                                -->
                            </div>

                            <div class="field-name">{{$transaction->name}}</div>
                            
                            @if((int)$transaction->price_twodp < 1000)
                            <div class="field-price">£{{number_format($transaction->price_twodp, 2)}}</div>
                            @else
                            <div class="field-price">£{{$transaction->price_twodp}}</div>
                            @endif


                            <div class="field-source tablet-hidden mobile-hidden">{{$transaction->source_name}}</div>
                            <div class="field-date tablet-hidden mobile-hidden">{{date('d/m/Y', strtotime($transaction->created_at))}}</div>
                            <div class="field-actions">

                                <button class="btn custom-btn-more"><i class="fas fa-plus"></i></button>
                                <button class="btn custom-btn-more"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>           
                        @endforeach
                 

                        <div class="transaction-row">
                            <div class="field-id ">1</div>
                            <div class="field-category"><p>Groceries</p>

                                <div class="field-category-line"></div>
                                <div class="field-dropdown"><i class="fas fa-caret-down"></i></div>
                            </div>
                            <div class="field-section">
                                
                                <p>Food</p>

                                <div class="field-category-line"></div>
                                <div class="field-dropdown"><i class="fas fa-caret-down"></i></div>
                            </div>
                            <div class="field-name">Peanut Butter</div>
                            <div class="field-price">£1.99</div>
                            <div class="field-source tablet-hidden mobile-hidden">Lidl</div>
                            <div class="field-date tablet-hidden mobile-hidden">11/08/2022</div>
                            <div class="field-actions">

                                <button class="btn custom-btn-more"><i class="fas fa-plus"></i></button>
                                <button class="btn custom-btn-more"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>
                             
                    </div>
                </div>
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

$(document).ready(function() {
    $("input[name$='transactions_form_radio']").click(function() {
        var test = $(this).val();
        
        console.log(test);

        
        $(".transaction-selection").removeClass('TRANSACTION-DIV-SHOW');

        $("#TRANSACTIONS-FORM-" + test).addClass('TRANSACTION-DIV-SHOW');
    });
});

// Load Subcategories from Section //
$(document).ready(function() {
        $(`[id^="transaction-category-"]`).on('click', function(){
          
          var id = this.value;
          var index = $(this).attr("index");
          var url=`/budgeting-app/app/getsubcategories/${id}`;
        
          if (url != '') {
            
            $(`[id^="transaction-subcategory-${index}"]`).load(url);

            if( $(`[id^="transaction-subcategory-${index}"]`).val() == null) {
                $(`[id^="transaction-subcategory-${index}"]`).html('<option value="N/A">N/A</option>')
            }

          }

            });
            
});


// Load Optional Fields
$(document).ready(function() {
        $(`[id^="transaction-btn-more-"]`).on('click', function(){
          
          var id = this.value;
          var index = $(this).attr("index");

          console.log(index);
          
          if ( $(`#transaction-${index}-extra_fields`).hasClass('d-none')) {

            $(`#transaction-${index}-extra_fields`).removeClass('d-none')
          } else {
            $(`#transaction-${index}-extra_fields`).addClass('d-none')
          }
        });
            
});

</script>

</html>