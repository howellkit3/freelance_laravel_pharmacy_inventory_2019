<?php $asset = URL::asset(''); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Pharmacy Inventory System</title>

         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link href="{{ asset('css/default-index.css') }}" rel="stylesheet">
        <script src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
    </head>
    <body>
        <div class="wrapper">
            <!-- Sidebar Holder -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Pharmacy Inventory System</h3>
                </div>

                <ul class="list-unstyled components">
                    <!-- <li class="active">
                        <a href="{{ route('home') }}">Home</a>
                    </li> -->

                    <li>
                      <a href="{{ route('stocks') }}">Stocks</a>
                    </li>

                    <li>
                      <a href="{{ route('stock_search') }}">Over All Stocks</a>
                    </li>

                    <!-- <li>
                        <a href="#admin" data-toggle="collapse" aria-expanded="false">Admin</a>
                        <ul class="collapse list-unstyled" id="admin">
                            <li><a href="/categories">Category</a></li>
                            <li><a href="/brands">Brand</a></li>
                            <li><a href="/generics">Generic</a></li>
                        </ul>
                    </li> -->
                    <!-- <li>
                        <a href="{{ route('daily_sales') }}">Sales Log</a>
                    </li> -->
                    <li>
                        <a href="{{ route('sales_report') }}">Daily Sales</a>
                    </li>
                    <!-- <li>
                        <a href="#pageSuppliers" data-toggle="collapse" aria-expanded="false">Suppliers</a>
                        <ul class="collapse list-unstyled" id="pageSuppliers">
                            <li><a href="{{ route('suppliers') }}">List</a></li>
                        </ul>
                    </li> -->
                </ul>
            </nav>

            <!-- Page Content Holder -->
            <div id="content">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                                <i class="glyphicon glyphicon-align-left"></i>
                                <span></span>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right">
                                @guest
                                  <li>
                                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                  </li>
                                  @if (Route::has('register'))
                                    <li>
                                        <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                  @endif
                                @else

                                  <li>
                                      <a href="#user-logout" data-toggle="collapse" id="user-logout-before" aria-expanded="false">Admin</a>
                                      <ul class="collapse list-unstyled" id="user-logout">
                                        <li>
                                          <a class="dropdown-item user-logout-a" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                          </a>
                                        </li>
                                      </ul>

                                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                          @csrf
                                      </form>
                                  </li>

                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>
                @include('flash-message')
                @yield('content')

            </div>
        </div>

        <!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
         </script>
    </body>
</html>
