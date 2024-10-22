@php
use Illuminate\Support\Facades\Auth;
@endphp

<nav class="main-header navbar navbar-expand navbar-white navbar-light"> 
  <!-- Left navbar links --> 
  <ul class="navbar-nav"> 
      <li class="nav-item"> 
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> 
      </li> 
      <li class="nav-item d-none d-sm-inline-block"> 
          <a href="../../index3.html" class="nav-link">Home</a> 
      </li> 
      <li class="nav-item d-none d-sm-inline-block"> 
          <a href="#" class="nav-link">Contact</a> 
      </li> 
  </ul> 
 
  <!-- Right navbar links --> 
  <ul class="navbar-nav ml-auto"> 
      <!-- Navbar Search --> 
      <li class="nav-item"> 
          <a class="nav-link" data-widget="navbar-search" href="#" role="button"> 
              <i class="fas fa-search"></i> 
          </a> 
          <div class="navbar-search-block"> 
              <form class="form-inline"> 
                  <div class="input-group input-group-sm"> 
                      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search"> 
                      <div class="input-group-append"> 
                          <button class="btn btn-navbar" type="submit"> 
                              <i class="fas fa-search"></i> 
                          </button> 
                          <button class="btn btn-navbar" type="button" data-widget="navbar-search"> 
                              <i class="fas fa-times"></i> 
                          </button> 
                      </div> 
                  </div> 
              </form> 
          </div> 
      </li> 
 
    <!-- User Info Dropdown Menu --> 
    <li class="nav-item dropdown {{ $activeMenu == 'profile' ? 'active' : '' }}"> 
        <a class="nav-link" data-toggle="dropdown" href="#"> 
            <!-- Container for Profile Image or Icon --> 
            <div class="d-flex align-items-center"> 
                @if (Auth::user()->avatar) 
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}"  
                        alt="User Avatar"  
                        class="img-circle"  
                        style="width: 30px; height: 30px;"> 
                @else 
                    <i class="fas fa-user-circle" style="font-size: 30px; color: #ccc;"></i> <!-- Default icon --> 
                @endif 
                <span class="ml-2">{{ Auth::user()->username }} ({{ Auth::user()->level->level_nama }})</span> <!-- Menampilkan nama dan level pengguna --> 
            </div> 
        </a> 
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"> 
            <!-- Link ke halaman profil --> 
            <a href="{{ route('profile') }}" class="dropdown-item {{ $activeMenu == 'profile' ? 'active' : '' }}"> 
                <i class="fas fa-user-circle mr-2"></i> Profile 
            </a> 
 
            <!-- Divider untuk memisahkan logout dari item lainnya --> 
            <div class="dropdown-divider"></div> 
 
        </div> 
    </li> 
 
      <!-- Fullscreen and Control Sidebar Options --> 
      <li class="nav-item"> 
          <a class="nav-link" data-widget="fullscreen" href="#" role="button"> 
              <i class="fas fa-expand-arrows-alt"></i> 
          </a> 
      </li> 
      <li class="nav-item"> 
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"> 
              <i class="fas fa-th-large"></i> 
          </a> 
      </li> 
  </ul> 
</nav>
