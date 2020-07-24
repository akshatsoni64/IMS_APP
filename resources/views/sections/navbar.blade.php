@section('navbar')
    <div id="nav-div" class="pl-3 col-xl-2 border border-top-0 border-left-0 border-bottom-0">
        <p align="center" class="font-weight-bold">Menu</p> 

        <div class="mb-3 card bg-dark text-white text-center">
            <h5 class="pt-2">                
                <a class="text-white" href="{{ route('home') }}">
                    Dashboard
                </a>
            </h5>
        </div>

        <div class="mb-3 card bg-dark text-white text-center">
            <h5 class="pt-2 ml-2">
                Master 
                <button class="btn btn-dark rounded-circle ml-2" id="master">
                    <i class="fa fa-angle-down"></i>
                </button>                            
            </h5>
        </div>
        <div id="master-div">
            <div class="mb-3 card bg-light text-white text-center border border-primary">
                <h5 class="pt-2">
                    <a class="text-dark" href="{{ route('customer.index') }}">Customer</a>
                </h5>
            </div>
            <div class="mb-3 card bg-light text-white text-center border border-primary">
                <h5 class="pt-2">                    
                    <a class="text-dark" href="{{ route('product.index') }}">Product</a>
                </h5>
            </div>
            <div class="mb-3 card bg-light text-white text-center border border-primary">
                <h5 class="pt-2">                
                    <a class="text-dark" href="{{ route('stock.index') }}">Opening Stock</a>
                </h5>
            </div>
        </div>        

        <div class="mb-3 card bg-dark text-white text-center">
            <h5 class="pt-2">                
                <a class="text-white" href="{{ route('transaction.index') }}">
                    Transactions
                </a>
            </h5>
        </div>

        <div class="mb-3 card bg-dark text-center">
            <h5 class="pt-2">
                <a class="text-white" href="{{ route('report') }}">
                    Report
                </a>
            </h5>
        </div>

        <div class="mb-3 card bg-dark text-white text-center">
            <h5 class="pt-2">
                <a class="text-white" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
            </h5>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
@endsection