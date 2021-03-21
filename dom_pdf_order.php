<?php
# =======  PDF file Upload, View, Download  ========== #
#===============================================================================

# Data export PDF formate use Package
Package-link: "https://github.com/barryvdh/laravel-dompdf"
#---------------------------------------------------------

# Command for install package name "domPDF"--(pdf converter)
composer require barryvdh/laravel-dompdf
#===============================================================================

# add the ServiceProvider to the providers array in "config/app.php"
Barryvdh\DomPDF\ServiceProvider::class,   //inside "provider"
'PDF' => Barryvdh\DomPDF\Facade::class,   //inside "aliases"
#===============================================================================

/* The defaults configuration settings are set in "config/dompdf.php".
Copy this file to your own config directory to modify the values. */
# -----------  OR  --------------
#You can publish the config using this command:
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
#===============================================================================

# make button/link for view & download .
# Example...
<a href="{{ url('download/pdf_order_data') }}/{{ $order->id }}">Download or view PDF</a>
# $order -- Order details veriable (example)
#===============================================================================

# Route -- (Laravel-8 route)
# Example...
Route::get("/download/pdf_order_data/{id}", [CustomerController::class, "pdf_order_data"]);
#===============================================================================

# Controller -- take data from database
# Example...
public function pdf_order_data($id){
    $order = Order::find($id);
    $pdf = PDF::loadView("admin.pdf.pdf_order", compact("order"));

    return $pdf->download('myOrder.pdf');       # for download
    #---------  OR  ----------#
    // return $pdf->stream("myOrder.pdf");      # for pdf view on browser
}
#===============================================================================

# *** At last create blade file as you wish
#------------------------------------------
// in "pdf_order.blade.php" -- file make for view pdf -- Can not use "@section"
# Example...
<!doctype html>
<html lang="en">
<head>
    // <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Order details</title>
    <style>
         p {
            background: gray !important;
            padding: 3px 10px;
            font-size: 16px;
        }
        h5 {
            margin-bottom: 15px;
            color: blue;
            font-family: "sans-serif" !important;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-12 pt-4">
            <h3 class="text-success text-center"> <strong>Order Information</strong> </h3>

            // <!-- Product Table -->
            <h5 class="text-info">Product Details</h5>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Product Name</th>
                        <th>Color & Size</th>
                        <th>Price/<small>pcs</small> x Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $ordered_product_info = App\Models\OrderProductDetails::where("order_transaction_id", $order->transaction_id)->get();
                    @endphp
                    @foreach ($ordered_product_info as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>
                                Color : {{ $product->color }} <br>
                                Size : {{ $product->size }}
                            </td>
                            <td>{{ $product->single_price }} x {{ $product->quantity }}</td>
                            <td class="text-right">{{ $product->total_price }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="thead-light">
                    <tr>
                        <th ></th>
                        <th colspan="4" class="text-right">
                            Tax : (+) {{ $order->tax }} <br>
                            Coupon : (-) {{ $order->coupon }} <br>
                            <b>Total : {{ $order->amount }}</b>
                        </th>
                    </tr>
                </tfoot>
            </table>
            // <!-- / Product Table -->

            // <!-- Customer details-->
            <div>
                <h5 class="text-info">User / Customer Details</h5>
                <p>Order-ID : <b>{{ $order->transaction_id }}</b></p>
                <p> Name : <b>{{ $order->relation_user->name }}</b> </p>
                <p> Phone : <b>{{ $order->relation_user->phone }}</b> </p>
                <p> Email : <b>{{ $order->relation_user->email }}</b> </p>
            </div>
            <br>
            // <!-- / Customer details -->

            // <!-- Shipping address details -->
            <div>
                <h5 class="text-info">Shipping Address Details</h5>
                <p> Shipping Name : <b>{{ $order->name }}</b> </p>
                <p> Email : <b>{{ $order->email }}</b> </p>
                <p> Phone : <b>{{ $order->phone }}</b> </p>
                <p> Country : <b>{{ $order->country }}</b> </p>
                <p> District / City : <b>{{ $order->city }}</b> </p>
                <p> Upazila : <b>{{ $order->upazila }}</b> </p>
                <p> Union : <b>{{ $order->union_bd }}</b> </p>
                <p> Post-Office : <b>{{ $order->postoffice }}</b> </p>
                <p> Postcode : <b>{{ $order->zip_code }}</b> </p>
                <p> Address : <b>{{ $order->address }}</b> </p>
            </div>
            <br>
            // <!-- / Shipping address details -->

        </div>
    </div>
</div>

</body>
</html>

#===============================================================================
//=== END ===//
