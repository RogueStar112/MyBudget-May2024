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

        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
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

        @isset($success_message)

            <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;">Successfully added {{$success_message}} to categories!</h1>

        @endisset

        @isset($success_message_edit)
            <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;">Successfully edited {{$success_message_edit}}.</h1>
        @endisset

        @isset($success_message_subcategory)
            <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;">{{$success_message_subcategory}}.</h1>
        @endisset

        @isset($fail_message)   
            <h1 class="success-message" style="text-align: center; background-color: darkred; color: white; padding: 20px;">{{$fail_message}}</h1>
        @endisset

        
        <div class="container-fluid"> 
        
        <form method="POST" action="{{ config('app.url')}}/budgeting-app/app/categories" class="form-category mt-3" id="THE-FORM">
            @csrf
            <div class="form container m-3">
                <div class="row categories-title">
                    <div class="col-9 text-left">
                        <h3 class="form-categories_title">CATEGORIES</h3>
                    </div>

                    <div class="col text-center">
                        <i class="fas fa-book form-icon"></i>
                    </div>
                </div>
                
                <div class="row transaction_descriptor">
                    <div class="col text-left"><p>1. What do you want to do? (Select One)</div>
                </div>

                <div class="row transaction_selection_buttons" id="transaction_selection_buttons">
                    <div class="col"><input type="radio" id="transaction-add-btn" name="transaction-mode-select"><label for="transaction-add-btn">Add Category</label></div>
                    <div class="col"><input type="radio" id="transaction-edit-btn" name="transaction-mode-select"><label for="transaction-edit-btn">Edit Category</label></div>
                    <div class="col"><input type="radio" id="transaction-delete-btn" name="transaction-mode-select"><label for="transaction-delete-btn">Add Subcategory</label></div>
                    <div class="col"><input type="radio" id="transaction-view-btn" name="transaction-mode-select"><label for="transaction-view-btn">Edit Subcategory</label></div>
                </div>
            </div>

            <div class="add_transaction_form d-none">
                <!-- Text Title --> 
                <div class="row text-center"><p>Add Category</p></div>
               
                <!-- Transaction To Add -->
                <div class="row" id="input-field-1">
                    <div class="col m-3 category-1"><label for="category-name-1">Name</label><input class="form-control" type="text" id="category-name-1" name="category-name-1" placeholder="Frozen Peas" ></div>
                    <!-- div class="col m-3 category-1"><label for="transaction-price-1">Price (£)</label><input class="form-control" id="transaction-price-1" name="transaction-price-1" placeholder="0.79" required></div> -->
                </div>

                <!--
                <div class="row" id="input-field-2">
                    <div class="col m-3 category-1"><label for="transaction-category-1">Category</label><input class="form-control" id="transaction-category-1" name="transaction-category-1" placeholder="Groceries" required></div>
                    <div class="col m-3 category-1"><label for="transaction-subcategory-1">Subcategory</label><input class="form-control" id="transaction-subcategory-1" name="transaction-subcategory-1" placeholder="Frozen Food" required></div>
                </div>
                -->

                <!-- Icon Choices -->

                <div class="row" id="input-field-2">
                    <h1 style="text-align: center;">Customization</h1>
                    <div class="col m-3 category-1"><label for="category-color-text-1">Colour of text</label><input type="color" class="form-control" id="category-color-text-1" name="category-color-text-1" value="#000000"></div>
                    <div class="col m-3 category-1"><label for="category-color-bg-1">Colour of background</label><input type="color" class="form-control" id="category-color-bg-1" name="category-color-bg-1" value="#008000"s></div>
                    <div class="col m-3 category-1"><label for="category-icon-1">Category icon</label>
                        <select class="form-select" id="select-category-icon" name="category-icon-1">
                            <option icon="&#xf02d;" value="#xf02d">&#xf02d; Book</option>
                            <option icon="&#xf07a;" value="#xf07a">&#xf07a; Cart</option>
                            <option icon="&#xf2e7;" value="#xf2e7">&#xf2e7; Utensils</option>
                            <option icon="&#xf02c;" value="#xf02c">&#xf02c; Tags</option>
                            <option icon="&#xf1b9;" value="#xf1b9">&#xf1b9; Car</option>
                            <option icon="&#xf207;" value="#xf207">&#xf207; Bus</option>
                            <option icon="&#xf52f;" value="#xf52f">&#xf52f; Gas</option>
                            <option icon="&#xf3d1;" value="#xf3d1">&#xf3d1; Money</option>
                            <option icon="&#xf818;" value="#xf818">&#xf818; Pizza</option>
                            <option icon="&#xf805;" value="#xf805">&#xf805; Burger</option>
                            <option icon="&#xf015;" value="#xf015">&#xf015; House</option>
                            <option icon="&#xf001;" value="#xf001">&#xf001; Music</option>
                            <option icon="&#xf0f9;" value="#xf0f9">&#xf0f9; Ambulance</option>
                            <option icon="&#xf1fd;" value="#xf1fd">&#xf1fd; Birthday</option>
                            <option icon="&#xf06b;" value="#xf06b">&#xf06b; Gift</option>
                            <option icon="&#xf553;" value="#xf553">&#xf553; Shirt</option>
                            <option icon="&#xf6be;" value="#xf6be">&#xf6be; Cat</option>
                            <option icon="&#xf21e;" value="#xf21e">&#xf21e; Health</option>
                            <option icon="&#xf108;" value="#xf108">&#xf108; Desktop</option>
                            <option icon="&#xf484;" value="#xf484">&#xf484; Pills</option>
                            <option icon="&#xf025;" value="#xf025">&#xf025; Headphones</option>
                            <option icon="&#xf1eb;" value="#xf1eb">&#xf1eb; WiFi</option>
                            <option icon="&#xf11b;" value="#xf11b">&#xf11b; Gaming</option>
                            <option icon="&#xf84a;" value="#xf84a">&#xf84a; Cycling</option>
                            <option icon="&#xf810;" value="#xf810">&#xf810; Ice Cream</option>
                            <option icon="&#xf571;" value="#xf571">&#xf571; Bills</option>
                        </select>
                    </div>
                </div>

                <!--
                <div class="row" id="input-field-3">
                    <div class="col m-3 category-1"><label for="transaction-description-1">Description (optional)</label><input class="form-control" id="transaction-description-1" name="transaction-description-1" placeholder="Worth half the price of fresh peas!"></input></div>
                </div>

                -->
                
                <div class="control-buttons">

                    <div class="row">
                        <div class="col text-center clear-btn">
                            <input type="reset" class="btn btn-danger" value="CLEAR">
                            <button type="button" class="btn btn-danger d-none" id="delete-page-btn" onClick="deletePage()"><i class="fas fa-trash-alt"></i></button>
                        </div>

                    <div class="col text-center control-advanced-buttons">
                        <button type="button" class="btn btn-success d-none" id="previous-page-btn" onClick="prevPage()"><i class="fas fa-arrow-left"></i></button>
                        <button type="button" class="btn btn-success d-none" id="add-transaction-btn" onClick="newPage()"><i class="fas fa-plus"></i></button>
                        <button type="button" class="btn btn-success d-none" id="next-page-btn" onClick="nextPage()"><i class="fas fa-arrow-right"></i></button>
                    </div>

                    <div class="col text-center submit-btn">
                        <input type="hidden" id="pages" name="transaction-pages" value="1"/>
                        <button type="button" class="btn btn-primary" id="view-category-btn-add"><i class="far fa-eye"></i> VIEW</i></button>
                        <button type="submit" class="btn btn-success">SUBMIT</button>
                    </div>
                </div>

                <div class="row text-center d-none">
                    <p style="font-style: italic" id="page-number-text">Page 1 out of 1</p>
                </div>
            </div>
            </div>

            <div class="view_category_form d-none">
                <p style="text-align: center; font-weight: 600;">This is what your category looks like</p>

                <div class="sample-category-container" id="sample-category-container" style="margin: 0 auto; position: relative;">
                    <h3 id="view-category-text">INCOME</h3>

                    <i class="fas fa-money-bill-alt rotate-20 upscale-icon-11x" id="view-category-icon"></i>

                    <div class="sample-category-container-transactions">
                        <style type="text/css">
                            .tg  {border-collapse:collapse;border-spacing:0;}
                            .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                              overflow:hidden;padding:10px 5px;word-break:normal;}
                            .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                              font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
                            .tg .tg-i7zr{font-family:Arial, Helvetica, sans-serif !important;text-align:left;vertical-align:top}
                            .tg .tg-0lax{text-align:left;vertical-align:top}
                            </style>
                            <table style="width: 100%;" border="2">
                                <tbody>
                                    <tr>
                                        <td style="font-weight: 800; text-align: left; margin-left: 30px;">Subcategory</td>
                                        <td style="font-weight: 800; text-align: right; margin-right: 30px;">Cost</td>
                                    </tr>
                                    <tr>
                                        <td>Groceries</td>
                                        <td>£78.59</td>
                                    </tr>
                                    <tr>
                                        <td>Gifts</td>
                                        <td>£28.89</td>
                                    </tr>
                                    <tr>
                                        <td>Video Games</td>
                                        <td>£49.98</td>
                                    </tr>
                                    <tr>
                                        <td>Food</td>
                                        <td>£39.98</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- DivTable.com -->
                            <p>&nbsp;</p>
                    </div>

                    <button class="btn btn-primary" type="button" id="view-category-back-btn"><i class="fas fa-angle-double-left"></i> BACK</button>
                </div>

            </div>

            <div class="edit_transaction_form d-none">
                 <!-- Text Title --> 
                 <div class="row text-center"><p>Edit Category</p></div>
                
                 <!-- Transaction To Add -->

                 <div class="row" id="input-field-1">
                    <label for="category-select-1">Edit category</label>
                    <select class="form-select" id="select-category-from-db" name="category-select-1">
                        @isset($categories)
                        @foreach($categories as $category)

                        @if($loop->first)
                            <option selected>Select a category</option>
                        @endif

                        <option value={{$category->id}} onClick="editCategoryFields({{$category->id}})">{{$category->name}}</option>
                        @endforeach
                        @endisset
                    </select>
                    <!-- div class="col m-3 category-1"><label for="transaction-price-1">Price (£)</label><input class="form-control" id="transaction-price-1" name="transaction-price-1" placeholder="0.79" required></div> -->
                </div>

                 <div class="row" id="input-field-2">
                     <div class="col m-3 category-1"><label for="category-name-1-edit">Change Name</label><input class="form-control" id="category-name-1-edit" name="category-name-1-edit" placeholder="Frozen Peas" ></div>
                     <!-- div class="col m-3 category-1"><label for="transaction-price-1">Price (£)</label><input class="form-control" id="transaction-price-1" name="transaction-price-1" placeholder="0.79" required></div> -->
                 </div>
 
                 <!--
                 <div class="row" id="input-field-2">
                     <div class="col m-3 category-1"><label for="transaction-category-1">Category</label><input class="form-control" id="transaction-category-1" name="transaction-category-1" placeholder="Groceries" required></div>
                     <div class="col m-3 category-1"><label for="transaction-subcategory-1">Subcategory</label><input class="form-control" id="transaction-subcategory-1" name="transaction-subcategory-1" placeholder="Frozen Food" required></div>
                 </div>
                 -->
 
                 <div class="row" id="input-field-3">
                     <h1 style="text-align: center;">Customization</h1>
                     <div class="col m-3 category-1"><label for="category-color-text-1-edit">Colour of text</label><input type="color" class="form-control" id="category-color-text-1-edit" name="category-color-text-1-edit" value="#000000" required></div>
                     <div class="col m-3 category-1"><label for="category-color-bg-1-edit">Colour of background</label><input type="color" class="form-control" id="category-color-bg-1-edit" name="category-color-bg-1-edit" value="#008000" required></div>
                     <div class="col m-3 category-1"><label for="category-icon-1-edit">Category icon</label>
                         <select class="form-select" id="select-category-icon-edit" name="category-icon-1-edit">
                            <option icon="&#xf02d;" value="#xf02d">&#xf02d; Book</option>
                            <option icon="&#xf07a;" value="#xf07a">&#xf07a; Cart</option>
                            <option icon="&#xf2e7;" value="#xf2e7">&#xf2e7; Utensils</option>
                            <option icon="&#xf02c;" value="#xf02c">&#xf02c; Tags</option>
                            <option icon="&#xf1b9;" value="#xf1b9">&#xf1b9; Car</option>
                            <option icon="&#xf207;" value="#xf207">&#xf207; Bus</option>
                            <option icon="&#xf52f;" value="#xf52f">&#xf52f; Gas</option>
                            <option icon="&#xf3d1;" value="#xf3d1">&#xf3d1; Money</option>
                            <option icon="&#xf818;" value="#xf818">&#xf818; Pizza</option>
                            <option icon="&#xf805;" value="#xf805">&#xf805; Burger</option>
                            <option icon="&#xf015;" value="#xf015">&#xf015; House</option>
                            <option icon="&#xf001;" value="#xf001">&#xf001; Music</option>
                            <option icon="&#xf0f9;" value="#xf0f9">&#xf0f9; Ambulance</option>
                            <option icon="&#xf1fd;" value="#xf1fd">&#xf1fd; Birthday</option>
                            <option icon="&#xf06b;" value="#xf06b">&#xf06b; Gift</option>
                            <option icon="&#xf553;" value="#xf553">&#xf553; Shirt</option>
                            <option icon="&#xf6be;" value="#xf6be">&#xf6be; Cat</option>
                            <option icon="&#xf21e;" value="#xf21e">&#xf21e; Health</option>
                            <option icon="&#xf108;" value="#xf108">&#xf108; Desktop</option>
                            <option icon="&#xf484;" value="#xf484">&#xf484; Pills</option>
                            <option icon="&#xf025;" value="#xf025">&#xf025; Headphones</option>
                            <option icon="&#xf1eb;" value="#xf1eb">&#xf1eb; WiFi</option>
                            <option icon="&#xf11b;" value="#xf11b">&#xf11b; Gaming</option>
                            <option icon="&#xf84a;" value="#xf84a">&#xf84a; Cycling</option>
                            <option icon="&#xf810;" value="#xf810">&#xf810; Ice Cream</option>
                            <option icon="&#xf571;" value="#xf571">&#xf571; Bills</option>
                         </select>
                     </div>
                 </div>
 
                 <!--
                 <div class="row" id="input-field-3">
                     <div class="col m-3 category-1"><label for="transaction-description-1">Description (optional)</label><input class="form-control" id="transaction-description-1" name="transaction-description-1" placeholder="Worth half the price of fresh peas!"></input></div>
                 </div>
 
                 -->
                 
                 <div class="control-buttons">
 
                     <div class="row">
                         <div class="col text-center clear-btn">
                             <input type="reset" class="btn btn-danger" value="CLEAR">
                             <button type="button" class="btn btn-danger d-none" id="delete-page-btn" onClick="deletePage()"><i class="fas fa-trash-alt"></i></button>
                         </div>
 
                     <div class="col text-center control-advanced-buttons">
                         <button type="button" class="btn btn-success d-none" id="previous-page-btn" onClick="prevPage()"><i class="fas fa-arrow-left"></i></button>
                         <button type="button" class="btn btn-success d-none" id="add-transaction-btn" onClick="newPage()"><i class="fas fa-plus"></i></button>
                         <button type="button" class="btn btn-success d-none" id="next-page-btn" onClick="nextPage()"><i class="fas fa-arrow-right"></i></button>
                     </div>
 
                     <div class="col text-center submit-btn">
                         <input type="hidden" id="pages" name="transaction-pages" value="1"/>
                         <button type="button" class="btn btn-primary" id="view-category-btn-edit"><i class="far fa-eye"></i> VIEW</i></button>
                         <button type="submit" class="btn btn-success">SUBMIT</button>
                     </div>
                 </div>
 
                 <div class="row text-center d-none">
                     <p style="font-style: italic" id="page-number-text">Page 1 out of 1</p>
                 </div>
            </div>
        </div>

        <div class="delete_transaction_form d-none">
            <p class="text-center">WIP</p>
        </div>

        <div class="add_subcategory_form d-none">
            <div class="row text-center">
                <p>Add Subcategory</p>
            </div>
                
            <div class="col m-3">
            <label for="subcategory-select-1">1. Select a category</label>

            <select class="form-select" id="select-subcategory-from-db" name="subcategory-select-1">
                @isset($categories)
                @foreach($categories as $category)

                @if($loop->first)
                <option selected>Select a category</section>
                @endif

                <option value={{$category->id}} onClick="editSubcategoryFields({{$category->id}})">{{$category->name}}</option>
                @endforeach
                @endisset
            </select>
            </div>
            
            <!-- Transaction To Add -->
            <div class="row" id="input-field-1">
                <div class="col m-3 category-1"><label for="subcategory-name-1">Name of Subcategory</label><input class="form-control" type="text" id="subcategory-name-1" name="subcategory-name-1" placeholder="Bills" ></div>
                <!-- div class="col m-3 category-1"><label for="transaction-price-1">Price (£)</label><input class="form-control" id="transaction-price-1" name="transaction-price-1" placeholder="0.79" required></div> -->
            </div>

            <div class="col text-center submit-btn">
                <input type="hidden" name="_method" id="CATEGORY_METHOD" value="POST"> 
                <input type="hidden" id="pages" name="transaction-pages" value="1"/>
                <button type="button" class="btn btn-primary" id="view-category-btn-edit"><i class="far fa-eye"></i> VIEW</i></button>
                <button type="submit" class="btn btn-success">SUBMIT</button>
            </div>

        </div>

        <div class="edit_subcategory_form d-none">
            <div class="row text-center">
                <p>Edit Subcategory Name</p>
            </div>
                
            <div class="col m-3">
            <label for="category-select-1-edit">1. Select a category</label>

            <select class="form-select" id="select-edit-category-from-db" name="category-select-1-edit">
                @isset($categories)
                @foreach($categories as $category)

                <option value={{$category->id}} onClick="editSubcategoryFields_editform({{$category->id}})">{{$category->name}}</option>
                @endforeach
                @endisset
            </select>

        
            </div>

            <div class="col m-3">
                <label for="subcategory-select-1-edit">2. Select a subcategory</label>
    
                <select class="form-select" id="select-edit-subcategory-from-db" name="subcategory-select-1-edit">
                    
                </select>
    
                
            </div>

            <div class="col m-3">
                <label for="subcategory-select-1-edit-input">3. Change the subcategory name</label>
    
                <div class="col subcategory-1-edit"><input class="form-control" type="text" id="subcategory-select-1-edit-input" name="subcategory-select-1-edit-input" placeholder="Bills" ></div>
            </div>

            <button type="submit" class="btn btn-success" style="width: 100%;">SUBMIT</button>
            
        </div>
            
        </form>

        <!-- 
        <div class="transactions-sidebar">

            <div id="transaction-sb-1" class="sb-selected">
                <p class="transactions-sb-name">Baked Beans</p>
                <div class="transaction-sb-subtitles-1">
                    <p class="transactions-sb-number" style="text-align: left;">#1</p>
                    <p class="transactions-sb-price" style="text-align: right;">£0.49</p>
                </div>
            </div>

            <div id="transaction-sb-2">
                <p class="transactions-sb-name">Gaming PC</p>
                <div class="transaction-sb-subtitles-1">
                    <p class="transactions-sb-number" style="text-align: left;">#2</p>
                    <p class="transactions-sb-price" style="text-align: right;">£750.00</p>
                </div>
            </div>

        </div>

        -->
    </div>
    </div>
    
    <!-- ADVANCED: Create a sidebar which tracks your pages
    <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white position-absolute top-0 end-0" style="width: 380px;">
    <a href="/" class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
      <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
      <span class="fs-5 fw-semibold">List group</span>
    </a>
    <div class="list-group list-group-flush border-bottom scrollarea">
      <a href="#" class="list-group-item list-group-item-action active py-3 lh-tight" aria-current="true">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small>Wed</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Tues</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Mon</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>

      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Wed</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Tues</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Mon</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Wed</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Tues</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Mon</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Wed</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Tues</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Mon</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
    </div>
    -->
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

    /*

    pageNumber Variables Explained

    pageNumber - indicates what page you're on.
    pageNumber_index - 

    */
    var pageNumber = 1;
    var pageNumber_index = 0;
    
    //var pageNumber_display = pageNumber_index + 1;
    var noOfPages = 1;


    // The Page Balancer: Weird name, but basically ensures that the nextPage function does not go out of page range.
    var pageBalancer = 1;

    var page_numbers = [1]

    var page_content = {}

    function updatePageNumber() {
        pageNumber_index += 1
        $("#page-number-text").text("Page " + pageNumber_index + " out of " + page_numbers.length)
        pageNumber_index -= 1
    }

    function createNewPage() {

        var page_content_toupdate_name = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-name-${noOfPages}">Name</label><input class="form-control" id="transaction-${noOfPages}-name" name="transaction-name-${noOfPages}" placeholder="${placeholder_text_JSON[r]['name']}" required></input></div>`
        var page_content_toupdate_price = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-price-${noOfPages}">Price (£)</label><input class="form-control" id="transaction-${noOfPages}-price" name="transaction-price-${noOfPages}" placeholder="${placeholder_text_JSON[r]['price']}" required></input></div>`
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
        if (pageNumber_index > 0) {
         // If the page number basically isn't one, go to the previous page.
         pageNumber_index -= 1
         pageNumber = page_numbers[pageNumber_index]
       } else {
         // If Page Number is less than 1, go to the most recent page. THIS IS INTENDED so the user doesn't have to click a lot of times to get to a certain page.
         pageNumber_index = page_numbers.length-1 //page_numbers.slice(-1)[0]-1;
         pageNumber = page_numbers[pageNumber_index];
       }
      updatePageNumber()
      updatePageContents()
      
      console.log(page_numbers)
      console.log(pageNumber, pageNumber_index)
      console.log('Previous page.')

    }

    function updatePageLength() {
        //noOfPages = page_numbers.length;
    }

    function newPage() {
        
        noOfPages += 1;
        //pageNumber = noOfPages;
        //pageNumber_index = noOfPages;
        page_numbers.push(noOfPages)
        
        updatePageLength()

        console.log('NEW PAGE', page_numbers)

        updatePageNumber()
        createNewPage()
        updatePageContents()
        updatePagesList()
    }
 
    function nextPage() {
       if (pageNumber_index >= 0 && pageNumber_index < noOfPages-pageBalancer) {
         pageNumber_index += 1
         pageNumber = page_numbers[pageNumber_index]
       } else {
         pageNumber_index = 0;
         pageNumber = page_numbers[pageNumber_index]
       }
       updatePageNumber()
       updatePageContents()

       console.log(page_numbers)
       console.log(pageNumber, pageNumber_index, noOfPages-pageBalancer)
       console.log('Next page.')
    }

    function deletePage() {
        if (noOfPages == 1) {
            // You can't delete any more pages silly!
        } else {
            $(`.transaction-${pageNumber}`).remove()
            
            page_numbers.splice(pageNumber-1,1)

            updatePageLength()

            console.log(page_numbers)

            //noOfPages -= 1
            if (pageNumber != 1) {
                pageNumber -= 1
            }

            //pageNumber_index = pageNumber.length-1

            console.log(pageNumber, pageNumber_index, noOfPages-pageBalancer)

            pageBalancer += 1
            
            updatePageContents()
            updatePageNumber()
            updatePagesList()
            

            
        }
    }

    function updatePagesList() {
        document.getElementById('pages').value = page_numbers
    }

    function createNewSidebar() {

    }

    function viewCategory() {
        
    }

    ////////////////////////////////////////////

    $("#transaction-add-btn, #transaction-edit-btn, #transaction-delete-btn, #transaction-view-btn").click(function() {
        //console.log('Clicked')
        
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
            $(".add_subcategory_form").removeClass("d-none");
            
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".add_subcategory_form").addClass("d-none");
        }

        if($('#transaction-view-btn').is(':checked')) {
            $(".edit_subcategory_form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".edit_subcategory_form").addClass("d-none");
        }

        updateMethod()
    });

    // View Category Button
    $("#view-category-btn-add, #view-category-btn-edit").click(function() {
        if($('#transaction-add-btn').is(':checked')) {
            
            $(".add_transaction_form").addClass("d-none");
            
            $(".view_category_form").removeClass("d-none");
            
            // Modify Text Color
            var textColor_div = document.getElementById("sample-category-container");
            var textColor = $("#category-color-text-1").val(); 

            textColor_div.style.color = textColor;


            // Modify Category Color
            var categoryColor = document.getElementById("sample-category-container");

            var orientation = '151deg';
            var colorOne = '#ffffff';
            var colorTwo = $("#category-color-bg-1").val();  

            categoryColor.style.backgroundImage = `-moz-linear-gradient(${orientation}, ${colorOne}, ${colorTwo})`


            // Modify Icon Chosen
            var icon_div = document.getElementById('view-category-icon')
            
            //var iconChosen = $("#select-category-icon").val();

            //var iconChosen = document.getElementById("select-category-icon").getAttribute("icon");

            var iconChosen = $('#select-category-icon option:selected').attr('icon');

            $("#view-category-icon").removeClass("fa-money-bill-alt");

            $("#view-category-icon").text(iconChosen);

            // Modify Text Title
            var textValue = $('#category-name-1').val()

            $("#view-category-text").text(textValue);


        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".add_transaction_form").addClass("d-none");
        }  

        // If Transaction Edit Mode Is Checked

        if($('#transaction-edit-btn').is(':checked')) {
            $(".edit_transaction_form").addClass("d-none");
            
            $(".view_category_form").removeClass("d-none");
            
            // Modify Text Color
            var textColor_div = document.getElementById("sample-category-container");
            var textColor = $("#category-color-text-1-edit").val(); 

            textColor_div.style.color = textColor;


            // Modify Category Color
            var categoryColor = document.getElementById("sample-category-container");

            var orientation = '151deg';
            var colorOne = '#ffffff';
            var colorTwo = $("#category-color-bg-1-edit").val();  

            categoryColor.style.backgroundImage = `-moz-linear-gradient(${orientation}, ${colorOne}, ${colorTwo})`


            // Modify Icon Chosen
            var icon_div = document.getElementById('view-category-icon')
            
            //var iconChosen = "&" + $("#select-category-icon-edit").val() + ";";

            var iconChosen = $('#select-category-icon-edit option:selected').attr('icon');
            $("#view-category-icon").removeClass("fa-money-bill-alt");

            $("#view-category-icon").text(iconChosen);

            // Modify Text Title
            var textValue = $('#category-name-1-edit').val()

            $("#view-category-text").text(textValue);

        }

    });


    $("#view-category-back-btn").click(function() {
        if($('#transaction-add-btn').is(':checked')) {
            
            $(".add_transaction_form").removeClass("d-none");
            
            $(".view_category_form").addClass("d-none");

        
            //$("#transaction-add-btn").toggleClass("selected-orange");
        } //else {
          //  $(".add_transaction_form").addClass("d-none");
        //}

        if($('#transaction-edit-btn').is(':checked')) {
            
            $(".edit_transaction_form").removeClass("d-none");
            
            $(".view_category_form").addClass("d-none");

        
            //$("#transaction-add-btn").toggleClass("selected-orange");
        } //else {
           // $(".add_transaction_form").addClass("d-none");
        //}
    });
    
    function updateMethod() {
        var AddCategoryRadio = document.getElementById("transaction-add-btn");

        var EditCategoryRadio = document.getElementById("transaction-edit-btn");

        var AddSubcategoryRadio = document.getElementById("transaction-delete-btn");

        var EditSubcategoryRadio = document.getElementById("transaction-view-btn");

        if (AddCategoryRadio.checked) {
            console.log('Add Category radio is checked!')

            document.getElementById("CATEGORY_METHOD").setAttribute("value", "POST")
            document.getElementById("THE-FORM").setAttribute("action", "/budgeting-app/app/categories")
        }

        //var category = @json($categories)[id-1];
        

        if (EditCategoryRadio.checked) {
            console.log('Edit Category radio is checked!')

            document.getElementById("CATEGORY_METHOD").setAttribute("value", "PUT")
            //document.getElementById("THE-FORM").setAttribute("action", `/budgeting-app/app/categories/${category['id']}`)
        }

        if (AddSubcategoryRadio.checked) {
            console.log('Add Subcategory radio is checked!')

            document.getElementById("CATEGORY_METHOD").setAttribute("value", "POST")
            document.getElementById("THE-FORM").setAttribute("action", `/budgeting-app/app/subcategories/add/NONE`)
        }

        if (EditSubcategoryRadio.checked) {
            console.log('Edit subcategory radio is checked!')

            document.getElementById("CATEGORY_METHOD").setAttribute("value", "PUT")
            document.getElementById("THE-FORM").setAttribute("action", `/budgeting-app/app/subcategories/edit/NONE`)
        }

    }

    function editCategoryFields(id) {
        console.log('ECF ' + id);
        
        //document.getElementById('category-name-1-edit').setAttribute("value", "text");

        // Subtract id by 1 since JSON indexing starts at 0
        var category = @json($categories)[id-1];

        console.log(category);

        $('#category-name-1-edit').val(`${category['name']}`);
        
        $('#category-color-bg-1-edit').val(`${category['color-bg']}`);

        $('#category-color-text-1-edit').val(`${category['color-text']}`);

        var iconCode = category['icon-code']

        // The first and last characters are sliced so that the icon code can change.
        var _iconCode = iconCode.slice(0, -1) 
        _iconCode = _iconCode.slice(1)

        console.log(_iconCode);
        
        $('#select-category-icon-edit').val(`${_iconCode}`).change();

        // Prepare THE FORM to edit the appropriate category.

        document.getElementById("CATEGORY_METHOD").setAttribute("value", "PUT")
        document.getElementById("THE-FORM").setAttribute("action", `/budgeting-app/app/categories/${category['id']}`)

    }

    function editSubcategoryFields(id) {
        
        //document.getElementById('category-name-1-edit').setAttribute("value", "text");

        // Subtract id by 1 since JSON indexing starts at 0
        var category = @json($categories)[id-1];
        
        // Prepare THE FORM to edit the appropriate category.

        document.getElementById("CATEGORY_METHOD").setAttribute("value", "POST")
        document.getElementById("THE-FORM").setAttribute("action", `/budgeting-app/app/subcategories/add/${category['id']}`)

    }

    function editSubcategoryFields_editform(section_id) {

        // Subtract id by 1 since JSON indexing starts at 0
        var section = @json($sections)[section_id-1];

        console.log(section);
        
        // Prepare THE FORM to edit the appropriate category.

        document.getElementById("CATEGORY_METHOD").setAttribute("value", "PUT")
        document.getElementById("THE-FORM").setAttribute("action", `/budgeting-app/app/subcategories/edit/${section['id']}`)

    }

    $(document).ready(function() {
        $(`#select-edit-category-from-db`).on('click', function(){
          
          var id = this.value;
          //var index = $(this).attr("index");
          var url=`/budgeting-app/app/getsubcategories_edit/${id}`;

          $(`#select-edit-subcategory-from-db`).load(url);
            });
    });


    
</script>

</html>