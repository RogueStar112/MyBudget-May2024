
    @inject('sum_cost', 'App\Http\Controllers\MyBudgetSetBudgetController')
    

    <script>   
        
        console.log('START DATE: ' + {{Js::from($start_date)}} + 'END DATE: ' + {{ Js::from($end_date) }})
        var column_select_val = {{ Js::from($start_date) }}
        
        var column_search_val = {{ Js::from($end_date) }}

        console.log('FRANKFURTER: ' + column_select_val + column_search_val)

    </script>

    <h1 class="text-center">Budgets found!</h1>
        
    <div id="THE-BUDGET-CONTAINER">
    @foreach($all_categories_selected as $category_selected)
    

    @if($loop->index % 3 == 0 or $loop->iteration == 1)
        <div class="row">
    @endif

    <div class="col-sm">

        <div class="section-container">
            
                
            <div class="section-custom" style="background-color: {{$category_selected['color-bg']}}; ">
                
                @php
                    
                @endphp
                <div class="section-icon">
                    <i class="fas upscale-icon-2x" style="color: {{$category_selected['color-text']}};"id="">{{html_entity_decode($category_selected['icon-code'])}}</i>
                </div>
            
            </div>


            <div class="section-wrapper-dark">

                <!-- <div class="section-remover">

                </div>
                -->
                
                <div class="section-title">
                    {{$category_selected->name}}
                </div>
            </div>
            
        </div>
        
        <div class="section-details">
            <table class="table">

                <thead>
                    
                    <tr class="text-center">
                    <th class="col-md-4 text-center">Section</th>
                    <th class="col-md-4 text-center">Budget</th>
                    <th class="col-md-2">Cost</th>
                    <th class="col-md-2">%</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    
                    $GET_SECTIONS = DB::table('mybudget_section')
                    ->select('*')
                    ->where('category_id', '=', $category_selected->id)
                    ->get();
                    
                    @endphp

                    @foreach($GET_SECTIONS as $SECTION)
                    
                        @if($loop->iteration % 2 == 1)
                        
                            <tr class="text-center">
                                <td class="col-md-4 text-center">{{$SECTION->name}}</th>
                                <td class="d-flex justify-content-around">

                                    @isset($start_date, $end_date)
                                    @php



                                        $GET_SECTION_BUDGET_FROM_SECTION = DB::table('mybudget_sectionbudget')
                                                                            ->select('budget')
                                                                            ->where('section_id', '=', $SECTION->id)
                                                                            ->where("date_start", "=", $start_date)
                                                                            ->where("date_end", "=", $end_date)
                                                                            ->get();
                                        

                                    
                                    @endphp

                                    @foreach($GET_SECTION_BUDGET_FROM_SECTION as $SECTION_BUDGET)

                                    @php
                                    $budget_of_section = $SECTION_BUDGET->budget ?? 1;
 

                                    @endphp
                                    <input class="form-control" placeholder="Budget" value="{{(float)number_format($SECTION_BUDGET->budget, 2)}}" unique_category="{{$category_selected['id']}}" unique_identifier="{{$SECTION->id}}" id="input-budget-{{$SECTION->id}}" name="input-budget-{{$SECTION->id}}" /> 
                                    
                                    @endforeach
                                    
                                    @if($GET_SECTION_BUDGET_FROM_SECTION->count() == 0 || $budget_of_section == 'N/A')
                                    
                                    <input class="form-control" placeholder="Budget" value="" unique_category="{{$category_selected['id']}}" unique_identifier="{{$SECTION->id}}" id="input-budget-{{$SECTION->id}}" name="input-budget-{{$SECTION->id}}" /> 
                                    
                                    

                                    @endif

                                    @endisset
                                    
                                
                                </td>

                                <td>@php $section_sum = json_decode($sum_cost->get_sum_cost_within_date_range($category_selected['id'], $SECTION->id, $start_date, $end_date), false)[0]->sum_price ?? null;
                                    if ($section_sum != NULL) {
                                    //echo '£' . $section_sum;
                                    $section_sum = number_format($section_sum, 2);

                                    echo '£' . $section_sum;
                                    } else {
                                        $section_sum = 0;
                                        echo '£0.00';
                                    }
                                @endphp</td>

                                <td>
                                    @php
                                    $budget_of_section = $SECTION_BUDGET->budget ?? 'N/A';
 

                                    @endphp

                                    @php
                                     if ($section_sum != NULL and $budget_of_section != 'N/A' ) {
                                        if (($section_sum / (float)$budget_of_section) > 1) {
                                            $perc = number_format(($section_sum / $budget_of_section) * 100);
                                            echo "<p style='color: red'; class='fw-bold '> $perc%</p>";
                                        } else {
                                            $perc = number_format(($section_sum / $budget_of_section) * 100);
                                            echo "<p style='color: green;' class=''>$perc%</p>";
                                        }
                                    } else {
                                        echo 'N/A';
                                    }
                                    @endphp
                                </td>
                            </tr>
                    
                        @else
                            <tr class="text-center" style="background-color: {{$category_selected['color-bg']}}; color: {{$category_selected['color-text']}};  ">
                                <td class="col-md-4 text-center">{{$SECTION->name}}</th>
                                <td class="d-flex justify-content-around">

                                    @isset($start_date, $end_date)
                                    @php
                                    
                                        $GET_SECTION_BUDGET_FROM_SECTION = DB::table('mybudget_sectionbudget')
                                                                            ->select('budget')
                                                                            ->where('section_id', '=', $SECTION->id)
                                                                            ->where("date_start", "=", $start_date)
                                                                            ->where("date_end", "=", $end_date)
                                                                            ->get();

                                        
                                        
                                    @endphp

                                    @foreach($GET_SECTION_BUDGET_FROM_SECTION as $SECTION_BUDGET)

                                    @php
                                        $budget_of_section = $SECTION_BUDGET->budget ?? 'N/A';
                                    @endphp

                                    <input class="form-control" placeholder="Budget" value="{{(float)number_format($SECTION_BUDGET->budget, 2)}}" unique_category="{{$category_selected['id']}}" unique_identifier="{{$SECTION->id}}" id="input-budget-{{$SECTION->id}}" name="input-budget-{{$SECTION->id}}" /> 
                                    
                                    @endforeach
                                    
                                    @if($GET_SECTION_BUDGET_FROM_SECTION->count() == 0 || $budget_of_section == 'N/A')
                                    
                                    <input class="form-control" placeholder="Budget" value="" unique_category="{{$category_selected['id']}}" unique_identifier="{{$SECTION->id}}" id="input-budget-{{$SECTION->id}}" name="input-budget-{{$SECTION->id}}" /> 
                                    
                                    

                                    @endif

                                    @endisset
                                    
                                
                                </td>

                                <td>@php $section_sum = json_decode($sum_cost->get_sum_cost_within_date_range((int)$category_selected['id'], (int)$SECTION->id, $start_date, $end_date), false)[0]->sum_price ?? null;
                                    if ($section_sum != NULL) {
                                    //echo '£' . $section_sum;
                                    $section_sum = number_format($section_sum, 2);

                                    echo '£' . $section_sum;
                                    } else {
                                        $section_sum = 0;
                                        echo '£0.00';
                                    }
                                @endphp</td>

                                <td>
                                    @php
                                    $budget_of_section = $SECTION_BUDGET->budget ?? 'N/A';
 

                                    @endphp

                                    @php
                                    if ($section_sum != NULL and $budget_of_section != 'N/A' ) {
                                        if (((float)$section_sum / (float)$budget_of_section) > 1) {
                                            
                                            echo 'SS ' . $section_sum, 'BOS ' . $budget_of_section;

                                            $perc = number_format(((float)$section_sum / (float)$budget_of_section) * 100, 2);
                                            
                                            echo "<p style='color: red'; class='fw-bold '> $perc%</p>";

                                            
                                        } else {

                                            echo 'SS ' . $section_sum, 'BOS ' . $budget_of_section;

                                            $perc = number_format(((float)$section_sum / (float)$budget_of_section) * 100, 2);
                                            echo "<p style='color: green;' class=''>$perc%</p>";
                                        }
                                    } else {
                                        echo 'N/A';
                                    }
                                    @endphp
                                </td>
                            </tr>
                        @endif

                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    @if($loop->iteration % 3 == 0)
        <!-- Close the Row Div -->
        </div>
    @endif 
    @endforeach
    
    <div class="row">
    
    <input type="hidden" id="pages" name="setbudget-pages" value="1"/>
    <button type="submit" style="width: 100%;" class="btn btn-success">SUBMIT</button>
    
    </div>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script
                  src="https://code.jquery.com/jquery-3.6.0.js"
                  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
                  crossorigin="anonymous"></script>
            
    <script>   

        var column_select_val = {{ Js::from($start_date) }}
        
        var column_search_val = {{ Js::from($end_date) }}

        console.log(column_search_val, column_select_val);

        // Load Subcategories for the appropriate Category
        $(document).ready(function() {
        $('#setbudget_category').on('click', function(){
          
          var id = this.value;
          var url=`/budgeting-app/app/budget/${id}`;
    
          console.log(url);
    
    
          $('#setbudget_section_select').load(url);
            });
        });
    
    
        $("#budget-add-radio, #budget-edit-radio").click(function() {
            console.log('Clicked')
            
            if($('#budget-add-radio').is(':checked')) {
                $(".create-budget-form").removeClass("d-none");
            //$("#transaction-add-btn").toggleClass("selected-orange");
            } else {
                $(".create-budget-form").addClass("d-none");
            }
    
            if($('#budget-edit-radio').is(':checked')) {
                $(".view-budget-form").removeClass("d-none");
            //$("#transaction-add-btn").toggleClass("selected-orange");
            } else {
                $(".view-budget-form").addClass("d-none");
            
            }
    
    
        });
    
        $("#setbudget_date_end").change(function(e) {
        e.preventDefault();
                
            var column_select_val = {{ Js::from($start_date) }}
    
            var column_search_val = {{ Js::from($end_date) }}

            console.log(column_search_val, column_select_val);


    
            $.ajax({
            
            type: "GET",
    
            url: `/budgeting-app/app/budget/${column_select_val}/${column_search_val}`,
            success: function (data) {
                        $("#THE-BUDGET-CONTAINER").html(data);
                        console.log('success!')
                    }
            });
    
        });
    
        $(document).ready(function() {
            
            var column_select_val = $('#setbudget_date_start').val();
    
            var column_search_val = $('#setbudget_date_end').val();
            
            var setbudget_array = [];
    
            var input_budgets = document.querySelectorAll('*[id^="input-budget-"]');
    
            for (let i = 0; i < input_budgets.length; i++) {
                setbudget_array.push(input_budgets[i].getAttribute('unique_identifier'))
            }
    
            console.log(setbudget_array);
    
            document.getElementById('pages').value = setbudget_array;
    
        })
    
    </script>
