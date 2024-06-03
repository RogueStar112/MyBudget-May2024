<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use App\Models\mybudget_category;
use App\Models\mybudget_item;

use app\Http\Controllers\fpdfmodules\PDFRotate;
use app\Http\Controllers\fpdfmodules\PDFSector;

require('fpdfmodules/PDFRotate.php');
require('fpdfmodules/PDFSector.php');

class PdfController extends Controller
{
	protected $fpdf;
 
    public function __construct()
    {
        $this->fpdf = new fpdfmodules\PDF;
        $this->fpdf_graph = new fpdfmodules\PDF_Diag;
        $this->page_height = 297; // mm
    }

    public function Header() {
        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->AddPage("A4", [100,100]);
        
        $this->fpdf->Text(10, 10, "MyBudget");
        
        $this->fpdf->Text(10, 15, "Spending Report"); 
        
        $this->Watermark();
        
    }

    public function Watermark() {
        $this->fpdf->SetFont('Arial', 'B', 15);

        $this->fpdf->SetTextColor(255,222,233);

        //$this->fpdf->Set(28);
        
        $this->fpdf->RotatedText(42,60,'Rogue112',45);

        //$this->fpdf->Text(10, 10, "MyBudget");

        $this->fpdf->SetFont('Arial', '', 4);
        $this->fpdf->SetTextColor(0,0,0);
    }

    public function Header_Dates($start_date, $end_date) {
        
        $start_date_DMY = date("d/m/Y", strtotime($start_date));
        
        $end_date_DMY = date("d/m/Y", strtotime($end_date));

        $this->fpdf->SetY(15);

        $this->fpdf->SetFont('Arial', 'I', 10);

        $this->fpdf->Cell(25,10,"$start_date_DMY to $end_date_DMY",0,1);
        

    }

    public function Body_Summary($start_date, $end_date) {
        $insert_userid = Auth::id();

        $this->fpdf->SetFont('Arial', 'I', 13);

        $this->fpdf->Cell(15,4,"Category Summary",0,"C");
        
        $this->fpdf->SetFont('Arial', '', 4);
        $this->fpdf->Ln();

        $this->fpdf->Cell(6,4,"#",'B',0,"C");
        $this->fpdf->Cell(15,4,"Name",'B',0,"C");
        $this->fpdf->Cell(15,4,"Price",'B',0,"C");
        $this->fpdf->Ln();
        
        $start_date .= " 00:00:00";
        $end_date .= " 23:59:59";



        $GET_ALL_CATEGORIES = DB::table('mybudget_category')
                                ->select('id', 'name')
                                ->where('mybudget_category.user_id', "=", "$insert_userid")
                                ->get();


        $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('mybudget_section.user_id', "=", "$insert_userid")
                                        //->orderBy('category_id', 'asc')
                                        //->where('category_id', $id)
                                        
                                        ->get();


        //return $GET_SECTIONS_FROM_CATEGORY;
        
        $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                    ->select('*')
                                    ->where('deleted_at', '=', NULL)
                                    ->where('mybudget_item.user_id', "=", "$insert_userid")
                                    ->whereBetween("created_at", [$start_date, $end_date])
                                    ->get();


        $section_list = array();
    
        
         $SECTION_SUM = [];

        // Get ALL 
        // Assuming $GET_ALL_CATEGORIES is already populated and $insert_userid, $start_date, $end_date are defined

            $CATEGORY_IDS = array_column($GET_ALL_CATEGORIES->toArray(), 'id');

            // Fetch all sections for the given categories and user in one query
            $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                ->select('id', 'name', 'category_id')
                ->whereIn('category_id', $CATEGORY_IDS)
                ->where('user_id', '=', $insert_userid)
                ->where('mybudget_section.user_id', "=", "$insert_userid")
                ->get();

            // Group sections by category_id for easy access
            $sectionsByCategory = $GET_SECTIONS_FROM_CATEGORY->groupBy('category_id');

            // Fetch all items for the given categories, sections, and user in one query
            $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                ->select('category_id', 'section_id', 'price')
                ->whereNull('deleted_at')
                ->whereIn('category_id', $CATEGORY_IDS)
                ->whereIn('section_id', $GET_SECTIONS_FROM_CATEGORY->pluck('id'))
                ->where('user_id', '=', $insert_userid)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->where('has_subtransactions', '=', '0')
                ->where('mybudget_item.user_id', "=", "$insert_userid")
                ->get();

            // Initialize an empty array for sums
            $SECTION_SUM = [];

            // Iterate through categories
            foreach ($GET_ALL_CATEGORIES as $category) {
                $CATEGORY_ID = $category->id;
                $CATEGORY_NAME = $category->name;

                if (isset($sectionsByCategory[$CATEGORY_ID])) {
                    foreach ($sectionsByCategory[$CATEGORY_ID] as $section) {
                        $SECTION_ID = $section->id;
                        $SECTION_NAME = $section->name;

                        // Sum items for this section
                        $sum = $GET_ITEMS_FROM_SECTION->where('category_id', $CATEGORY_ID)->where('section_id', $SECTION_ID)->sum('price');
                        $SECTION_SUM[$CATEGORY_NAME][$SECTION_NAME] = $sum;
                    }
                }
            }

        $index = 0;
        $subindex = 0;

        $TOTAL_FOR_SECTION = 0;
        foreach($SECTION_SUM as $section => $subsection){
            
            //Category in all capital letters
            $section_all_caps = strtoupper($section);
            
            //$this->fpdf->AddPage("A4", [100,100]);

            if (count($subsection) != 0) {

                if($this->fpdf->GetY() > 69) {
                $this->fpdf->SetY(-15);
                
                $this->Footer('Category Summary', '2022-05-01', '2022-05-31');

                $this->fpdf->AddPage("A4", [100,100]);

                $this->fpdf->SetFont('Arial', 'BI', 10);

                //$this->fpdf->SetFillColor(255,0,0);
                
                // $this->fpdf->Cell(0,4,"$section_all_caps",'B',1,"R",true);
                $this->fpdf->Cell(0,4,"$section_all_caps",'B',1,"R");

                $this->fpdf->SetFont('Arial', '', 4);    
                
                $this->Watermark();
                } else {
                    $this->fpdf->SetFont('Arial', 'BI', 10);

                    //$this->fpdf->SetFillColor(255,0,0);

                    $this->fpdf->Cell(0,4,"$section_all_caps",'B',1,"R");


                    $this->fpdf->SetFont('Arial', '', 4);    
                }
            }

            arsort($subsection);
            $index++;

            foreach($subsection as $ss_key => $ss_value){

                $ss_value_display = chr(163) . number_format($ss_value, 2);
                $subindex++;
                $TOTAL_FOR_SECTION += $ss_value;
                if($this->fpdf->GetY() > 69) {
                    $this->fpdf->SetY(-15);
                    $this->Footer('Category Summary', '2022-05-01', '2022-05-31');
                    $this->fpdf->AddPage("A4", [100,100]);
                    $this->fpdf->Cell(6,4,"$index.$subindex",'BR',0,"C");
                    $this->fpdf->Cell(15,4,"$ss_key",'BR',0,"C");
                    $this->fpdf->Cell(15,4,"$ss_value_display",'BR',0,"C");
                    $this->fpdf->Ln();
                    $this->Watermark();
                } else {
                    $this->fpdf->Cell(6,4,"$index.$subindex",'BR',0,"C");
                    $this->fpdf->Cell(15,4,"$ss_key",'BR',0,"C");
                    $this->fpdf->Cell(15,4,"$ss_value_display",'BR',0,"C");
                    $this->fpdf->Ln();    
                }

            }

            /*
            $TOTAL_FOR_SECTION_DISPLAY = chr(163) . number_format($TOTAL_FOR_SECTION, 2);

            $this->fpdf->Cell(6,4,"TOTAL FOR SECTION: ",'B',0,"C");
            $this->fpdf->Cell(0,4,"$TOTAL_FOR_SECTION_DISPLAY",'B',0,"C");
            $this->fpdf->Ln();

            $TOTAL_FOR_SECTION = 0;
            */

            // For every section finished, reset subindex to 0.
            $subindex = 0;

        }

        $this->fpdf->SetY(-15);
        $this->Footer('End of Category Summary', '2022-05-01', '2022-05-31');
        $this->fpdf->AddPage("A4", [100,100]);
    }

    public function Body_Transactions($start_date, $end_date) {

        $this->Watermark();

        $this->fpdf->SetFont('Arial', 'I', 16);

        $this->fpdf->Cell(15,4,"Transactions Table",'',0,"L");

        $this->fpdf->SetFont('Arial', '', 4);
        $this->fpdf->SetTextColor(0,0,0);

        $mybudget_item_table = DB::table('mybudget_item')
                                    ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                    ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                    ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                    ->select('mybudget_item.*', 'mybudget_item.id as budget_id', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                    //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                    ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                    ->where('section_name', '!=', 'Income')
                                    ->whereNull('mybudget_item.deleted_at')
                                    ->whereBetween(\DB::raw('DATE(mybudget_item.created_at)'), [$start_date, $end_date])
                                    ->orderBy('mybudget_item.created_at', 'asc')
                                    //->limit(25)
                                    ->get();

        /*
        $mybudget_item_table_SUM = DB::table('mybudget_item')
                                    ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                    ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                    ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                    ->select('mybudget_item.*', 'mybudget_item.id as budget_id', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                    //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                    ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                    ->where('section_name', '!=', 'Income')
                                    ->whereNull('mybudget_item.deleted_at')
                                    ->whereBetween(\DB::raw('DATE(mybudget_item.created_at)'), [$start_date, $end_date])
                                    ->orderBy('mybudget_item.created_at', 'asc')
                                    ->sum('mybudget_item.price');
        */
        
        $this->fpdf->SetY(25);
        
        /*
        for($i=0; $i<count($mybudget_item_table); $i++) {
            if($i==0) {
                $this->fpdf->Cell(15,5,"Name",1,0,"C");
                $this->fpdf->Cell(15,5,"Price",1,0,"C");
                $this->fpdf->Cell(15,5,"Date",1,0,"C");
                $this->fpdf->Cell(15,5,"Category",1,0,"C");
                $this->fpdf->Cell(15,5,"Section",1,0,"C");
                $this->fpdf->Ln();
            }
        }
        */

        $this->fpdf->Cell(6,4,"#",'B',0,"C");
        $this->fpdf->Cell(15,4,"Name",'B',0,"C");
        $this->fpdf->Cell(15,4,"Price",'B',0,"C");
        $this->fpdf->Cell(15,4,"Date",'B',0,"C");
        $this->fpdf->Cell(15,4,"Category",'B',0,"C");
        $this->fpdf->Cell(15,4,"Section",'B',0,"C");
        //$this->fpdf->Cell(4,4,"GetY",'B',0,"C");
        $this->fpdf->Ln();

        $index = 0;

        $transactions_sum = 0;

        $mybudget_item_array = [];

        //echo $mybudget_item_array;

        // The purpose of this array is to find the last value
        foreach ($mybudget_item_table as $item_cell) {
            array_push($mybudget_item_array, $item_cell->budget_id);
        }

        foreach ($mybudget_item_table as $item_cell) {
            $index++;
            $name = $item_cell->name;
            //chr(163) = the £ pound character

            $price = chr(163) . number_format($item_cell->price, 2);
            $created_date = date('d/m/Y', strtotime($item_cell->created_at));
            $category_name = $item_cell->category_name;
            $section_name = $item_cell->section_name;


            $get_y_coords = $this->fpdf->GetY();
            
            // This is the point where the page breaks

            if($get_y_coords > 69) {
                $this->fpdf->SetY(-15);
                $this->Footer('Transaction Table', '2022-05-01', '2022-05-31');
                $this->fpdf->AddPage("A4", [100,100]);
                $this->fpdf->Cell(5,4,"$index",'BR',0,"C");
                $this->fpdf->Cell(15,4,"$name",'B',0,"L");
                $this->fpdf->Cell(15,4,"$price",'B',0,"C");
                $this->fpdf->Cell(15,4,"$created_date",'B',0,"C");
                $this->fpdf->Cell(15,4,"$category_name",'B',0,"C");
                $this->fpdf->Cell(15,4,"$section_name",'B',0,"C");
                //$this->fpdf->Cell(4,4,"$get_y_coords",'B',0,"C");
                $this->fpdf->Ln();
                $this->Watermark();
            } else {
                $this->fpdf->Cell(5,4,"$index",'BR',0,"C");
                $this->fpdf->Cell(15,4,"$name",'B',0,"L");
                $this->fpdf->Cell(15,4,"$price",'B',0,"C");
                $this->fpdf->Cell(15,4,"$created_date",'B',0,"C");
                $this->fpdf->Cell(15,4,"$category_name",'B',0,"C");
                $this->fpdf->Cell(15,4,"$section_name",'B',0,"C");
                //$this->fpdf->Cell(4,4,"$get_y_coords",'B',0,"C");
                $this->fpdf->Ln();
            }
            
            // If this is the last item of the array, print the footer
            if($item_cell->budget_id == end($mybudget_item_array)) {
                $sum_display = chr(163) . number_format($transactions_sum, 2);
                
                $this->fpdf->SetY(-15);
                $this->fpdf->Cell(6,4,"",'T,BR',0,"C");
                $this->fpdf->Cell(30,4,"TOTAL SPENT",'T,B',0,"C");
                $this->fpdf->Cell(30,4,"$sum_display",'T,B',0,"C");
                $this->fpdf->Cell(15,4,"",'T,B',0,"C");
                $this->fpdf->Cell(15,4,"",'T,B',0,"C");
                $this->fpdf->Cell(15,4,"",'T,B',0,"C");

                $this->fpdf->SetY(-15);
                $this->Footer('End of Transaction Table', $start_date, $end_date);
            }
        
            $transactions_sum += $item_cell->price;

        }


    }

    public function Footer($descriptor, $start_date, $end_date) {

        //$this->fpdf->SetY(-15);
        //$this->fpdf->SetX(0);
        $prior_X = $this->fpdf->GetX();
        $prior_Y = $this->fpdf->GetY();

        $this->fpdf->AliasNbPages('{totalPages}');

        $this->fpdf->Cell(-10, -15, "MyBudget - $descriptor"); 

        $this->fpdf->SetY(-15);
        $this->fpdf->SetX(87);

        $this->fpdf->Cell(-10, -15, "Page " . $this->fpdf->PageNo() . "/{totalPages}");

        //$this->fpdf->Text(-15, -15, "MyBudget Footer");
        
        $this->fpdf->SetY(25);
        $this->fpdf->SetX(10);

        //$this->fpdf->Cell(-10, -15, "$start_date - $end_date"); 


    }

    public function index($start_date, $end_date) 
    {   
        $this->Header();
        
        $this->Header_Dates($start_date, $end_date);

        $this->Watermark();

        $this->Body_Summary($start_date, $end_date);
        
        $this->Body_Transactions($start_date, $end_date);

        $this->fpdf->Output();
        exit;
    }
}


// Thanks to: https://codeanddeploy.com/blog/laravel/how-to-implement-laravel-8-using-fpdf-example for tutorial

