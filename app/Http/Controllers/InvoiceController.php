<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
           
            $invoices = Invoice::with('user')->paginate(10);
             
            if($invoices){
                return response()->json($invoices);
            }else{
                return response()->json(array( 'code' =>  404,
                'error'   =>  'Invoices not found'),404); 
            }
            
        } catch (\Exception $e) {             
            return response()->json(array(
                'code'      =>  404,
                'error'   =>  $e->getMessage()
            ), 404);   
        }
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        try{  
            if($request->hasFile('invoice_image'))
            {
                $invoiceName = time().'.'.$request->invoice_image->extension();        
                $request->invoice_image->move(public_path('images'), $invoiceName);
            }
            if($request->hasFile('invoice_coverLetter_image'))
            {
                $invoiceCoverLetterImageName = time().'.'.$request->invoice_coverLetter_image->extension();        
                $request->invoice_coverLetter_image->move(public_path('images'), $invoiceCoverLetterImageName);
            }
         
                $invoice = new Invoice();
                $invoice->invoice_number = $request->invoice_number;
                $invoice->invoice_date = $request->invoice_date;
                $invoice->invoice_amount = $request->invoice_amount;
                $invoice->invoice_image = 'images/'.$invoiceName;
                $invoice->user_id = Auth::user()->id;
                if(!empty($request->invoiceCoverLetterImageName)){
                    $invoice->invoice_coverLetter_image = 'images/'.$invoiceCoverLetterImageName; 
                }else{
                    $invoice->invoice_coverLetter_image = 'images/NoCoverLetter';
                }
                       
                $invoice->save();
                return response()->json(array(
                    'code'      => 200,
                    'success'   => 'Invoice created successfully'
                ), 200);

        }catch (\Exception $e){
            return response()->json(array(
                'code'      => 404,
                'error'   => $e->getMessage()
            ), 404);
        }       

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    { 
        try
            {
               $invoice = Invoice::findOrFail($invoice->id);
               if($invoice){
                return response()->json($invoice);
                }else{  
                    return response()->json(array(
                        'code'      =>  404,
                        'error'   =>  $e->getMessage()
                    ), 404);  
                }
            }
            // catch(Exception $e) catch any exception
            catch(ModelNotFoundException $e)
            {           
                return response()->json(array(
                    'code'      => 404,
                    'error'   => $e->getMessage()
                ), 404);
            }
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
         
        $invoice->invoice_number = $request->invoice_number;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->invoice_amount = $request->invoice_amount;
        $invoice->invoice_date = $request->invoice_date;
        
            if($request->hasFile('invoice_image'))
            {
                $file = $invoice->invoice_image;
                $invoiceName = time().'.'.$request->invoice_image->extension();        
                $request->invoice_image->move(public_path('images'), $invoiceName);
                unlink($file);                
                $invoice->invoice_image =  $invoiceName ;
            }
            if($request->hasFile('invoice_coverLetter_image'))
            {
                $invoiceCoverLetterImageName = time().'.'.$request->invoice_coverLetter_image->extension();        
                $request->invoice_coverLetter_image->move(public_path('images'), $invoiceCoverLetterImageName);
                $invoice->invoice_image =  $invoiceCoverLetterImageName ;
            }
            $invoice->update();
            return response()->json(array(
                'code'      => 200,
                'success'   => 'Invoice updated successfully'
            ), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }


}