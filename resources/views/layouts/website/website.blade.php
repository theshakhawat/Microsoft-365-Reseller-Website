@include('layouts.website.header')

  <main class="flex-grow">
        @yield('content')
  </main>

  <!-- ========================================== -->
  <!-- COMPONENT: FOOTER                          -->
  <!-- ========================================== -->
    @include('layouts.website.footer')
