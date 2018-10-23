 @extends('layouts.admin')

 @section('content')
     <div class="row">
         <div class="col-lg-12">
             <div class="card">
                 <div class="card-body row">
                     <div class="col-md-8">
                         <h1>Products</h1>
                     </div>
                     <div class="col-md-4">
                         <a href="{{ url('products/new') }}" class="btn btn-primary float-right">
                             New Product
                         </a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-lg-12 grid-margin stretch-card">
             <div class="card">
                 <div class="card-body">
                     <table class="table table-hover" style="width: 100%; table-layout: fixed">
                         <thead>
                             <tr>
                                 <th style="width: 7%;">No</th>
                                 <th style="width: 20%;">Product Name</th>
                                 <th>Quantity</th>
                                 <th>Mean Price</th>
                             </tr>
                         </thead>
                         <tbody>
                            @foreach($inventories as $index => $inventory)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $inventory->products->product_name }}</td>
                                    <td>{{ $inventory->stock }}</td>
                                    <td>{{ $inventory->average_price }}</td>
                                </tr>
                            @endforeach
                         </tbody>
                         <tfoot>
                            <tr>
                                <td colspan="4">
                                    <div class="float-right">
                                        {{ $inventories->links() }}
                                    </div>
                                </td>
                            </tr>
                         </tfoot>
                     </table>
                 </div>
             </div>
         </div>
     </div>
 @endsection