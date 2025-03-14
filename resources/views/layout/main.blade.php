<!doctype html>
<html lang="en">
  <!--begin::Head-->
  @include('layout.head')
  <!--end::Head-->
  <!--begin::Body-->
  <body class="sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      @include('layout.topnav')
      <!--end::Header-->
      <!--begin::Sidebar-->
      @include('layout.leftmenu')
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          @yield('main')
        </div>
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      @include('layout.footer')
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    @include('layout.scripts')
  </body>
  <!--end::Body-->
</html>





{{-- <!DOCTYPE html>
<html lang="en">
@include('layout.head')
<body>
    
    @yield('main')

    @yield('scripts')
</body>
</html> --}}