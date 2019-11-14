<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('images/dummy-profile.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li{{ Request::path() === 'list/example-category' ? ' class=active' : ''}}>
                <a href="{{url('list/example-category')}}">
                    <i class="fa fa-folder"></i> <span>Example Categories</span>
                </a>
            </li>
            <li{{ Request::path() === 'list/example' ? ' class=active' : ''}}>
                <a href="{{url('list/example')}}">
                    <i class="fa fa-th"></i> <span>Examples</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
