  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="http://www.agence.com.br/" class="brand-link d-flex justify-content-center">
      <img src="imgs/agence.png" alt="Agence Logo"  style="opacity: .8">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="imgs/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Nome do usuário</a>
          
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open ">
            <a href="{{url('/under_construction')}}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
               Agence
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  href="{{url('/under_construction')}}" class="nav-link">
                <i class="nav-icon fas fa-folder-open"></i>
                <p>
                 Projetos
                </p>
              </a>
          </li>
          <li class="nav-item">
            <a  href="{{url('/under_construction')}}" class="nav-link">
                <i class="nav-icon fas fa-archive"></i>
                <p>
                 Administrativo
                </p>
              </a>
          </li>
          <li class="nav-item menu-is-opening menu-open">
            <a  href="#" class="nav-link">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Comercial
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/con_desempenho')}}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Performance Comercial</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item">
            <a  href="{{url('/under_construction')}}" class="nav-link">
                <i class="nav-icon fas fa-recycle"></i>
                <p>
                 Financeiro
                </p>
              </a>
          </li>
         <hr/>

         <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-times"></i>
                <p>
                   Sair
                </p>
              </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>