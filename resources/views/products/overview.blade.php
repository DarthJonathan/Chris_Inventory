 @extends('layouts.app')

 @section('content')
     <div class="row">
         <div class="col-md-8">
             <h1>Products</h1>
         </div>
         <div class="col-md-4 text-right">
             <a href="{{ url('products/new') }}" class="btn btn-primary float-right mt-1 mr-3">
                 New Product
             </a>
         </div>
     </div>
     <div class="row">
         <div class="col-lg-12 grid-margin stretch-card">
             <div class="card">
                 <div class="card-body">
                     <table class="table table-hover" id="productsOverview">
                         <thead>
                             <tr>
                                 <th style="width: 15%;">Product Name</th>
                                 <th>Details</th>
                                 <th style="width: 10%">Stock</th>
                                 <th style="width: 10%">Queue Price</th>
                                 <th style="width: 15%;">Actions</th>
                             </tr>
                         </thead>
                         {{--<tbody>--}}
                            {{--@foreach($products as $index => $product)--}}
                                {{--<tr>--}}
                                    {{--<td>{{ $index+1 }}</td>--}}
                                    {{--<td>{{ $product->product_name }}</td>--}}
                                    {{--<td style="word-wrap: break-word; white-space: normal;">--}}
                                        {{--{{ $product->description }}--}}
                                    {{--</td>--}}
                                    {{--<td style="word-wrap: break-word; white-space: normal;">--}}
                                        {{--{{ $product->stock }}--}}
                                    {{--</td>--}}
                                    {{--<td style="word-wrap: break-word; white-space: normal;">--}}
                                        {{--Rp. {{ $product->queue ? $product->queue->price : "0"}}--}}
                                    {{--</td>--}}
                                    {{--<td class="d-flex">--}}
                                        {{--<a href="{{ url('/products/edit/' . $product->id) }}" class="btn btn-primary">--}}
                                            {{--<i class="icon-pencil"></i>--}}
                                        {{--</a>--}}
                                        {{--<br>--}}
                                        {{--<form action="{{ url('/products/delete/') }}" method="post" class="ml-3">--}}
                                            {{--@csrf--}}
                                            {{--<input type="hidden" name="id" value="{{ $product->id }}">--}}
                                            {{--<button class="btn btn-danger">--}}
                                                {{--<i class="icon-trash"></i>--}}
                                            {{--</button>--}}
                                        {{--</form>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                         {{--</tbody>--}}
                         <tfoot>
                             <tr>
                                 <th style="width: 15%;">Product Name</th>
                                 <th>Details</th>
                                 <th style="width: 10%">Stock</th>
                                 <th style="width: 10%">Queue Price</th>
                                 <th style="width: 15%;">Actions</th>
                             </tr>
                         </tfoot>
                     </table>
                 </div>
             </div>
         </div>
     </div>
 @endsection