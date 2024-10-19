$coupons = App\Models\Coupon::where('client_id',$client->id)->where('status','1')->first();
  @endphp

     @php
        $reviewcount = App\Models\Review::where('client_id',$client->id)->where('status',1)->latest()->get();
        $avarage = App\Models\Review::where('client_id',$client->id)->where('status',1)->avg('rating');
     @endphp

   <div class="col-md-3">
         <div class="item pb-3">
            <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
               <div class="list-card-image">
                  <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                  <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i>{{ number_format($avarage,1) }} ({{ count($reviewcount ) }}+)</span></div>
                  <div class="favourite-heart text-danger position-absolute"><a aria-label="Add to Wishlist" onclick="addWishList({{$client->id}})" ><i class="icofont-heart"></i></a></div>
                  @if ($coupons)
                  <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>


                  <li class="nav-item dropdown dropdown-cart">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-shopping-basket"></i> Cart
                <span class="badge badge-success">5</span>
                </a>
                <div class="dropdown-menu dropdown-cart-top p-0 dropdown-menu-right shadow-sm border-0">
                   <div class="dropdown-cart-top-header p-4">
                      <img class="img-fluid mr-3" alt="osahan" src="img/cart.jpg">
                      <h6 class="mb-0">Gus's World Famous Chicken</h6>
                      <p class="text-secondary mb-0">310 S Front St, Memphis, USA</p>
                      <small><a class="text-primary font-weight-bold" href="#">View Full Menu</a></small>
                   </div>
                   <div class="dropdown-cart-top-body border-top p-4">
                      <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i> Chicken Tikka Sub 12" (30 cm) x 1   <span class="float-right text-secondary">$314</span></p>
                      <p class="mb-2"><i class="icofont-ui-press text-success food-item"></i> Corn & Peas Salad x 1   <span class="float-right text-secondary">$209</span></p>
                      <p class="mb-2"><i class="icofont-ui-press text-success food-item"></i> Veg Seekh Sub 6" (15 cm) x 1  <span class="float-right text-secondary">$133</span></p>
                      <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i> Chicken Tikka Sub 12" (30 cm) x 1   <span class="float-right text-secondary">$314</span></p>
                      <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i> Corn & Peas Salad x 1   <span class="float-right text-secondary">$209</span></p>
                   </div>
                   <div class="dropdown-cart-top-footer border-top p-4">
                      <p class="mb-0 font-weight-bold text-secondary">Sub Total <span class="float-right text-dark">$499</span></p>
                      <small class="text-info">Extra charges may apply</small>
                   </div>
                   <div class="dropdown-cart-top-footer border-top p-2">
                      <a class="btn btn-success btn-block btn-lg" href="checkout.html"> Checkout</a>
                   </div>
             @php
             $total = 0;
             $cart = session()->get('cart',[]);
             $groupedCart = [];

             foreach ($cart as $item) {
                $groupedCart[$item['client_id']][] = $item;
             }

             $clients = App\Models\Client::whereIn('id',array_keys($groupedCart))->get()->keyBy('id');

          @endphp

          <li class="nav-item dropdown dropdown-cart">
             <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fas fa-shopping-basket"></i> Cart
             <span class="badge badge-success">{{ count((array) session('cart')) }}</span>
             </a>
             <div class="dropdown-menu dropdown-cart-top p-0 dropdown-menu-right shadow-sm border-0">

                @foreach ($groupedCart as $clientId => $items)
                @if (isset($clients[$clientId]))
                @php
                   $client = $clients[$clientId];
                @endphp
                <div class="dropdown-cart-top-header p-4">
                   <img class="img-fluid mr-3" alt="osahan" src="{{ asset('upload/client_images/' . $client->photo) }}">
                   <h6 class="mb-0">{{ $client->name }}</h6>
                   <p class="text-secondary mb-0">{{ $client->address }}</p>
                </div>
             </li>
                @endif
                @endforeach


                <div class="dropdown-cart-top-body border-top p-4">
                @php $total = 0 @endphp
                @if (session('cart'))
                @foreach (session('cart') as $id => $details)
                @php
                   $total += $details['price'] * $details['quantity']
                @endphp

                <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i>{{ $details['name'] }} x {{  $details['quantity'] }}   <span class="float-right text-secondary">${{ $details['price'] * $details['quantity'] }}</span></p>
                @endforeach
                @endif

                </div>
                <div class="dropdown-cart-top-footer border-top p-4">
                   <p class="mb-0 font-weight-bold text-secondary">Sub Total <span class="float-right text-dark">
                      @if (Session::has('coupon'))
                      ${{ Session()->get('coupon')['discount_amount'] }}
                      @else
                      ${{ $total }}
                      @endif</span></p>

                </div>
                <div class="dropdown-cart-top-footer border-top p-2">
                   <a class="btn btn-success btn-block btn-lg" href="{{ route('checkout') }}"> Checkout</a>
                </div>
             </div>
          </li>
          </ul>
       </div>
    </div>
