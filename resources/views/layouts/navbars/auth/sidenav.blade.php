<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
     <div class="sidenav-header text-center">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        
        <a class="navbar-brand m-0 d-block" href="{{ route('dashboard') }}">
            <!-- Logo Image (Bigger & Full Width) -->
            <img src="{{ asset('assets/img/darut-bg.jpeg') }}" alt="logo"
                style="width: 60%; max-width: auto !important; height: auto; margin-top: -70px;">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-home text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- Customer Section (Dropdown) -->
            @php
            $customerActive = request()->routeIs('customers.*');
            @endphp
            @canany(['create customer', 'view customer'])
            <li class="nav-item">
                <a class="nav-link {{ $customerActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                    href="#customerMenu" role="button" aria-expanded="{{ $customerActive ? 'true' : 'false' }}"
                    aria-controls="customerMenu">

                    <div class="d-flex align-items-center">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center ps-1">
                            <i class="fa fa-user-circle-o" style="color: #f4645f; font-size: 20px;"></i>
                        </div>
                        <span
                            class="nav-link-text ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Customer</span>
                    </div>
                </a>

                <div class="collapse {{ $customerActive ? 'show' : '' }}" id="customerMenu">
                    <ul class="nav ms-4 ps-1">
                        @can('create customer')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('customers/create') ? 'active' : '' }}"
                                href="{{ route('customers.create') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Add Customer
                            </a>
                        </li>
                        @endcan

                        @can('view customer')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('customers') ? 'active' : '' }}"
                                href="{{ route('customers.index') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Manage Customer
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany


            <!-- Project Section (Dropdown) -->
            @php
            $projectActive = request()->routeIs('projects.*');
            @endphp
            @canany(['create project', 'view project'])
            <li class="nav-item">
                <a class="nav-link  {{ $projectActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                    href="#projectMenu" role="button" aria-expanded="{{ $projectActive ? 'true' : 'false' }}"
                    aria-controls="projectMenu">

                    <div class="d-flex align-items-center">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center ps-1">
                            <i class="fa fa-file-text" style="color: #f4645f; font-size: 20px;"></i>
                        </div>
                        <span
                            class="nav-link-text ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Project</span>
                    </div>
                </a>
                <div class="collapse {{ $projectActive ? 'show' : '' }}" id="projectMenu">
                    <ul class="nav ms-4 ps-1">
                        @can('create project')
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'projects/create') ? 'active' : '' }}"
                                href="{{ route('projects.create') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Add Project
                            </a>
                        </li>
                        @endcan
                        @can('view project')
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'projects') ? 'active' : '' }}"
                                href="{{ route('projects.index') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Manage Project
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany

            <!-- Project Expense Section (Dropdown) -->

            @php
            $expenseActive = request()->routeIs('expenses.*') || request()->routeIs('categories.*');
            @endphp
            @canany(['create expense', 'view expense' ,'view expenses-categorie', 'create expenses-categorie'])
            <li class="nav-item">
                <a class="nav-link {{ $expenseActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                    href="#expenseMenu" role="button" aria-expanded="{{ $expenseActive ? 'true' : 'false' }}"
                    aria-controls="expenseMenu">
                    <div class="d-flex align-items-center">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center ps-1">
                            <i class="fa fa-credit-card" style="color: #f4645f; font-size: 20px;"></i>
                        </div>
                        <span class="nav-link-text ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Project
                            Expense</span>
                    </div>
                </a>
                <div class="collapse {{ $expenseActive ? 'show' : '' }}" id="expenseMenu">
                    <ul class="nav ms-4 ps-1">
                        @can('view expense')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('expenses/create') ? 'active' : '' }}"
                                href="{{ route('expenses.create') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Expense Create
                            </a>
                        </li>
                        @endcan
                        @can('create expense')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('expenses') ? 'active' : '' }}"
                                href="{{ route('expenses.index') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Expense List
                            </a>
                        </li>
                        @endcan
                        @can('create expenses-categorie')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('categories/create') ? 'active' : '' }}"
                                href="{{ route('categories.create') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Ex. Category Create
                            </a>
                        </li>
                        @endcan
                        @can('view expenses-categorie')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('categories') ? 'active' : '' }}"
                                href="{{ route('categories.index') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Ex. Category List
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany

            <!-- Installment Section (Dropdown) -->
            @php
            $installmentActive = request()->routeIs('investments.*');
            @endphp
            @canany(['view installment', 'create installment'])
            <li class="nav-item">
                <a class="nav-link {{ $installmentActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                    href="#installmentMenu" role="button" aria-expanded="{{ $installmentActive ? 'true' : 'false' }}"
                    aria-controls="installmentMenu">

                    <div class="d-flex align-items-center">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center ps-1">
                            <i class="fa fa-file-text" style="color: #f4645f; font-size: 20px;"></i>
                        </div>
                        <span
                            class="nav-link-text ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Installments</span>
                    </div>
                </a>

                <div class="collapse {{ $installmentActive ? 'show' : '' }}" id="installmentMenu">
                    <ul class="nav ms-4 ps-1">
                        <li class="nav-item">
                            @can('create installment')
                            <a class="nav-link {{ request()->routeIs('investments.create') ? 'active' : '' }}"
                                href="{{ route('investments.create') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Add Installments
                            </a>
                        </li>
                        @endcan
                        @can('view installment')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('investments.index') ? 'active' : '' }}"
                                href="{{ route('investments.index') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Manage Installments
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany


             <!-- Income Section (Dropdown) -->
            @php
            $incomeActive = request()->routeIs('incomes.*')  || request()->routeIs('income-categories.*');;
            @endphp
            @canany(['view income', 'create income'])
            <li class="nav-item">
                <a class="nav-link {{ $incomeActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                    href="#incomeMenu" role="button" aria-expanded="{{ $incomeActive ? 'true' : 'false' }}"
                    aria-controls="incomeMenu">

                    <div class="d-flex align-items-center">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center ps-1">
                            <i class="fa fa-money" style="color: #f4645f; font-size: 20px;"></i>
                        </div>
                        <span
                            class="nav-link-text ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Incomes</span>
                    </div>
                </a>

                <div class="collapse {{ $incomeActive ? 'show' : '' }}" id="incomeMenu">
                    <ul class="nav ms-4 ps-1">
                        <li class="nav-item">
                            @can('create income')
                            <a class="nav-link {{ request()->routeIs('incomes.create') ? 'active' : '' }}"
                                href="{{ route('incomes.create') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Add Income
                            </a>
                        </li>
                        @endcan
                        @can('view income')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('incomes.index') ? 'active' : '' }}"
                                href="{{ route('incomes.index') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Manage Incomes
                            </a>
                        </li>
                        @endcan

                            @can('create income-categorie')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('income-categories/create') ? 'active' : '' }}"
                                href="{{ route('income-categories.create') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                In. Categorie Create
                            </a>
                        </li>
                        @endcan
                        @can('view income-categorie')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('income-categories') ? 'active' : '' }}"
                                href="{{ route('income-categories.index') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                 In. Categorie List
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany

            <!-- Report Section (Dropdown) -->
            @php
            $commissionActive = request()->routeIs('commission.*') || request()->routeIs('report.*') || request()->routeIs('expense.*');
            @endphp
            @canany(['view commission-report', 'view commission-history'])
            <li class="nav-item">
                <a class="nav-link {{ $commissionActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                    href="#commissionMenu" role="button" aria-expanded="{{ $commissionActive ? 'true' : 'false' }}"
                    aria-controls="commissionMenu">

                    <div class="d-flex align-items-center">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center ps-1">
                            <i class="fa fa-crosshairs" style="color: #f4645f; font-size: 20px;"></i>
                        </div>
                        <span
                            class="nav-link-text ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Report</span>
                    </div>
                </a>

                <div class="collapse {{ $commissionActive ? 'show' : '' }}" id="commissionMenu">
                    <ul class="nav ms-4 ps-1">
                        @can('view commission-report')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('commission.report') ? 'active' : '' }}"
                                href="{{ route('commission.report') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Commission Report
                            </a>
                        </li>
                        @endcan
                        @can('view commission-history')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('commission.withdrawal.history') ? 'active' : '' }}"
                                href="{{ route('commission.withdrawal.history') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                C. Withdrawal History
                            </a>
                        </li>
                        @endcan
                        @can('view commission-history')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('report.project') ? 'active' : '' }}"
                                href="{{ route('report.project') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Project Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('expense.report') ? 'active' : '' }}"
                                href="{{ route('expense.report') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                               Expense Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('category.expense.report') ? 'active' : '' }}"
                                href="{{ route('category.expense.report') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                               Category Expense Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('yearly.report') ? 'active' : '' }}"
                            href="{{ route('yearly.report') }}">
                                <i class="fa fa-calendar text-dark text-sm opacity-10 me-2"></i>
                                Yearly Financial Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.customer.summary') ? 'active' : '' }}"
                            href="{{ route('reports.customer.summary') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Customer Summary Report
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany


              <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'promotion.sms' ? 'active' : '' }}"
                    href="{{ route('promotion.sms') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-envelope text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Promotonal SMS</span>
                </a>
            </li>
            <!-- User Section (Dropdown) -->

            @php
            $userActive = request()->routeIs('users.*');
            @endphp
            @canany(['view user'])
            <li class="nav-item">
                <a class="nav-link {{ $userActive ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#userMenu"
                    role="button" aria-expanded="{{ $userActive ? 'true' : 'false' }}" aria-controls="userMenu">
                    <div class="d-flex align-items-center">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center ps-1">
                            <i class="fa fa-user" style="color: #f4645f; font-size: 20px;"></i>
                        </div>
                        <span class="nav-link-text ms-2 text-uppercase text-xs font-weight-bolder opacity-6">User and
                            Role</span>
                    </div>
                </a>

                <div class="collapse {{ $userActive ? 'show' : '' }}" id="userMenu">
                    <ul class="nav ms-4 ps-1">
                        @can('view user')
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'user-management') == true ? 'active' : '' }}"
                                href="{{ route('users.index') }}">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('backup-form').submit();">
                                <i class="fa fa-circle text-dark text-sm opacity-10 me-2"></i>
                                Backup
                            </a>
                            <form id="backup-form" action="{{ route('backup.download') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>

                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany
        </ul>
    </div>

</aside>
